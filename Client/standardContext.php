<?php
require_once SERVER.ROOT.'SmartyBuilder/class_Context.php';
require_once SERVER.ROOT.'WebServiceCommunicator/SecureWebServiceCommunicator.php';

class standardContext extends Context{


		public function __construct($module_template = null){
			$this->leftMenuName = "PickUp";
			$this->usePublicMenu = false;
			$this->clientPath = dirname(__FILE__);

			$this->template =  (isset($module_template))? $module_template : SERVER.ROOT.CLIENT."templates";
			$this->template_c =  SERVER.ROOT.CLIENT."templates_c";
			$this->cache = SERVER.ROOT."SmartBuilder/cache";
			$this->config = SERVER.ROOT."SmartBuilder/configs";
			//$this->security = true;
			$this->LargeHeader = false;

			$this->clientCSS = HARDCODE_STYLESHEET.CLIENT."color_scheme.css";
			$this->mainLogo =  HARDCODE_STYLESHEET.CLIENT."Images/mainlogo.png";
			
			$this->WebServiceCom = new SecureWebServiceCommunicator();
		}

	}

?>
