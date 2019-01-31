<?php


class Public_Menu{
    
    var $page, $menuArray, $WebService, $menuRoles;
    
    function __construct(){
        $this->menuArray = array();
        $this->WebService = new SecureWebServiceCommunicator();
       // $this->menuRoles = $this->WebService->setCurlPost("WebUser/UserPermissions",array())->payload;
    }
    
    public function addMenuArray($menu){
        self::BuildMenuRecursive($menu, $this->menuArray);
    }
    
    private function BuildMenuRecursive(&$new, &$old){
        $add = true;
        foreach($new as &$menunew){
            $add = true;
            
            foreach($old as &$menuold){
                if($menunew->nome == $menuold->nome){
                    $add = false;
                    
                    if( (!empty($menuold->submenu))&&(!empty($menunew->submenu)) ){
                        self::BuildMenuRecursive($menunew->submenu, $menuold->submenu);
                    }
                    
                    if( (empty($menuold->submenu))&&(!empty($menunew->submenu)) ){
                        $menuold->submenu = $menunew->submenu;
                    }
                    
                }
            }
            if($add){$old[] = $menunew;}
        }
    }
    
    private function FilterMenuWithAuthorization($menuArray){
        $FilteredMenu = array();
        
        foreach($menuArray as $menu){
            $myMenu = array();
            
            //converting to array to be able to count
            $menu = (array) $menu;
            
            if( !isset($menu['restriction']) ||
                (in_array($menu['restriction'], $this->menuRoles ) )||
                (in_array('SuperUser', $this->menuRoles ) )
                ){
                    
                    $mySubmenu = array();
                    if(is_array($menu['submenu'])){
                        if(count($menu['submenu'])>0){
                            $mySubmenu = self::FilterMenuWithAuthorization($menu['submenu']);
                        }//no inner menu
                    }
                    
                    if(count($mySubmenu)>0){
                        $myMenu['submenu'] = $mySubmenu;
                    }//else nothing is added
                    
                    if(isset($menu['id'])){$myMenu['id'] = $menu['id'];}
                    if(isset($menu['icon'])){$myMenu['icon'] = $menu['icon'];}
                    if(isset($menu['addr'])){$myMenu['addr'] = $menu['addr'];}
                    if(isset($menu['nome'])){$myMenu['nome'] = $menu['nome'];}
                    if(isset($menu['selected'])){$myMenu['selected'] = $menu['selected'];}
                    if(isset($menu['restriction'])){$myMenu['restriction'] = $menu['restriction'];}
                    
                    if( (isset($myMenu['submenu']) && count($myMenu['submenu'])>0) || isset($myMenu['addr']) || isset($myMenu['id']) ){
                        array_push($FilteredMenu, (object) $myMenu);
                    }//else no purpose for this menu, nothing is added
                    
            }//else nothing is added
        }
        return $FilteredMenu;
        
    }
    
    public function getView(){
        
        
        
        $context = new standardContext(SERVER.ROOT.'Controllers/templates/');
        $this->page = new Page($context, false);
        
        $template = 'Menu_Public.html';
        
        //MENU CONTENT
        
        //Process Menu
        //var_dump($this->menuArray);
        $this->menuArray = self::FilterMenuWithAuthorization($this->menuArray);
        
        $this->page->setContent(array('menuarray'=>$this->menuArray));
        $this->page->setContent(array('mainlogo'=>$context->mainLogo));
        $this->page->setContent(array('largeheader'=>$context->LargeHeader));
        $this->page->setContent(array('leftMenuName'=>$context->leftMenuName));
       
        //$username = isset($this->WebService->userName)? $this->WebService->userName : 'error';
        
        //$this->page->setContent(array('menu_usernome'=>$this->WebService->getUserName() ));
        
        //var_dump($this->WebService->getUserId());
        
        $this->page->setContent(array('ROOT'=>ROOT ));
        
        return $this->page->fetch($template) ;
    }
}
?>
