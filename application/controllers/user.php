<?php
class User extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	}
	
	function index(){
		$data = $this->_load_user_data();
		$this->_set_validation_rules($data['isColaborador']);
		$this->load->view('html_open');
		$this->load->view('head', array("section"=>"Usuario"));
		$this->load->view('body_open');
		$this->load->view('facebook_js_sdk');
		$this->load->view('header');
		if ($this->form_validation->run() == false){
			$this->load->view('user/main', $data);
		}else{
			$result = $this->_save_user();
			$this->load->view($result['result'], $result['message']);
		}
		$this->load->view('footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	}
	
	private function _set_validation_rules($isColaborador){
		$this->form_validation->set_message('_validate_token', 'El token no es válido.');
		$this->form_validation->set_message('_validate_username', 'El usuario ya se encuentra registrado.');
		if(!$isColaborador){
			$this->form_validation->set_rules('token', 'token', 'required|callback__validate_token');
			$this->form_validation->set_rules('username', 'Username', 'required|callback__validate_username|min_length[5]|max_length[16]|');
		}else{
			$this->form_validation->set_rules('username', 'Username', 'required');
		}
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('profile', 'Perfil', 'required|max_length[45]');
		$this->form_validation->set_rules('about', 'Acerca de mi', 'required|max_length[500]|');
	}
	
	public function _validate_token($token){
		return $this->user_model->is_token_valid($token);
		
	}
	
	public function _validate_username($username){
		return $this->user_model->is_username_unique($username);
	
	}
	
	private function _save_user(){
		try{
			$operation = $_POST['operation'];
		
			if($operation == 'signin'){
				$user = array(
						'username'=>$_POST['username'],
						'email' => $_POST['email'],
						'facebook_id' => $_POST['facebook_id'],
						'about' => $_POST['about'],
						'profile' => $_POST['profile'],
						'name' => $_POST['name']
				);
				$this->user_model->save_user($user, 'ROL_COLABORADOR');
				$message = array(
						'heading' => 'Registro',
						'message' => '¡Registro exitoso! Ya puedes usar campo-ciudad como colaborador.'
				);
				return array('result'=>'success', 'message' => $message);
			}else if($operation == 'update'){
				$user = array(
						'username'=>$_POST['username'],
						'email' => $_POST['email'],
						'about' => $_POST['about'],
						'profile' => $_POST['profile'],
						'name' => $_POST['name']
				);
				$this->user_model->update_user($user);
				$message = array(
						'heading' => 'Actualizacion',
						'message' => 'Tus datos se han actualizado.'
				);
				return array('result'=>'success', 'message' => $message);
			}
		}catch(Exception $e){
			$message = array(
					'heading' => 'Error Registro',
					'message' => 'Hubo un error a nivel BD. no se puede registrar al usuario'
			);
			return array('result'=>'error', 'message' => $message);
		}
	}
	
	private function _load_user_data(){
		$isColaborador = false;
		$data = array();
		$fuser = $this->facebook->get_user();
		$data['profile'] = '';
		$data['about'] = '';
		$data['email'] = '';
		$data['name'] = '';
		if($fuser){
			if(array_key_exists('middle_name', $fuser)){
				$data["username"] = $this->_generate_username($fuser["middle_name"]);
			}else{
				$data["username"] = $this->_generate_username($fuser["name"]);
			}
			if(array_key_exists('email', $fuser)){
				$data['email'] = $fuser['email'];
			}
			$data["name"] = $fuser["name"];
			$data["facebook_id"] = $fuser["id"];
			$user = $this->user_model->get_user_by_facebook_id($fuser["id"]);
			if($user) {
				$data["username"] = $user['username'];
				$data["profile"] = $user['profile'];
				$data["about"] = $user['about'];
				$data["name"] = $user['name'];
				$isColaborador = true;
			}
		}
		$data["isColaborador"] = $isColaborador;
		$data["fuser"] = $fuser;
		return $data;
	}
	
	private function _generate_username($midlename){
		return str_replace(' ','.',strtolower ( $midlename ));
	}
	
}
