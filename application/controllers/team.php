<?php
class Team extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'user_model' );
	}
	
	public function index() {
		$data = array();
		$data['collaborators'] = $this->_load_collaborator_data();
		$this->load->view ( 'html_open' );
		$this->load->view ( 'head', array (
				'section' => 'Equipo' 
		) );
		$this->load->view ( 'body_open' );
		$this->load->view ( 'facebook_js_sdk' );
		$this->load->view ( 'header' );
		$this->load->view ( 'team/main', $data );
		$this->load->view ( 'footer' );
		$this->load->view ( 'body_close' );
		$this->load->view ( 'html_close' );
	}
	
	private function _load_collaborator_data(){
		$data = $this->user_model->get_collaborators();
		return $data;
	}
}