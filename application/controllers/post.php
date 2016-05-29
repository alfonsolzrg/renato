<?php
class Post extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'user_model' );
	}

	public function index() {
		$data = $this->_get_data();
		$this->load->view ( 'html_open' );
		$this->load->view ( 'head', array (
				'section' => 'Publicaciones'
		));
		$this->load->view ( 'body_open' );
		$this->load->view ( 'facebook_js_sdk' );
		$this->load->view ( 'header' );
		$this->load->view ( 'post/main', $data );
		$this->load->view ( 'footer' );
		$this->load->view ( 'body_close' );
		$this->load->view ( 'html_close' );
	}
	
	private function _get_data(){
		$data = array();
		$posts = $this->facebook->getPagePostsIds();
		if( array_key_exists('data', $posts) ){
			$data['posts'] = $posts['data'];
			$data['ids'] = $this->_get_posts_ids($posts['data']);
			$data['next'] = $posts['paging']->next;
		}else{
			$data['posts'] = array();
			$data['ids'] = array();
			$data['next'] = 'no_more_posts';
		}
		return $data;
	}
	
	private function _get_posts_ids($posts){
		$ids = [];
		foreach($posts as $post){
			$id = explode('_', $post->id);
			array_push($ids, $id[1]);
		}
		return $ids;
	} 
}