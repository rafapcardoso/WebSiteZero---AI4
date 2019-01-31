<?php

interface LoginAuthenticator{
	
	public function tryAuthorization($session_id, $user,$pw,$seed);
	
	public function tryAuthorizeSession($session_id,$seed);
	
	}

?>
