<?php
class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_user_by_facebook_id($facebookId){
		$query = $this->db->get_where('user', 
				array('facebook_id' => $facebookId));
		return $query->row_array();
	}
	
	function get_user_by_username($username){
		$query = $this->db->get_where('user',
				array('username' => $username));
		return $query->row_array();
	}
	
	function save_user($user, $rol){
		$this->db->trans_start();
		$this->db->insert('user', $user);
		$rol_user = array(
				'username' => $user['username'],
				'rol' => $rol,
		);
		$this->db->insert('rol_user', $rol_user);
		$activity = array(
				'username' => $user['username'],
				'event_type'=> 'REGISTRO_DE_USUARIO',
				'description' => "Se registro al usuario: {$user['username']} "
		);
		$this->db->insert('activity', $activity);
		$this->db->trans_complete();
		if ($this->db->trans_status() == FALSE){
			$this->db->trans_rollback();
			throw new Exception("No se pudo registrar al usuario.", "1001");
		}
		else{
			$this->db->trans_commit();
		}
	}
	
	function update_user($user) {
		$this->db->trans_start();
		$this->db->update('user', $user);
		$activity = array(
				'username' => $user['username'],
				'event_type'=> 'ACTUALIZACION_DE_USUARIO',
				'description' => "Se actualizo la info del usuario: {$user['username']} "
		);
		$this->db->insert('activity', $activity);
		$this->db->trans_complete();
		if ($this->db->trans_status() == FALSE){
			$this->db->trans_rollback();
			throw new Exception("No se pudo actualizar al usuario.", "1002");
		}
		else{
			$this->db->trans_commit();
		}
	}
	
	function is_token_valid($token){
		$tokens = $this->db->get('token')->row_array();
		$md5 = md5($token);
		foreach ($tokens as $t ){
		 	if($md5 == $t){
		 		return true;
		 	}
		}
		return false;
	}
	
	function get_collaborators(){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('rol_user', 'user.username = rol_user.username');
		$this->db->where('rol_user.rol','ROL_COLABORADOR');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function is_username_unique($username){
		$user = $this->get_user_by_username($username);
		if($user){
			return false;
		}
		return true;
	}
}