<?php
require_once SERVER.ROOT.'Controllers/Abstract_Menu_Interface.php';
require_once SERVER.ROOT.'SmartyBuilder/SmartyBuilder.php';
require_once SERVER.ROOT.CLIENT.'standardContext.php';

abstract class Module{

	var $listener;

	/* ===================================================================================
	input: $listener
	output: null
		Construtor do módulo.
		Boa prática é fazer estas 3 linhas:
		(removido)$this->listener = $listener; **mandatório
		$this->params = $this->listener; **mandatório de irá receber e trabalhar com inputs
		$this->WebService = new Mdl_...Comm(); **padrão para trabalhar com comunicação com WebService
	=================================================================================== */
    abstract function __construct($listener);

    /* ===================================================================================
    input: null
    output: string
    	Retorna somente uma texto literal para entendimento humano com o nome do módulo
    =================================================================================== */
    abstract function getModuleAliasName();

    /* ===================================================================================
    input: null
    output: array[string]
    	Retorna um array com os nomes dos módulos que interagem com este módulo em questão,
    esses nomes são apenas para entendimento humano, para quem for habilitar ou importar os pacotes
    saber as interdependências
    =================================================================================== */
    abstract function getModuleDependency();

     /* ===================================================================================
    input: null
    output: string
    	Retorna a página completa a ser exibida pelo Dashboard. Dentro dele podemos destacar algumas subrotinas
    que serão sempre padronizadas para gerar a vista final:

	1st: ACTIONS:
		Filtro das ações que requerem comunicação com o WebService, geralmente acionadas por botões e ações
	gatilhadas da UI. uma boa prática é sempre verificar a autorização de uso para o link ser acionado, de maneira
	a evitar ataques por inserção ou repetição de POST rastreados.
	// ACTIONS ==============================
	if(isset($this->params['action'])){
		switch($this->params['action']){
			case '...':
				$this->WebService->checkPermission('...');

	2nd: ACTION DIRECTED BY EXTERNAL LINK:
		Ações que serão engatilhadas por links externos, de maneira que  UI possa ser um e-mail ou um link em página
	externa. Basicamente carrega um código sha1 que direciona o dashboard diretamente para o elemento de interesse.
	Caso não necessite de login, o link pode gerar uma visão do conteúdo do tipo público.
	//ACTION DIRECTED BY EXTERNAL LINK ==============================
		if(isset($this->params['sha1']) && $this->params['sha1'] != '' ){...}

	3rd: SUBMODULE:
		Último estágio de verificação é o que puxa o conteudo do módulo mencionado na url, ex.:
		http://localhost:28414/CorporateServices/MainScreen/Module/SubModuleName
		Nesta etapa é onde são chamadas e geradas as paǵinas e o conteúdo a ser exibido. Uma boa prática é chamar um
	template padrão caso nenhum dos submodules seja chamado, ou se o módulo for chamado puramente. Outra boa prática
	é criar o SmartyBuilder para a página principal no início do processo, e caso necessário para os submodulos, chamar
	criador de páginas adicionais que encerram dentro do mesmo case switch que foi aberto.
	// SUBMODULE ==============================
		$template = 'mdl_template.html'	;
		$this->page = new Page(new standardContext(SERVER.ROOT.'/directory'), false);
		if(isset($_GET['submodule'][0])){
			switch($_GET['submodule'][0]){
				case '...' :
					break;
				case '...':
					$pagePiece = new Page(new standardContext(SERVER.ROOT.'/mdl_directory'), false);
					echo $pagePiece->fetch('tab_subtemplate.html');
					break;

	4th: END
	return $this->page->fetch($template);
    =================================================================================== */
	abstract function getView();//$getArray = null);


	/* ===================================================================================
	input: null
    output: array(...)
    	Funções para construção de árvore. TBD
	=================================================================================== */
    abstract function nodesForTree();
    abstract function hasNodesForTree();

	/* ===================================================================================
	input: null
    output: array(MenuStructure(),...)
		Retorna o menu que deve ser implementado pelo módulo.
		Pode ser um redirecionamento de página ou uma ação engatilhada por um javascript
	=================================================================================== */
	abstract function getMenu();

	/* ===================================================================================
	input: null
    output: string
		Retorna o conteúdo em string de uma página que irá ser exibida do lado esquerdo da página.
	=================================================================================== */
	public function getSideMenu(){return null;}

	public function getConfiguration(){return null;}

	/* ================================================================================== */
	//JavaScript for Structure Window
	/* ===================================================================================
	input: null
    output: string
	=================================================================================== */
	public function getGlobalsJavaVars(){return null;}
	public function getHeaderJavaScript(){return null;}
	public function getFooterJavaScript(){return null;}
	public function getInitializeJavaScript(){return null;}

	/* ================================================================================== */
	//CSS
	/* ===================================================================================
	input: null
    output: string
	=================================================================================== */
	public function getCSS(){return null;}

	/* ================================================================================== */
	//MapResource
	/* ===================================================================================
	input: null
    output: boolean
    	É um flag que defini se o módulo é baseado em Mapas ou não.
    	Se sim, todo o retorno do getView ou das funções Java são acumuladas com todos os módulos que utilizam map
    para que sejam exibidos concatenamente na página do mapa.
	=================================================================================== */
	public function useMap(){return false;}
	
	/* ================================================================================== */
	//PAGE TITLE
	/* ===================================================================================
	 input: null
	 output: string
	 Usado para ser rastreado pelos sites de midia social para colocar o titulo da pagina corretamente
	 ultima coisa a ser feitas, depois do Getview, para os inptus poderem ser processados
	 =================================================================================== */
	public function getPageTitle(){return null;}
	
	/* ================================================================================== */
	//PAGE Description
	/* ===================================================================================
	 input: null
	 output: string
	 Usado para ser rastreado pelos sites de midia social para colocar o titulo da pagina corretamente
	 ultima coisa a ser feitas, depois do Getview, para os inptus poderem ser processados
	 =================================================================================== */
	public function getPageDescription(){return null;}

}


?>