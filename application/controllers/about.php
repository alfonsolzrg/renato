<?php
class About extends CI_Controller{

	function index(){
		$this->load->view('html_open');
		$this->load->view ( 'head', array (
				'section' => 'Historia'
		));
		$this->load->view('body_open');
		$this->load->view('facebook_js_sdk');
		$this->load->view('header');
		$this->load->view('about/main');
		$this->load->view('footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	}

	

}
