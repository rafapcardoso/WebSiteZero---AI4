<?php


require_once('abstract_WebServiceGateway.php');
require_once(SERVER.ROOT.'WebServiceCommunicator/LoginAuthentication/BasicAuth1_LoginAuthenticator.php');


class SecureWebServiceCommunicator extends WebServiceGateway{

    var $Igreja, $Departamento, $UserInfo;


// FACEBOOK
	public function LoginAuthenticationFacebook(){
		
		//$this->session = Session::getInstance($user);
		$retorno =  $this->loginEngine->tryAuthorizationFacebook(self::getSessionId(), self::getTimeStamp() ) ;
		
		var_dump($retorno);
		
		//if($retorno->status){
		//	self::setAuthorizedSession();
			//file_put_contents("log.log",'UserInfo: '.serialize($retorno->payload->userinfo)."\n" , FILE_APPEND);
		//	$this->session->UserInfo = $retorno->payload->userinfo;
		//	return 'Approved';
		
		//}else{
		//	return 'Failed';
		//}
	}
	
	protected function setAuthorizedSession(){
		$ch = curl_init($this->WebService."/Library1/UserPermission/null");
        self::setCurlGet($ch);
        $retorno = json_decode(curl_exec($ch));
        //file_put_contents("log.log",'setAuthorizedSession: '.serialize($retorno->payload)."\n" , FILE_APPEND);
		$this->session->Authorization = (array) $retorno->payload;
	}

	public function getAuthorization(){
		//$retorno = $this->session->Authorization;
		$retorno = array('a'=>1,'b'=>2);//Only For Tests
		return $retorno;
	}


// SESSION COMMUNICATION   ===============================================================================================
	public function setClientPath($path){
		$this->session->clientPath = $path;
	}

	public function getClientPath(){
		return $this->session->clientPath;
	}

	// ==================================================================
	// ================= FROM LAST CONCEPT CHANGE =======================
	// ==================================================================
	public function getRoles(){ //NOT USED JUST EXAMPPLE
		$data = array();
        $retorno = self::setCurlPost("WebUser/UserPermissions",$data);
		return $retorno->payload;
	}
	// ==================================================================
	// ==================================================================
}

?>