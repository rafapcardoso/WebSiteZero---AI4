<?php
/* Smarty version 3.1.33, created on 2019-01-31 23:34:26
  from 'C:\Users\rafae\OneDrive\Documentos\WebSiteZero - AI4\Controllers\templates\Structure1.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c5377f2201c86_87679701',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b86d7c09969e6965a75fbcb58dda798e08a7c0be' => 
    array (
      0 => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Controllers\\templates\\Structure1.html',
      1 => 1548974063,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c5377f2201c86_87679701 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    
    <!-- Structure 1 -->
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AI4 Inteligência Artificial aplicada</title>
        <meta name="description" content="AI4 Inteligência Artificial aplicada aos negócios - Manutenção Preditiva assistida por Inteligência Artificial">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="Consultoria, problema, avançado, difícil, complexo, alta complexidade, Shainin, Red-X, Brasil, Lean, Manufatura, manufacturing, enxuta, best manufacturing, desperdícios, experiência, único, especialista, investigação, investigativo, método, científico, abordagem, resolução, resolver, investigação, técnico, engenheria, manufatura, sucata, capabilidade, rejeitos, falhas, campo, problemas, garantia">
		<!-- Layer Template http://www.templatemo.com/preview/templatemo_438_layer -->
    		
		<?php if (isset($_smarty_tpl->tpl_vars['PageTitle']->value)) {?><meta property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['PageTitle']->value;?>
"/><?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['PageDescription']->value)) {?><meta property="og:description" content="<?php echo $_smarty_tpl->tpl_vars['PageDescription']->value;?>
"/><?php }?>

		<title>AI4 Inteligência Artificial aplicada aos negócios</title>
		<link rel="icon" type="image/png" href="<?php echo $_smarty_tpl->tpl_vars['HARDCODE_STYLESHEET']->value;
echo $_smarty_tpl->tpl_vars['CLIENT']->value;?>
Images/FavIcon_32x32.png" sizes="32x32">
		        
        <link rel="stylesheet" href="mdl_Public/css/bootstrap.min.css">
        <link rel="stylesheet" href="mdl_Public/css/font-awesome.min.css"> <!-- Font Awesome -->
        <link rel="stylesheet" href="mdl_Public/css/wow-animate.css"> <!-- Wow Animate -->
        <link rel="stylesheet" href="mdl_Public/css/templatemo-style.css">
        <?php echo '<script'; ?>
 src="mdl_Public/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="header" id="top">
        <nav class="navbar navbar-inverse" role="navigation">
          <div class="container">
              <div class="navbar-header">
                  <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a href="#" class="navbar-brand scroll-top" ><img src="<?php echo $_smarty_tpl->tpl_vars['HARDCODE_STYLESHEET']->value;?>
Client/Images/Logo_Transp.png" alt="Layer Template" height="30px"></a>
              </div>
              <!--/.navbar-header-->
              <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="#">Pages</a>
                    <ul class="sub-menu">
                      <li><a href="left_sidebar.html">Left Sidebar</a></li>
                      <li><a href="right_sidebar.html">Right Sidebar</a></li>
                      <li><a href="without_sidebar.html">Without Sidebar</a></li>
                    </ul>
                  </li>
                  <li><a href="columns.html">Columns</a></li>
                  <li><a href="#"><span>Sign Up</span></a></li>
                </ul>
              </div>
              <!--/.navbar-collapse-->
      		</div>
      		<!--/.container-->
      </nav>
          <!--/.navbar-->
    </div>
    <!--/.header-->

    <!-- HEADER DENTRO DO STRUCTURE1 -->
    
	<?php if (isset($_smarty_tpl->tpl_vars['mainmenu']->value)) {
echo $_smarty_tpl->tpl_vars['mainmenu']->value;
}?>

	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    
  </body>
</html>
<?php }
}
