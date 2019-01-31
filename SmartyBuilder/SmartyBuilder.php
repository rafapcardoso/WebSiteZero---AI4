<?php

define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8');
require_once SERVER.ROOT.'Smarty/libs/Smarty.class.php';
require_once SERVER.ROOT.'Controllers/Logged_Menu.php';



class Page{
    
    var $smarty, $WebService, $context, $security, $anchors, $MenuTemplate,$LateralMenuTemplate,$Menus, $ActiveMenu, $clientPath, $arrayGoogleFonts, $arrayCSSstyles, $showMenu,$clientCSS,$mainLogo;
    var $arrayHeaderJavaScripts, $arrayFooterJavaScripts,$stringInitializeJavaScripts, $arrayGlobalJavaVars;
    var $pageTitle, $pageDescription;

    function __construct($context = null){
       
		//GETTING CLIENT REFERENCE
		if($context == null){throw new RuntimeException ("Context from class_Context must be informed");}
		$this->context = $context;

		//SETTING UP SMARTY
		
        $this->smarty = new Smarty();
        
		$this->smarty->setTemplateDir($this->context->template);
        $this->smarty->setCompileDir($this->context->template_c);
        $this->smarty->setCacheDir($this->context->cache);
        $this->smarty->setConfigDir($this->context->config);
        
		//var_dump($this->context);
		
		//SETTING FUTURE ARRAY CONTAINERS
        $this->arrayHeaderJavaScripts = array();
        $this->arrayFooterJavaScripts = array();
        $this->arrayGlobalJavaVars = array();
        $this->anchors = array();
        $this->WebService = $this->context->WebServiceCom;

        //CLIENT CONFIGURATION
        $this->clientCSS = $this->context->clientCSS;
        $this->mainLogo = $this->context->mainLogo;

        //GENERAL CONFIGURATION
         $this->setCSSstyles(HARDCODE_STYLESHEET."Controllers/structure.css");
         $this->setCSSstyles(HARDCODE_STYLESHEET."Controllers/print_styles.css",'print');
		 
         $this->security = $this->context->security;

		//MENU
        $this->showMenu = $this->context->usePublicMenu;
		$this->smarty->assign('largeheader',$this->context->LargeHeader);

		//FUNCTION BOOK
		$this->smarty->assign('functionsbook',$this->smarty->fetch(SERVER.ROOT.'SmartyBuilder/functionbook.html'));
    }

// JAVASCRIPTS ADDS   ===============================================================================================

	//GLOBAL VARIANTS
	function addGlobalsJavaVars($var){
		if(is_array($var)){
			$this->arrayGlobalJavaVars = array_merge($this->arrayGlobalJavaVars,$var);
		}else{
			$this->arrayGlobalJavaVars[] = $var;
		}
	}

	//INITIALIZE
	function addInitializeJavaScript($address){

		//Facebook Login script
		//Objective is get the AccessToken to be send as validation to the WebService

		if(is_string($address)){$this->stringInitializeJavaScripts .= $address;}
    }

    //HEADER
    function addHeaderJavaScript($address){
		if(is_array($address)){
			$this->arrayHeaderJavaScripts = array_merge($this->arrayHeaderJavaScripts,$address);
		}else{
			$this->arrayHeaderJavaScripts[] = $address;
		}
    }

    //FOOTER
    function addFooterJavaScript($address){
		if(is_array($address)){
			$this->arrayFooterJavaScripts = array_merge($this->arrayFooterJavaScripts,$address);
		}else{
			$this->arrayFooterJavaScripts[] = $address;
		}
    }

    //GOOGLEFONTS ADDS   ===============================================================================================
    function addGoogleFonts($address){
       $this->arrayGoogleFonts[] = $address;
    }

    //CSS ADDS   ===============================================================================================
    function setCSSstyles($address, $media = 'screen'){
		if(is_array($address)){
			$this->arrayCSSstyles = array_merge($this->arrayCSSstyles, $address);
		}else{
			$this->arrayCSSstyles[] = array('address'=>$address, 'media'=>$media);
		}
    }

    //GENERAL CONTENT ADDS   ===============================================================================================
    function setContent($anchor = NULL){
        if($anchor != NULL){$this->anchors = array_merge($this->anchors, $anchor);}
    }

	function setTemplate($template){
		$this->context = $template;
	}

    function setMainMenu($template){
        $this->MenuTemplate = $template;
    }
    
    //OTHER  ===============================================================================================
    function highlightMainMenu($index){
        $this->ActiveMenu[$index] = " active";
    }

    function setPageTitle($v){
        $this->pageTitle = $v;
    }
	
    function setPageDescription($v){
        $this->pageDescription = $v;
    }
    
	function executeLogout(){
		$this->WebService->Logout();
	}

	//DISPLAY    ===============================================================================================
    function display(){
        //SCRIPTS ON HEADER
        $this->smarty->assign('GlobalJavaVariants', $this->arrayGlobalJavaVars);
        $this->smarty->assign('InitializeJavaScripts', $this->stringInitializeJavaScripts);
        $this->smarty->assign('HeaderJavaScripts', $this->arrayHeaderJavaScripts);
        $this->smarty->assign('FooterJavaScripts', $this->arrayFooterJavaScripts);
        $this->smarty->assign('GoogleFonts', $this->arrayGoogleFonts);
        $this->smarty->assign('CSSstyles', $this->arrayCSSstyles);
        $this->smarty->assign('CSS',$this->clientCSS);
		
		//STANDARD
        $this->smarty->assign('ROOT',ROOT);
        $this->smarty->assign('CLIENT',CLIENT);
		$this->smarty->assign('SERVER',SERVER);
		$this->smarty->assign('HARDCODE_STYLESHEET',HARDCODE_STYLESHEET);
		$this->smarty->assign('WEBSERVICE_ADDR', WEBSERVICE_ADDR);
			
		//PAGE
		$this->smarty->assign('PageTitle',$this->pageTitle);
		$this->smarty->assign('PageDescription',$this->pageDescription);
		
        //CONTEXT
        if($this->anchors!= NULL){
           foreach($this->anchors as $key => $value) {
               $this->smarty->assign($key , $value);
           }
       }
       
       if($this->context != NULL){
            $content = $this->smarty->fetch($this->context);
            $this->smarty->assign('context', $content);
			$this->smarty->display($this->context);
        }

				
        //SHOW
		//if($this->security == true){
			//echo 'dashboard';
			//$this->smarty->display('Logged_DashBoard.html');
			
		//}else{
			//echo 'structure';
        //	$this->smarty->display('./mdl_Public/templates/Structure1.html');
        //}
    }

    function __desctruct(){
         unset($smarty);
         unset($arrayJavaScripts);
         unset($webService);
         unset($context);
         unset($anchors);
    }

    function fetch($template){
        if($this->anchors!= NULL){
           foreach($this->anchors as $key => $value) {
               $this->smarty->assign($key , $value);
           }
        }

        //STANDARD
        $this->smarty->assign('ROOT',ROOT);
        $this->smarty->assign('CLIENT',CLIENT);
		$this->smarty->assign('SERVER',SERVER);
		$this->smarty->assign('HARDCODE_STYLESHEET',HARDCODE_STYLESHEET);
		$this->smarty->assign('WEBSERVICE_ADDR',WEBSERVICE_ADDR);
		
		//AUTHORIZATION

		//file_put_contents("log.log",'SmartyBuilder/Authorization: '.serialize($this->WebService->getAuthorization())."\n" , FILE_APPEND);
		//$this->smarty->assign('authorization', $this->WebService->getAuthorization());
    	return $this->smarty->fetch($template);
    }
}

?>
