<?php
require_once('SessionController.php');

abstract class WebServiceGateway{


    const ApiSecret = 'ndsaiudq38h98e1hueduhq98e3huf98j31e832r98ur48y2498428yg249872ry7824t359h2t9828j94';
	const ApiKey = 'okasjokjre89234u982e3jiofewi2r389342hr2983rn';
	
	const PKP_USERID_COOKIE = "VanillaCookie";
	const PKP_USERNAME_COOKIE = "BrownieCookie";
	const PKP_USERID_COOKIE_SEGS = 864000; //10dias = 86400 * 10
	
	
	var $WebServicePath; //, $session,$loginEngine

    function __construct(){
       //$this->session = Session::getInstance(null);
        
        if(
            isset($_COOKIE[self::PKP_USERID_COOKIE]) &&
            isset($_COOKIE[self::PKP_USERNAME_COOKIE]) 
            ){
            $this->userCadUnico = $_COOKIE[self::PKP_USERID_COOKIE];
            $this->userName = $_COOKIE[self::PKP_USERNAME_COOKIE];
        }else{
            $this->userCadUnico = 0;
        }

		//CONNECT TO DATABASE
		switch($_SERVER['HTTP_HOST'] ){

			case 'localhost:28414':
			    $this->WebServicePath='http://localhost:28414/WebServiceZero/';
				break;
			    
			case 'www.sgpral.96.lt':
		    	$this->WebServicePath='http://www.sgpral.96.lt/WebService/';
		    	break;
		    	
			case 'www.rpap.com.br':
			    $this->WebServicePath='http://www.rpap.com.br/WebServiceZero/';
			    break;
			    
		}

    }

// COMMUNICATION: COMMOM   ===============================================================================================
	
    private function getSecurityHeaders($method, $data, $isFile){
	
		$nonce = (string) number_format(round(microtime(true) * 100000), 0, ".", "");
		
		$instance = Session::getInstance();
		
		if($isFile == true){
		    $path       = '/api/v1/auth/r/'.$method.$nonce.$instance->getUserCadUnico();
		    $lenght = 0;
		    $signature  = hash_hmac("sha384", utf8_encode($path), utf8_encode(self::ApiSecret));
		    return  array(
		        "Content-Type:multipart/form-data",
		        /*"Content-Length: " . $lenght,*/
		        "pkp-apikey: " . self::ApiKey,
		        "pkp-signature: " . $signature,
		        "pkp-nonce: " . $nonce,
		        "Pkp-Origin: webuser",
		        "pkp-UserCadUnico: " . $instance->getUserCadUnico()
		    );
		}else{
		    $data_string = self::safe_json_encode($data);
		    $path       = '/api/v1/auth/r/'.$method.$data_string.$nonce.$instance->getUserCadUnico();

		    $lenght = strlen($data_string);
		    $signature  = hash_hmac("sha384", utf8_encode($path), utf8_encode(self::ApiSecret));
		    return  array(
		        "Content-Type:application/json; charset=utf-8",
		        "Content-Length: " . $lenght,
		        "pkp-apikey: " . self::ApiKey,
		        "pkp-signature: " . $signature,
		        "pkp-nonce: " . $nonce,
		        "Pkp-Origin: webuser",
		        "pkp-UserCadUnico: " . $instance->getUserCadUnico()
		    );
		}

	}



	public function setCurlDelete(&$ch){
		curl_setopt($ch,CURLOPT_HTTPHEADER, self::getSecurityHeaders() );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    }
	
