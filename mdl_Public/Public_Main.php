<?php

/*
Modulo Login
VersÃ£o: 1.0 - 03/maio/2018
Trabalha na transiÃ§Ã£o mediante confirmaÃ§Ã£o de usuario e senha.
*/

//require_once SERVER.ROOT.'mdl_Blog/TextToBlog.php';
require_once SERVER.ROOT.'Controllers/Abstract_Module.php';
require_once SERVER.ROOT.'WebServiceCommunicator/SecureWebServiceCommunicator.php';


class PublicMainClass extends Module{   
    
	var $WebService, $page, $pagetitle, $pagedescription;

	function getModuleAliasName(){
		return 'Public Main';
	}
	
	function __construct($listener){
		$this->params = $listener;
		$this->WebService = new SecureWebServiceCommunicator();
	}

	function getModuleDependency(){
		return null;
	}
	
	function getView(){
	    //var_dump($_POST);
	    
	    $this->page = new Page(new standardContext(SERVER.ROOT.'mdl_Public'), false);
		
	    //ON POST SUBMITTION
	    if( isset($_POST['action']) ){
	    	switch($_POST['action']){
	    		 case 'contato':
	    		    $nome = (isset($_POST['nome']))? $_POST['nome'] : null;
	    		    $tel = (isset($_POST['telefone']))? $_POST['telefone'] : null;
	    		    $email = (isset($_POST['email']))? $_POST['email'] : null;
	    		    $motivo = (isset($_POST['motivo']))? $_POST['motivo'] : null;
	    		    $mensagem = (isset($_POST['mensagem']))? $_POST['mensagem'] : null;
	    		      
	    		    $email_message = "Nome: ".$nome."\r\n";
	    		    $email_message .= "Telefone: ".$tel."\r\n";
	    		    $email_message .= "Email: ".$email."\r\n";
	    		    $email_message .= "Motivo: ".$motivo."\r\n";
	    		    $email_message .= "Mensagem: ".$mensagem."\r\n";
	    		    
	    		    $headers = "From: rafael.pavao@rpap.com.br \r\n";
	    		    $headers .= 'Reply-To: '.$email.'\r\n ' .
   	    		    $headers .= "MIME-Version: 1.0\r\n";
   	    		    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
	    		    
	    		    if(mail("rafapcardoso@yahoo.com.br", "Contato via site", $email_message, $headers)){
	    		        header("location: " .HARDCODE_STYLESHEET.'EmailEnviado2');
	    		    }else{
	    		        header("location: " .HARDCODE_STYLESHEET.'EmailNãoEnviado');
	    		    }
	    		    
	    		    break;
				}
   		} 
		

	// SUBMODULE ==============================
	    $template = 'Public_Main.html';
		$this->page->setMainMenu(null);

	    //ON ERROR
	    if( isset($_GET['def']) ){
	        switch($_GET['def']){
	        	case 'error':
				case 'error1':
				case 'error2':
					$this->page->setContent(array('def'=>$_GET['def']));
					if(isset($_GET['errorstring'])){$this->page->setContent(array('message'=>$_GET['errorstring']));}
					break;
				case 'success':
					$this->page->setContent(array('def'=>$_GET['def']));
					$this->page->setContent(array('message'=>$_GET['message']));
					break;
				case 'Logout':
					$this->WebService->Logout();
					break;
			}
	    }
	    
	    //SET OUTTER ACTIONS
	    $template = 'Public_Main.html';
	    
		$this->page->setContent(array('get_url'=>$_GET));

		if(isset($_GET['module'])){
		    
		    switch($_GET['module']){
		        
		        case 'Case1':
		            $template = 'Case1.html';
		            $this->pagetitle="Case1: Falha em campo, alta severidade vs baixa incidência";
		            $this->pagedescription="Além do fato de ser um problema complexo para ser abordado devido a baixa incidência em campo e a não reprodutibilidade por ensaios de laboratório, este problema também é particularmente interessante por ter um pouco da abordagem tradicional sendo utilizada em seu início, e depois a aborgadem investigativa.";
		            break;
		            
		        case 'Case2':
		            $template = 'Case2.html';
		            $this->pagetitle="Case2: Quebra de Paradigmas";
		            $this->pagedescription="Como é o processo de investigação versus o pensamento sintomático natural que temos? Esta foi minha primeira experiência com investigações e processos convergentes, acredito que meus pensamentos eram os mesmo que os seus, este foi um divisor de águas.";
		            break;
		            
		        case 'ResolucaoDeProblemas':
		            $template = 'Public_Problemas.html';
		            $this->pagetitle="Técnicas Avançadas de Investigação e Resolução de Problemas";
		            $this->pagedescription="Utilize estratégias convergentes de investigação de engenharia para identificar e entender a causa da falha no mínimo espaço de tempo com o mínimo de recursos.";
		            break;
		            
		        case 'ProcessosAltaPerformance':
		            $template = 'Public_Processos.html';
		            break;
		        
		        case 'QuemSomos':
		            $template = 'Public_Quem.html';
		            $this->pagetitle=utf8_encode("Rafael Pavão Cardoso");
		            $this->pagedescription=utf8_encode("Quem é o homem por trás da tarefa");
		            break;
		            
		        case 'Projetos':
		            $template = 'Public_Projetos.html';
		            break;
		            
		        case 'Coaching':
		            $template = 'Public_Coaching.html';
		            break;
		            
		        case 'Contato':
		            $template = 'Public_Contato.html';
		            break;

		        case 'TreinamentosAplicados':
		            $link1 = $this->WebService->setCurlPost('Blog/Artigo', array('cadunico'=>3))->payload[0];
		            //var_dump($link1);exit;
		            $this->page->setContent(array('link1_titulo'=>utf8_decode($link1->titulo)));
		            $this->page->setContent(array('link1_link'=>$link1->link_externo));

		            $template = 'Public_Treinamentos.html';
		            break;
		            
		        case 'Artigos':
		            $this->page = new Page(new standardContext(SERVER.ROOT.'mdl_Blog'), false);
		            $this->maincontent = new Page(new standardContext(SERVER.ROOT.'mdl_Blog'), false);
		            $this->sidecontent = new Page(new standardContext(SERVER.ROOT.'mdl_Blog'), false);
		            
		            //SIDE CONTENT
		            $template = 'Public_BlogSide.html';
		            
		            $retorno = $this->WebService->setCurlPost('Blog/PaginaAreas',null);
		            $this->sidecontent->setContent(array('areas'=>$retorno->payload));
		            $retorno = $this->WebService->setCurlPost('Blog/Arquivos',null);
		            
		            //var_dump($retorno);exit;
		            
		            $this->sidecontent->setContent(array('arquivos'=>$retorno->payload));
		            $side = $this->sidecontent->fetch($template);
		            
		            $this->page->setContent(array('side'=>$side));
		            
		            //MAIN CONTENT
		            
		            //LINKE EXTERNO DE UM ARTIGO
		            $principal = null;
		            $secundarios = array();
		            
		            //Pode ser LISTA ou ARTIGO ESPECIFICO
		            if(isset($_GET['submodule'][0])){
		                switch($_GET['submodule'][0]){
		                    
		                    //LISTA
		                    case 'Lista':
		                        $retorno = $this->WebService->setCurlPost('Blog/ArtigosLista',array('area'=>$_GET['submodule'][1]));
		                        $this->maincontent->setContent(array('lista'=>$retorno->payload));
		                        
		                        $template = 'Public_BlogLista.html';
		                        $main = $this->maincontent->fetch($template);
		                        
		                        $this->page->setContent(array('main'=>$main));
		                        $template = 'Public_Blog.html';
		                        return $this->page->fetch($template);
		                        exit;
		                        break;
		                       		                
		                }
		                
		                $artigos = $this->WebService->setCurlPost('Blog/Pagina', array('link'=>$_GET['submodule'][0]));
		                //var_dump($artigos);exit;
		                for($i = 0; $i < count($artigos->payload); $i++){
		                    if($artigos->payload[$i]->link_externo == $_GET['submodule'][0]){
		                        $principal = $artigos->payload[$i];
		                    }else{
		                        $secundarios[] = $artigos->payload[$i];
		                    }
		                }
		            }else{
    		            //Pega ultimos 3 artigos por ordem cronologica
    	                $artigos = $this->WebService->setCurlPost('Blog/Pagina', null);
    	                //var_dump($artigos);exit;
    	                $principal = $artigos->payload[0];
    	                if(isset($artigos->payload[1])){$secundarios[] = $artigos->payload[1];}
    	                if(isset($artigos->payload[2])){$secundarios[] = $artigos->payload[2];}
		            }

		            
		            //CONVERTENDO ARTIGO DE ARQUIVO TEXTO
	                $images = array($principal->arquivo_img0,$principal->arquivo_img1,$principal->arquivo_img2,$principal->arquivo_img3);
	                //$art = (new TextToBlog(SERVER.'WebServiceZero/Arquivos/'.$principal->arquivo_texto, $images))->getConverted();
	                 	          
	                //MAIN
	                $this->maincontent->setContent(array('artigo1'=>$art));
	                //var_dump($art);exit;
	                //$this->pagetitle = $art->titulo;
	                //$this->pagedescription = $art->chamada;
	                $this->maincontent->setContent(array('principal'=>$principal));
	                $this->pagetitle = $principal->titulo;
	                $this->pagedescription = $principal->chamada;
	                
	                $template = 'Public_BlogPagina.html';
	                $main = $this->maincontent->fetch($template);
	                $this->page->setContent(array('main'=>$main));
	                
	                //PAGINA
		            $this->page->setContent(array('principal'=>$principal));
		            if(isset($secundarios[0])){$this->page->setContent(array('sec1'=>$secundarios[0]));}
		            if(isset($secundarios[1])){$this->page->setContent(array('sec2'=>$secundarios[1]));}
		            
		            $template = 'Public_Blog.html';
		            break;
		    }
		}

		return $this->page->fetch($template);
	}
	
	function getMenu(){
	    return null;
	}
	
	function getRoles(){
		return null;
	}

	function hasNodesForTree(){
		return false;
	}

	function nodesForTree(){
		return null;
	}	
	
	function getCSS(){
	    return HARDCODE_STYLESHEET."Controllers/myCarousel.css";
	}
	
	function getPageTitle(){
	    return $this->pagetitle;
	}
	
	function getPageDescription(){
	    return $this->pagedescription;
	}
	
}


?>