<?php
class Audio extends CI_Controller{
	
	function index(){
		$data['files'] = $this->get_audio_list();
		$this->load->view('html_open');
		$this->load->view('audio/head');
		$this->load->view('body_open');
		$this->load->view('facebook_js_sdk');
		$this->load->view('header');
		$this->load->view('audio/main', $data);
		$this->load->view('footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	}

	function get_audio_list(){
		$url = "http://media.campo-ciudad.org/audio/";
		$html = file_get_contents($url);
		preg_match_all( '/<a[^>]*href=[\"|\'](.*mp3)[\"|\']/Ui', $html, $out, PREG_PATTERN_ORDER);
		$resultado= array();
		foreach($out[1] as $mp3){
			$resultado[]=array( "mp3" => $mp3, "name" => urldecode ( $mp3 ));
		}
		return $resultado;
	}
	
}
