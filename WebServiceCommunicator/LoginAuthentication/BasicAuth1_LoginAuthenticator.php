<?php

require('interface_LoginAuthenticator.php');

class Login_BasicAuth1 implements LoginAuthenticator{

	const CLIENT_TOKEN = 'RafaelRules';
	//RESTFULL ADDRESS
	var $target;

	function __construct($target){
		$this->target =  $target;
	}

//USER AND PASSWORD
	function tryAuthorization( $session_id, $user, $pw, $seed){

		//RECONSTRUCTING THE PASSWORD
		$pw = substr(md5($pw), 0, -2);

		//CLIENT TOKEN
		$key = md5(self::CLIENT_TOKEN . $seed);

		$ch = curl_init($this->target);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array("STAMP:$seed","KEY:$key","SESSION:$session_id") );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$user:$pw");

		$result2 = curl_exec($ch);
		$result = json_decode($result2);
		$http_cod = curl_getinfo($ch,CURLINFO_HTTP_CODE);

		print_r( "<br>TryAuthorization: " . $result2 .'<br>');

		//if( ($http_cod=='200')&&($result->status==true) ){
			return $result;
		//}else{
		//	return $result;
		//}
	}

//FACEBOOK
	function tryAuthorizationFacebook(){

	
		if(!session_id()){
			session_start();
		}



		/*
		 * Configuration and setup Facebook SDK
		 */
		$appId         = '427710694318513'; //Facebook App ID
		$appSecret     = '268e7e4b562f2c8606abd6602b5d7249'; //Facebook App Secret
		$redirectUri   = 'https://localhost:28414/ClientPhpInterface/MainScreen/'; //Callback URL
		$fbPermissions = array('email');  //Optional permissions
		
		//if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
		 
		// Obtém o código da query string
		//$code = $_GET['code'];
		
		// Monta a url para obter o token de acesso e assim obter os dados do usuário
		$token_url = "https://graph.facebook.com/oauth/access_token?". "client_id=" . $appId ."&client_secret=" . $appSecret . "&redirect_uri=" . $redirectUri;//.  "&code=" . $code;

		/*
			GET https://graph.facebook.com/oauth/access_token?
            client_id=YOUR_APP_ID
           &client_secret=YOUR_APP_SECRET
           &grant_type=client_credentials		
		*/
		
		//pega os dados
		var_dump($token_url);
		$response = @file_get_contents($token_url);
		
		if($response){
		
			$params = null;
		
			parse_str($response, $params);
			
			if(isset($params['access_token']) && $params['access_token']){
				$graph_url = "https://graph.facebook.com/me?access_token=". $params['access_token'];
				$user = json_decode(file_get_contents($graph_url));
			
				// nesse IF verificamos se veio os dados corretamente
				if(isset($user->email) && $user->email){
		
					/*
					*Apartir daqui, você já tem acesso aos dados usuario, podendo armazená-los
					*em sessão, cookie ou já pode inserir em seu banco de dados para efetuar
					*autenticação.
					*No meu caso, solicitei todos os dados abaixo e guardei em sessões.
					*/
					
					$_SESSION['email'] = $user->email;
					$_SESSION['nome'] = $user->name;
					$_SESSION['localizacao'] = $user->location->name;
					$_SESSION['uid_facebook'] = $user->id;
					$_SESSION['user_facebook'] = $user->username;
					$_SESSION['link_facebook'] = $user->link;
				
					$result = $user;
				}
				
		
			}else{
				var_dump($params);
				var_dump($response);
				echo "Erro de conexão com Facebook";
				exit(0);
			}
		}else{
				var_dump($response);			
			echo "Erro de conexão com Facebook";
			exit(0);
		}
		

		
		return $result;
	}
	
	function tryAuthorizeSession($session_id, $seed){
		return FALSE;
	}

}
?>
