<?php

//Autentications
// https://github.com/codeguy/Slim-Extras/tree/master/Middleware

require "Slim/Slim.php";

\Slim\Slim::registerAutoloader();

// create new Slim instance
$app = new \Slim\Slim();

use \Slim\Slim;

//Acertando Endereçamento de Páginas
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define("ROOT",'');
    define("SERVER",'./');
	define("HARDCODE_STYLESHEET", 'http://'.$_SERVER['HTTP_HOST'].'/');

} else {
	define("ROOT",'');//.$app->request()->getRootUri().'/');
	define("SERVER",'');
	define("HARDCODE_STYLESHEET", 'http://'.$_SERVER['HTTP_HOST'].'/');

}

function setCLIENT(){
	//CLIENT TEMPLATE
	//Acertando Endereçamento de Páginas
	switch($_SERVER['HTTP_HOST'] ){

		case 'localhost:28414':
			//define('CLIENT',"Client_TemperoPaulista/");
			define('CLIENT',"Client/");
			define('TEMPLATE_DIRECTORY','./');
			define('WEBSERVICE_ADDR', 'http://localhost:28414/WebServiceZero - AI4/');
			break;

		case '192.168.1.6:28414':
		    //define('CLIENT',"Client_TemperoPaulista/");
		    define('CLIENT',"Client/");
		    define('TEMPLATE_DIRECTORY','./');
		    define('WEBSERVICE_ADDR', 'http://localhost:28414/WebServiceZero - AI4/');
		    break;
		    
		case 'www.rpap.com.br':
		    define('CLIENT',"Client/");
		    define('TEMPLATE_DIRECTORY','/home/u215361695/public_html/');
		    define('WEBSERVICE_ADDR', 'http://www.rpap.com.br/WebService/');
		    
		    break;

	}	
}


//Logged urls
$app->get('/MainScreen(/)', '\LoggedCommFunction' ) ;
$app->get('/MainScreen/:page(/:value+)', '\LoggedCommFunction');
$app->post('/MainScreen/:page(/:value+)', '\LoggedCommFunction');

//Public urls
$app->get('(/)', '\PublicCommFunction'); //ADDED
$app->post('(/)', '\PublicCommFunction'); //ADDED
$app->get('/:page(/:value+)', '\PublicCommFunction');
$app->post('/:page(/:value+)', '\PublicCommFunction');


function PublicCommFunction ($page=null, $value =null )  {    
    $app = \Slim\Slim::getInstance();
	
	//CLIENT
	setCLIENT();
	
	//Acertando Endereçamento de Páginas
	$view = $app->view();
	$view->setTemplatesDirectory(TEMPLATE_DIRECTORY);

	//$app->render('underconstruction.html');
	//exit;
	
	//Usado  apenas para POST
	$body = $app->request->getBody();
	$JsonObj = ($body <> null)?(array) json_decode($body):null;

	if($page == "Login"){
	    $internalAddress = SERVER.'Controllers/Public_DashBoard.php';
	}else{
    	//This function is only used with MainScreen
    	//the dash used is always the same for logged
	    $internalAddress = SERVER.'Controllers/Public_DashBoard.php';
	}
	
	
	//MODULE
	if($page != null){
		//Get module nomenclature
		if(strpos($page, '?') > 0){
			$_GET['module'] =  substr($page,0, strpos($page, '?'));
			InterpertURL($page);
		}else{
			$_GET['module'] = $page;
		}
	}
	 
	//PAGE CONTENT
	if($value != null){
		$_GET['submodule'] = array();
		for($i=0; $i < count($value) ; $i++){
			if(strpos($value[$i], '?') > 0){
				array_push($_GET['submodule'], substr($value[$i],0, strpos($value[$i], '?')));
				InterpertURL($value[$i]);
			}else{
				array_push($_GET['submodule'], $value[$i]);
			}
		}
	}
		
	
	if($JsonObj <> null){
		$app->render($internalAddress, $JsonObj);
	}else{
		$app->render($internalAddress);
	}
}

function LoggedCommFunction($page=null, $value =null){
	$app = \Slim\Slim::getInstance();
	
	//CLIENT
	setCLIENT();
	
	//Acertando Endereçamento de Páginas
	$view = $app->view();
	$view->setTemplatesDirectory(TEMPLATE_DIRECTORY);

	//Usado  apenas para POST
	$body = $app->request->getBody();
	$JsonObj = ($body <> null)?(array) json_decode($body):null;

	//MODULE
	if($page != null){
		//Get module nomenclature
		if(strpos($page, '?') > 0){
			$_GET['module'] =  substr($page,0, strpos($page, '?'));
			InterpertURL($page);
		}else{
			$_GET['module'] = $page;
		}
	}
	 
	//PAGE CONTENT
	if($value != null){
		$_GET['submodule'] = array();
		for($i=0; $i < count($value) ; $i++){
			if(strpos($value[$i], '?') > 0){
				array_push($_GET['submodule'], substr($value[$i],0, strpos($value[$i], '?')));
				InterpertURL($value[$i]);
			}else{
				array_push($_GET['submodule'], $value[$i]);
			}
		}
	}
		
	if($page == "Login"){
	    $internalAddress = SERVER.'Controllers/Public_DashBoard.php';
	}else{
	    //This function is only used with MainScreen
	    //the dash used is always the same for logged
	    $internalAddress = SERVER.'Controllers/Logged_DashBoard.php';
	}
	
	
	//Teste $page
	//echo "Pagina:" . var_dump($_GET['module']);//exit;
	//echo "end:" . ROOT.$internalAddress;
	
	if($JsonObj <> null){
		$app->render(ROOT.$internalAddress, $JsonObj);
	}else{
		$app->render(ROOT.$internalAddress);
	}
}

	
/**
//ONLY FOR LOGIN PURPOSES
$app->post('/:page',function ($page=null) use ($app) {
		setCLIENT();
		//Acertando Endereçamento de Páginas
	    $view = $app->view();
	 	$view->setTemplatesDirectory(TEMPLATE_DIRECTORY);

  		$body = $app->request->getBody();
        $JsonObj = (array) json_decode($body);
        $JsonObj = $_POST;
       //var_dump($body);
       //var_dump(json_decode($body));
       //var_dump($JsonObj);
       //var_dump($_POST);

		if($page == 'Login'){
			$internalAddress = 'mdl_Login/Public_Login.php';
		}else{
			$internalAddress = 'Controllers/Logged_DashBoard.php';
		}

		//file_put_contents("log_index.log", date('Y-m-d H(P):i:s')." US_TimeStamp - :  ". FIRST_SHOOT.$internalAddress."\n" , FILE_APPEND);

		//Chamando Página Pesquisada
		$_GET['module'] = $page;
		$app->render($internalAddress, $JsonObj);
    }
);*/
   

function InterpertURL($url){
	//echo "interpreting url: $url<br>";
	if($url != ''){
		$temp = substr($url, strpos($url, '?')+1);
		$temp = explode('&',$temp);
		foreach($temp as $pair){
			$exploded = explode('=',$pair);
			$_GET[$exploded[0]] = $exploded[1];
		}
	}
}


$app->run();



  

?>