	// ==================================================================
	// ================= FROM LAST CONCEPT CHANGE =======================
	// ==================================================================
    public function setCurlGet($url){
        $ch = curl_init($this->WebServicePath.$url);
        curl_setopt($ch, CURLOPT_URL, $this->WebServicePath.$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getSecurityHeaders('GET', ''));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        $output = utf8_decode($output);
        $output = json_decode($output);
        
        
        //$output->actualpage = 'getUserName:'.$this->getUserName();
        //var_dump( $_SESSION);
        
        //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_CONTENT_TYPE));echo '<br>';
        //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_EFFECTIVE_URL));echo '<br>';
        //echo 'HttpCode: ';var_dump($httpcode);echo '<br>';
        //echo 'Output: ';var_dump($output);echo '<br>';
        
        curl_close($ch);
        
        if($httpcode != 200 ){
            //$this->Logout();
            //header('location: Login?def=error&errorcode='.$output->errorcode.'&errorstring='.$output->errorstring);exit;
            return null;
        }else{
            
            return  $output;
        }
    }
	
	
	public function setCurlPost($url, $data, $hasFiles = false){

	    $ch = curl_init($this->WebServicePath.$url);
		
		if($hasFiles ){
		  //$args['file'] = new CurlFile($data['path'], $data['mime'], $data['filename']);
		  //curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		  curl_setopt($ch, CURLOPT_POST,true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		  curl_setopt($ch, CURLOPT_VERBOSE, true);
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
		}else{
		  $data['UserCadUnico'] = self::getUserCadUnico();
		  curl_setopt($ch, CURLOPT_POSTFIELDS, self::safe_json_encode($data));
		}		
		
		curl_setopt($ch, CURLOPT_URL, $this->WebServicePath.$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getSecurityHeaders('POST', $data, $hasFiles));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		//print_r( curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_UPLOAD) );
		
		//echo "<br>raw output:<br>";
		//var_dump($output);
		
		$output = json_decode($output);
		
		/*
		echo "<br>json_decode output:<br>";
		var_dump($output);
		*/
		
		//echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_CONTENT_TYPE));echo '<br>';
		/*
		echo '<br>Header: '; var_dump(curl_getinfo($ch,CURLINFO_HEADER_OUT));echo '<br>';
		echo '<br>HttpCode: ';var_dump($httpcode);echo '<br>';
		echo '<br>Output: ';var_dump($output);echo '<br>';
	    */
		if($httpcode != 200 ){
            /* TODO para validacao descomentar
             * Para testes comentar estas duas linhas para evitar fazer logoff toda
             * vez que acontecer uma negativa no servidor */
		    //$this->Logout();
            //header('location:'.HARDCODE_STYLESHEET.' Login?def=error&errorcode='.$output->errorcode.'&errorstring='.$output->errorstring);exit;
		    
		    //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_EFFECTIVE_URL));echo '<br>';
		    //echo 'HttpCode: ';var_dump($httpcode);echo '<br>';
		    //echo 'Output: ';var_dump($output);echo '<br>';
		    
		    curl_close($ch);
		    return $output;
		}else{
		    curl_close($ch);
	        return  $output;
		}
    }
    
