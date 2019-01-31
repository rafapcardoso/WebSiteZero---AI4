<?php

class Session{

	// Hold an instance of the class
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;
	

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;
    private static $instance;//, $timestamp, $logObj;


	
    private function __construct() {
    /**
    *    Returns THE instance of 'Session'.
    *    The session is automatically initialized if it wasn't.
    *    @return    object
    **/
	}

    public static function getInstance() {
        if ( !isset(self::$instance)){
            self::$instance = new self;
        }
        self::$instance->startSession();
        return self::$instance;
    }

    function startSession(){
        
        if ( $this->sessionState == self::SESSION_NOT_STARTED ){

            /*
			if(isset($_COOKIE[self::SESSION_ID_COOKIE_NAME.$this->userId])){
				//IF COOKIE SESSION
				//$this->timestamp = $_COOKIE[self::SESSION_TIMESTAMP_COOKIE_NAME.$this->user];
				$this->id = $_COOKIE[self::SESSION_ID_COOKIE_NAME.$this->user];
				//file_put_contents("log_index.log",$this->user." Loaded Session:".$this->id." \n" , FILE_APPEND);
			}else{
				//IF NOT COOKIES
				//CREATE NEW
				//SAVE COOKIES
				setcookie(self::SESSION_TIMESTAMP_COOKIE_NAME.$this->user,$this->timestamp,time()+self::SESSION_ID_COOKIE_SECS,"/");
				setcookie(self::SESSION_ID_COOKIE_NAME.$this->userId,				$this->id,				 time()+self::SESSION_ID_COOKIE_SECS,"/");
				//file_put_contents("log_index.log",$this->user."Generated Session:".$this->id." \n" , FILE_APPEND);
			}*/
			
			$this->timestamp = time();
			$this->id = md5('RafaelRulesItAll');//$this->timestamp . rand(1,32000) );
			
			session_id($this->id);
			$this->sessionState = session_start();
        }
        return $this->sessionState;
	}

    public function __set( $name , $value ){
        $_SESSION[$name] = $value;
    }

    public function __get( $name ){
        if ( isset($_SESSION[$name])){
            return $_SESSION[$name];}
    }

    public function getId(){
		return session_id();
	}

    public function __isset( $name ){
        return isset($_SESSION[$name]);
    }


    public function __unset( $name ){
        unset( $_SESSION[$name] );
    }

	public function isOpen(){
		 if(!isset(self::$instance)){
		 	return false;
		 }else{
		 	return true;
		 }
	}
 
	//SETS
	public function setUserCadUnico($value){
	    $_SESSION['UserCadUnico'] = $value;
	}

	public function setUserName($value){
	    $_SESSION['UserName'] = $value;
	}

	public function setUserEstabelecimento($value){
	    $_SESSION['UserEstabelecimento'] = $value;
	}
	
	public function setUserAuthorizations($valuearray){
	    $_SESSION['UserAuthorizations'] = $valuearray;
	}
	
	//GETS
	public function getUserCadUnico(){
	    return (isset($_SESSION['UserCadUnico'])?$_SESSION['UserCadUnico']:0);
	}
	
	public function getUserName(){
	    return (isset($_SESSION['UserName'])?$_SESSION['UserName']:'Indefinido');
	}
	
	public function getUserEstabelecimento(){
	    return (isset($_SESSION['UserEstabelecimento'])?$_SESSION['UserEstabelecimento']:0);
	}

	public function getUserAutorizations(){
	    return (isset($_SESSION['UserAuthorizations'])?$_SESSION['UserAuthorizations']:0);
	}
	
		/**
    *    Destroys the current session.
    *    @return    bool    TRUE is session has been deleted, else FALSE.
    **/
    public function destroy(){
        if ( $this->sessionState == self::SESSION_STARTED ){
            $_SESSION = array();
            session_unset();
            $this->sessionState = !session_destroy();
            unset( $_SESSION );
            return !$this->sessionState;
            print_r('Destroyed');
        }
        return FALSE;
    }
}

?>
