<?php

/*

Revisao 0
Data 03/08/2015 - 12:36hs


*/

    require_once SERVER.ROOT.'SmartyBuilder/SmartyBuilder.php';
    require_once SERVER.ROOT.CLIENT.'standardContext.php';
	require_once SERVER.ROOT.'Controllers/Public_Menu.php';
	require_once(SERVER.ROOT.'WebServiceCommunicator/SecureWebServiceCommunicator.php');

$argc = new structure();

class structure{

    var $page, $WebService, $ModulesArray, $Roles, $params, $InstalledModules, $context;

    function __construct(){

        
		//WEBSERVICE
        $this->WebService = new SecureWebServiceCommunicator();

        
		$this->params = array_merge($_GET,$_POST);
		$this->context = new standardContext(SERVER.ROOT.'Controllers/templates/');
        $this->page = new Page($this->context);
		$this->page->addGoogleFonts('http://fonts.googleapis.com/css?family=Dosis:500');

		
		//FOR USER MESSAGES
		if(isset($_GET['def'])){
			$this->page->setContent(array('def'=>$_GET['def']));		}
		if(isset($_GET['errorstring'])){
			$this->page->setContent(array('errorstring'=>$_GET['errorstring']));		}

			
		//CHECK USER CONFIRMATION WITH SERVER
		//if(!$this->WebService->isSessionOpen() || !isset($this->WebService->getUserInfo()->usr_cod) ){
		if(false){
			header('location:Login?def=error&errorcode=0&errorstring=Sua%20sessao%20expirou.');
			exit;
		}

		
		//MODULE INITIATION
		$this->InstalledModules = array();
		if(file_exists(SERVER.ROOT.'Config.ini')){
			$types = parse_ini_file(SERVER.ROOT.'Config.ini');
			if(isset($types['INSTALLED'])){$this->InstalledModules = explode(',',$types['INSTALLED']);}
		}

		$this->ModulesArray = array();

		
		// the order also relates to the menu shown
		// Check if the file exists before install it
		self::installModule(SERVER.ROOT.'mdl_Public/Public_Main.php','PublicMain','PublicMainClass',false);
		//self::installModule(SERVER.ROOT.'mdl_Login/Public_Login.php','Login','LoginClass',false);
		//self::installModule(SERVER.ROOT.'mdl_Blog/mdl_Blog.php','Blog','BlogClass',false);
		/*self::installModule(SERVER.ROOT.'mdl_Estabelecimentos/mdl_Estabelecimentos.php','Estabelecimentos','EstabelecimentosClass',True);
		self::installModule(SERVER.ROOT.'mdl_Sugestoes/mdl_Sugestoes.php','Sugestoes','SugestoesClass',True);
		self::installModule(SERVER.ROOT.'mdl_UserAdm/mdl_UserAdm.php','UserAdm','UserAdmClass',True);
		self::installModule(SERVER.ROOT.'mdl_Pedidos/mdl_Pedidos.php','Pedidos','PedidosClass',True);
		self::installModule(SERVER.ROOT.'mdl_Propagandas/mdl_Propagandas.php','Propagandas','PropagandasClass',True);
*/

		
		//GET MODULES MENU
		if($this->context->usePublicMenu){
     		$menu = new Public_Menu();
    		foreach($this->ModulesArray as $singleModule){
    			if($singleModule->getMenu() != null){
    				$menu->addMenuArray($singleModule->getMenu());
    			}
    		}
		    
    		//GET MODULES ROLES
     		$this->Roles = array();
    		foreach($this->ModulesArray as $singleModule){
    			if($singleModule->getRoles() != null){
    				array_push($this->Roles, array('module'=>$singleModule->getModuleAliasName(),'roles'=>$singleModule->getRoles()) );
    			}
    		}
		}


		
		//GET CALLED MODULE
		if((isset($_GET['module']))&&(array_key_exists($_GET['module'], $this->ModulesArray))){
			$obj = $this->ModulesArray[$_GET['module']];
		}else{
			$obj = $this->ModulesArray['PublicMain'];
		}

		//TEMPLATE VIEW //GETTING OUTPUT
		$content = null;
		$sider = null;
		
		/* Load other modules with no relation to MAP	*/
		//MainPage
		$content = utf8_encode( $obj->getView(null) );
		//Side Menu
		$sider = utf8_encode( $obj->getSideMenu() );
		//JavaScript for dashboard.html
		$this->page->addHeaderJavaScript($obj->getHeaderJavaScript());
		$this->page->addFooterJavaScript($obj->getFooterJavaScript());
		$this->page->addGlobalsJavaVars($obj->getGlobalsJavaVars());
		$this->page->addInitializeJavaScript($obj->getInitializeJavaScript());
		//CSS
		$this->page->setCSSstyles($obj->getCSS());
		

		//MainPage
		$this->page->setContent(array('content'=>$content));
		//SideMenu
		$this->page->setContent(array('tree'=>$sider));


		//TreeView - THE TREEVIEW IS NO LONGGER USED
		//$this->page->setCSSstyles( ROOT.'/zTree_v3-master/css/zTreeStyle/zTreeStyle.css');
		//$this->page->setCSSstyles( ROOT.'/zTree_v3-master/css/demo.css');
		//$this->page->addJavaScript( ROOT.'/zTree_v3-master/js/jquery.ztree.core-3.5.js');
		//$this->page->addJavaScript( ROOT.'/zTree_v3-master/js/jquery.ztree.excheck-3.5.js');
		//$this->page->addJavaScript( ROOT.'/zTree_v3-master/js/jquery.ztree.exedit-3.5.js');

		//Other
		if($this->context->usePublicMenu){$this->page->setContent(array('mainmenu'=>$menu->getView()));}
		
		//PageTitle
		$this->page->setPageTitle($obj->getPageTitle());
		//PageDescription
		$this->page->setPageDescription($obj->getPageDescription());
				
		$this->page->setTemplate('Structure1.html'); 
    	$this->page->display();

		$_GET = null;
		$_POST = null;

	}

	private function getTree(){
		//$this->page->setContent(null, array('tree'=>$tree));
	}

	public function getRoles(){
		return $this->Roles;
	}

	public function getParams(){
		return $this->params;
	}

	private function installModule($path, $alias, $obj, $checkAgainstConfig = true){
		//if($this->WebService->getUserInfo()->usr_cod == 1 || in_array($alias,$this->InstalledModules) || !$checkAgainstConfig){
			if(file_exists($path)){
				require_once $path;
				//echo 'Installed Modules:'.($alias) . '<br>';
				$this->ModulesArray[$alias]= new $obj($this);
			}
		//}
	}

}


?>