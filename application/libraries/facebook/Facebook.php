<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
if (session_status () == PHP_SESSION_NONE) {
	session_start ();
}

// Autoload the required files
require_once (APPPATH . 'libraries/facebook/autoload.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\Entities\AccessToken;

class Facebook {
	var $ci;
	var $helper;
	var $session;
	var $facebook;
	var $appSession;
	
	public function __construct() {
		$this->ci = & get_instance ();
		$this->ci->load->library ( 'session' );
		$this->facebook = $this->ci->config->item ( 'facebook' );
		FacebookSession::setDefaultApplication( $this->facebook ['api_id'], 
			$this->facebook ['app_secret'] );
		$this->helper = new FacebookJavaScriptLoginHelper($this->facebook ['api_id'],
				$this->facebook ['app_secret']);
		$token = '';
		try {
			$session =  $this->helper->getSession();
			
			if(!$session){
				$this->session = false;
				throw new Exception("No se pudo cargar la sesion javascript.");
			}else{
				if($session->validate()){
					$this->session = $session;
					$_SESSION["token"] =  $session->getToken();
				}else{
					$this->session = false;
					throw new Exception("La session no pudo ser validad");
				}
			}
		} catch ( FacebookRequestException $ex ) {
			if($ex->getCode()==100 && array_key_exists('token',$_SESSION)){
				$token = $_SESSION["token"];
				try{
					$params = array(
							'grant_type' => 'fb_exchange_token',
							'fb_exchange_token' => $token,
					);
					$newToken = AccessToken::requestAccessToken($params);
					$this->session = new FacebookSession($newToken);
				}catch (Exception $ex){
					$this->session = false;
				}
				
			}else{
				$this->session = false;
			}
		} catch ( Exception $ex ) {
			$this->session = false;
		}
		
	}
	
	function getAppAccessToken(){
		return AccessToken::requestAccessToken(array('grant_type' => 'client_credentials'));
	}
	
	function getAppSession(){
		$token = $this->getAppAccessToken();
		return  new FacebookSession($token);
	}
	
	function getPagePostsIds(){
		$campociudad = '837336466344744';
		$request = ( new FacebookRequest( $this->getAppSession(), 'GET', "/{$campociudad}/posts?fields=id" ) )->execute();
		$graphObject = $request->getGraphObject();
		return $graphObject->asArray();
	}
	
	function isConnected() {
		if ($this->getSession()) {
			return true;
		}
		return false;
	}
	
	function getSession() {
		return $this->session;
	}
	
	public function get_user() {
		if ($this->getSession() ) {
			$request = ( new FacebookRequest( $this->getSession(), 'GET', '/me' ) )->execute();
			$user = $request->getGraphObject()->asArray();
			return $user;
		}
		return false;
	}
	
}