    public function Login($data){
        $data['pw'] = md5($data['pw']);
        $retorno = self::setCurlPost('WebUser/Login', $data);
        
        //var_dump($retorno);
        //exit;
        
        if($retorno == null){
            header('location:'.HARDCODE_STYLESHEET.' Login?def=error&errorcode=-1&errorstring=Problemas%20com%20o%20servidor');exit;
            return null;
        }
        if($retorno->status == false){
            $this->Logout();
            var_dump($retorno);exit;
            header('location:'.HARDCODE_STYLESHEET.' Login?def=error&errorcode='.$retorno->errorcode.'&errorstring='.$retorno->errorstring);exit;
            return null;
        }
        
        //With cookies
        /*
        setcookie(self::PKP_USERID_COOKIE, $retorno->payload->UserId, self::PKP_USERID_COOKIE_SEGS, "/"); // 86400 = 1 day
        setcookie(self::PKP_USERNAME_COOKIE, $retorno->payload->UserName, self::PKP_USERID_COOKIE_SEGS, "/"); // 86400 = 1 day
        */
        //With Session
        $instance = Session::getInstance();
        $instance->setUserCadUnico($retorno->payload->UserCadUnico);
        $instance->setUserName($retorno->payload->UserName);
                
        //Autorizations
        $retorno = self::setCurlPost("WebUser/UserPermissions",array());
        $instance->setUserAuthorizations($retorno->payload);
        
        return $retorno;
    }

/*
    public function setCurlPostFile($url, $args){
        //Mandatory payload
        
        //$data['UserId'] = self::getUserId();
        //$data_string = json_encode($data);
        //$args['file'] = new CurlFile($data['path'], $data['mime'], $data['filename']);
        
        $ch = curl_init($this->WebServicePath.$url);
        curl_setopt($ch, CURLOPT_URL, $this->WebServicePath.$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::getSecurityHeaders('POST', $args, true));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        //$output = utf8_decode($output);
        $output = json_decode($output);
        //$output = de_utf8ize($output);
        
        //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_CONTENT_TYPE));echo '<br>';
        //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_EFFECTIVE_URL));echo '<br>';
        //echo 'HttpCode: ';var_dump($httpcode);echo '<br>';
        //echo 'Output: ';var_dump($output);echo '<br>';
        
        if($httpcode != 200 ){
            //$this->Logout();
            //header('location:'.HARDCODE_STYLESHEET.' Login?def=error&errorcode='.$output->errorcode.'&errorstring='.$output->errorstring);exit;
            
            //echo 'Header: '; var_dump(curl_getinfo($ch,CURLINFO_EFFECTIVE_URL));echo '<br>';
            //echo 'HttpCode: ';var_dump($httpcode);echo '<br>';
            //echo 'Output: ';var_dump($output);echo '<br>';
            
            curl_close($ch);
            //return null;
        }else{
            curl_close($ch);
            //return  $output;
        }
	}
*/
	
	// ==================================================================
	// ==================================================================	
	
	public function setCurlPut(&$ch, &$data_string){
        $data_string = json_encode($data_string);
        curl_setopt($ch,CURLOPT_HTTPHEADER, self::getSecurityHeaders() );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge( array(
        'Content-Type: application/json'
        ,'Content-Length: ' . strlen($data_string))
        , self::getSecurityHeaders()) ) ;
    }

	public function processReturn($retorno){
		if($retorno!=null){
			if($retorno->status == false){
				switch($retorno->errorcode){
					case '9001':	//Session Expired
						//Verifiy if modules and values were asked
						$result = array_slice ($_GET,1,null,true); //remove '/MainScreen/module'
						//header("location: ".ROOT.'/Login?error='.$retorno->errorcode.'&errorstring='.$retorno->errorstring.'&'.http_build_query($result) );
						header("location: ".ROOT.'/Login?def=error&errorcode='.$retorno->errorcode.'&errorstring='.$retorno->errorstring);
						exit;
						break;
					case '9000':	//Problems to register Basic User to Access DB					
					case '9002':	//User not identified
					case '9003':	//Problem to register new session
					case '9004':	//NÃƒÂºmero da sessÃƒÂ£o nÃƒÂ£o recebida
						header("location: ".ROOT.'/Login?def=error&errorcode='.$retorno->errorcode.'&errorstring='.$retorno->errorstring);
						exit;
						break;
					case '9009': //Authorization not found inside Server  Library1/GET_Celulas
						exit;
						break;
					}
				}
			}
			return $retorno;
		}


