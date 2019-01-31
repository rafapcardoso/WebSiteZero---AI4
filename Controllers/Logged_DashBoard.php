<?php

/*

Revisao 0
Data 03/08/2015 - 12:36hs


*/

    require_once SERVER.ROOT.'SmartyBuilder/SmartyBuilder.php';
    require_once SERVER.ROOT.CLIENT.'standardContext.php';
	require_once SERVER.ROOT.'Controllers/Logged_Menu.php';
	require_once(SERVER.ROOT.'WebServiceCommunicator/SecureWebServiceCommunicator.php');

	
$argc = new structure();

class structure{

    var $page, $WebService, $ModulesArray, $Roles, $params, $InstalledModules;

    function __construct(){

		//WEBSERVICE
        $this->WebService = new SecureWebServiceCommunicator();
	
		$this->params = array_merge($_GET,$_POST);
        $this->page = new Page(new standardContext(SERVER.ROOT.'Controllers/templates/'));
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
		self::installModule(SERVER.ROOT.'mdl_Login/Public_Login.php','Login','LoginClass',false);
		self::installModule(SERVER.ROOT.'mdl_WebUser/mdl_WebUser.php','WebUser','WebUserAdmClass',True);
		self::installModule(SERVER.ROOT.'mdl_Blog/mdl_Blog.php','Blog','BlogClass',True);
		
		//GET MODULES MENU
		//if($_GET['module'] != "Login"){
            $menu = new Logged_Menu();
            foreach($this->ModulesArray as $singleModule){
                if($singleModule->getMenu() != null){
            		$menu->addMenuArray($singleModule->getMenu());
            	}
            }
        //}

		//GET MODULES ROLES
 		$this->Roles = array();
		foreach($this->ModulesArray as $singleModule){
			if($singleModule->getRoles() != null){
				array_push($this->Roles, array('module'=>$singleModule->getModuleAliasName(),'roles'=>$singleModule->getRoles()) );
			}
		}

		
		//GET CALLED MODULE
		if((isset($_GET['module']))&&(array_key_exists($_GET['module'], $this->ModulesArray))){
		    $obj = $this->ModulesArray[$_GET['module']];
		}else{
            $obj = null;//$this->ModulesArray['Welcome'];
		}

		
		
		//TEMPLATE VIEW //GETTING OUTPUT
		$content = null;
		$sider = null;
		if(isset($_GET['module']) && $_GET['module'] ==  'Maps'){
			/* Run if MAP is called */
			if(isset($this->ModulesArray['Maps'])){

				/* LOOP to MERGE all map datas
				The MAP can load more modules together
				this loop pass for all modules and concatenate the information
				Allmodule with self->useMap() == true is added */

				foreach($this->ModulesArray as $singleModule){
					if($singleModule->useMap()){
						//JavaScript for dashboard.html
						$this->page->addHeaderJavaScript($singleModule->getHeaderJavaScript());
						$this->page->addFooterJavaScript($singleModule->getFooterJavaScript());
						$this->page->addGlobalsJavaVars($singleModule->getGlobalsJavaVars());
						$this->page->addInitializeJavaScript($singleModule->getInitializeJavaScript());
						//CSS
						$this->page->setCSSstyles($singleModule->getCSS());
						//MainPage
						$content .= $singleModule->getView(null);
						//SideMenu
						$sider .= $singleModule->getSideMenu();
						//Turn-On Map
						$this->page->setContent(array('MapOn'=>true));
					}
				}

			}else{
				//show error menssage
				//The MAP module was colled thru URL but it is not installed
			}
		}else{
			/* Load other modules with no relation to MAP	*/
		    if($obj != null){
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
		    }
		}

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
		if(!empty($menu)){$this->page->setContent(array('mainmenu'=>$menu->getView()));}
		$this->page->setTemplate('Logged_DashBoard_2.html'); 
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