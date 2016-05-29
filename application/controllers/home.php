<?php

class Home extends CI_Controller{
	
	function index(){	
		$this->load->view('html_open');
		$this->load->view('home/head');
		$this->load->view('body_open');
		$this->load->view('facebook_js_sdk');
		$this->load->view('header');
		$this->load->view('home/main');
		$this->load->view('footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	}
	
	function contacto(){
		$novedades['novedades'] = $this->campociudadDB->novedades();
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/content_start');
		$this->load->view('back-end/contacto');
		$this->load->view('back-end/content_end',$novedades);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	
	}
	
	
	function equipo(){
		$todo['colaboradores']=$this->campociudadDB->get_colaboradores();
		$novedades['novedades'] = $this->campociudadDB->novedades();
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/content_start');
		$this->load->view('back-end/equipo',$todo);
		$this->load->view('back-end/content_end',$novedades);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	
	}
	function contacto_form(){
		$data['mensaje'] = strip_tags( $this->input->post('mensaje') );
		$data['nombre'] = strip_tags( $this->input->post('nombre') );
		$this->campociudadDB->contacto($data);
		echo 'Tu mensaje ah sido enviado';
	}
	function ver_entrada($id_post){
		$datos['datos']=$this->campociudadDB->get_entry($id_post);
		$novedades['novedades'] = $this->campociudadDB->novedades();
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/content_start');
		$this->load->view('back-end/entry',$datos);
		$this->load->view('back-end/content_end',$novedades);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');
	}
	function blog(){
		$novedades['novedades'] = $this->campociudadDB->novedades();
		$offset=(int)$this->uri->segment(3);
		$per_page=10;
		$total=(int)$this->campociudadDB->total_publicados();
		$base_url=site_url('home/blog');
		$datos['datos']=$this->campociudadDB->blog($per_page,$offset);
		$this->load->library('pagination');
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Ultimo';
		$config['next_link'] = 'Siguiente';
		$config['prev_link'] = 'Anterior';
		$config['full_tag_open'] = '<p style="text-align:center">';
		$config['full_tag_close'] = '</p>';
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);	
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/content_start');
		$this->load->view('back-end/blog',$datos);
		$this->load->view('back-end/content_end',$novedades);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');	
	}
	function galeria(){
		$albums['albums']=$this->get_lista_albums();
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/galeria',$albums);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');	
	
	
	}
	function get_lista_fotos($path){
		$dir = scandir($path);
		$resultado= array();
		foreach($dir as $key){
			if($key!='.' && $key!='..' && $key!='_thumb'){
				$info=pathinfo($key);
				$ext=$info['extension'];
				$ext = strtolower($ext) ;
				if( ($ext == 'jpg') ||
					($ext == 'png') ||  
					($ext == 'jpeg')|| 
					($ext == 'jpe') || 
					($ext == 'gif') 
				){
					
					$resultado[]=$key;
				}
			}
		}
		return $resultado;
	
	}
	function ver_album($album){
		$path="colaboradores_files/fotos/".$album;
		$data['fotos'] = $this->get_lista_fotos($path);
		$data['album']= $album;
		$data['url']=base_url().'colaboradores_files/fotos/';
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/album',$data);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');	
	
	}
	function audio(){
		$mp3s="";
		$mp3s=$this->get_lista_audio();	
		$todo['mp3s']=$mp3s;
		$this->load->view('html_open');
		$this->load->view('back-end/head_index');
		$this->load->view('body_open');
		$this->load->view('back-end/header_start');
		$this->load->view('back-end/nav');
		$this->load->view('back-end/header_end');
		$this->load->view('back-end/audio',$todo);
		$this->load->view('back-end/footer');
		$this->load->view('body_close');
		$this->load->view('html_close');	
	
	}
	function get_lista_albums(){
		$dir = scandir('colaboradores_files/fotos/');
		$resultado= array();
		foreach($dir as $key){
			if($key!='.' && $key!='..'){
				$info=pathinfo($key);
				
				if(!isset($info['extension']))
					$resultado[]=$key;
			}
		}
		return $resultado;
	}
	function get_lista_audio(){
		$path="colaboradores_files/audio/";
		$dir = scandir($path);
		$resultado= array();
		foreach($dir as $key){
			if($key!='.' && $key!='..' ){
				$info=pathinfo($key);
				$ext=$info['extension'];
				$ext = strtolower($ext) ;
				if($ext == 'mp3'){
					$resultado[]=$key;
				}
			}
		}
		return $resultado;
	}

}
?>