//COMMOM ========================================================================================
	public function checkPermission($role, $feedback = false){
	    //var_dump(self::getUserAuthorizations() );
	    try{
			if( 
			    (in_array($role, self::getUserAuthorizations()) ) ||
			    (in_array('SuperUser', self::getUserAuthorizations()) )
			    ){
			    //Faz nada
			}else{
				if($feedback){
					//faz nada
				}else{
					header('location: '.ROOT.'/MainScreen?def=error&errorstring='.urlencode("Você não possui autorização:".$role." para esta ação. Contate seu administrador"));
					exit;
				}
			}
		}catch(Exception $e){
			//header('location: '.ROOT.'/MainScreen/Login');
			exit;
		}
	}
	
	public function check($method,$field,&$arrayReturn,&$errorMessage,$mandatory = true, $newKeyAlias = null){
		//POST
		if($method == 'post'){
			if(isset($_POST[$field])){
				$varKey = ($newKeyAlias===null)? $field : $newKeyAlias;
				if($_POST[$field]!=null){
				    $arrayReturn[$varKey] = ( $_POST[$field] );
				}else{
				    if($mandatory){
				        $errorMessage .= ($errorMessage == '')? "Faltando Campo: $field": " $field ,";
				    }
				}
			}else{
				if($mandatory){
					$errorMessage .= ($errorMessage == '')? "Faltando Campo: $field": " $field ,";
				}
			}
		}
		//GET
		if($method == 'get'){
			if(isset($_GET[$field])){
				$varKey = ($newKeyAlias===null)? $field : $newKeyAlias;
				if($_GET[$field]!=null){
				    $arrayReturn[$varKey] = ( $_GET[$field] );
				}
			}else{
				if($mandatory){
					$errorMessage .= ($errorMessage == '')? 'Faltando Campo: ': " $field ,";
				}
			}
		}
	}

//FEEDBACK ========================================================================================
	public function checkServiceFeedback($feedback, $redirection = null){
		try{
			$redirection = (($redirection == null)&&(strpos($redirection, 'Login') == 0))? ROOT.'/MainScreen' : $redirection;
			$redirection = (strpos($redirection, '?') > 0)? $redirection.'&' : $redirection.'?';
			if($feedback == null){
				header('location: '.$redirection.'def=error&errorstring=retorno%20nulo');
				exit;
			}
			if($feedback->status == true){
		        header('location: '.$redirection.'def=sucess');
		        exit;
			}else{
				if((strpos($redirection, 'error=') > 0)){
					//header('location: '.$redirection);
					exit;
				}else{
					header('location: '.$redirection.'def=error&errorstring='.$feedback->errorstring.'&errorcode='.$feedback->errorcode);
					exit;
				}
			}
		}catch(Exception $e){
			//throw new Exception('CheckServiceFeedback: '.serialize($feedback));
			header('location: '.$redirection.'def=error&errorstring=Excessao%20disparada');
			exit;
		}
	}

    public function getUserCadUnico(){
        $value = null;
        
        //if(isset($_COOKIE[self::PKP_USERID_COOKIE])){
        //    $value = $_COOKIE[self::PKP_USERID_COOKIE];
        //}else{
            //$session = new Session();
            $instance = Session::getInstance();
            if(isset( $_SESSION['UserCadUnico'])){
                return $_SESSION['UserCadUnico'];//$instance->getUserId;
            }else{
                return 0;
            }

    }

    public function getUserName(){
        $value = null;
        //if(isset($_COOKIE[self::PKP_USERNAME_COOKIE])){
        //    $value = $_COOKIE[self::PKP_USERNAME_COOKIE];
        //}else{
            //$session = new Session();
            $instance = Session::getInstance();
            if(isset($_SESSION['UserName'])){
                return $_SESSION['UserName'];//$instance->getUserName;
            }else{
                return "Indefinido";
            }
            
        }
 
    public function getUserAuthorizations(){
        $instance = Session::getInstance();
        if(isset($_SESSION['UserAuthorizations'])){
            return $_SESSION['UserAuthorizations'];//$instance->getUserName;
        }else{
            return 0;
        }
    }
        
    public function Logout(){
        $instance = Session::getInstance();
        $instance->destroy();
    }
    
    function safe_json_encode($value, $options = 0, $depth = 512){
        $encoded = json_encode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = self::utf8ize($value);
                return self::safe_json_encode($clean, $options, $depth);
            default:
                return 'Unknown error'; // or trigger_error() or throw new Exception()
                
        }
    }
    
    function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        }
        return $mixed;
    }
    
    function de_utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::de_utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_decode($mixed);
        }
        return $mixed;
    }
}

?>
