<?php

require_once('SessionController.php');
require_once('abstract_WebServiceGateway.php');
require_once(SERVER.ROOT.'WebServiceCommunicator/LoginAuthentication/BasicAuth1_LoginAuthenticator.php');


class ContextCommunicator extends WebServiceGateway{

    var $WebService, $session, $loginEngine;


// ABSTRACT IMPLEMENTATIONS   ===============================================================================================
	protected function getSessionId(){
		return $this->session->getId();
	}

	protected function getTimeStamp(){
		return $this->session->getTimeStamp();
	}

	public function LoginAuthentication($user, $pw){
		$this->session = Session::getInstance($user);
		$retorno =  $this->loginEngine->tryAuthorization(self::getSessionId(), $user, $pw, self::getTimeStamp() ) ;
		if($retorno->status){
			self::setAuthorizedSession();
			$this->session->UserInfo = $retorno->payload->userinfo;
			return 'Approved';
		}else{
			return 'Failed';
		}
	}

	protected function setAuthorizedSession(){
		$ch = curl_init($this->WebService."/Library1/UserPermission/null");
        self::setCurlGet($ch);
        $retorno = json_decode(curl_exec($ch));
        //file_put_contents("log.log",'setAuthorizedSession: '.serialize($retorno->payload)."\n" , FILE_APPEND);
		$this->session->Authorization = (array) $retorno->payload;
	}

	public function getAuthorization(){
		$retorno = ($this->session->Authorization == null)? array() : $this->session->Authorization;
		//file_put_contents("log.log",'getAuthorization: '.serialize($retorno)."\n" , FILE_APPEND);
		return $retorno;
	}

	public function Logout(){
		$this->session->Authorization = null;
		$ch = curl_init($this->WebService."/Library1/Logout/".$this->getSessionId() );
		self::setCurlDelete($ch,null);
        $result = json_decode(curl_exec($ch));
        $this->session->destroy();
        return self::processReturn($result);
	}


// SESSION COMMUNICATION   ===============================================================================================
	public function setClientPath($path){
		$this->session->clientPath = $path;
	}

	public function getClientPath(){
		return $this->session->clientPath;
	}


    function getMyUserCod(){
		return $this->session->UserCod;
	}

	function getUserInfo(){
		return $this->session->UserInfo;
	}

}

?>