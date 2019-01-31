<?php
/* Smarty version 3.1.33, created on 2019-01-28 00:31:04
  from 'C:\Users\rafae\OneDrive\Documentos\WebSiteZero - AI4\SmartyBuilder\functionbook.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c4e3f38e4b2b6_57603452',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18' => 
    array (
      0 => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\SmartyBuilder\\functionbook.html',
      1 => 1454074180,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c4e3f38e4b2b6_57603452 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'pagination' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_pagination_3138965805c4e3f38dbc764_54075808',
  ),
  'makeChartSets' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_makeChartSets_3138965805c4e3f38dbc764_54075808',
  ),
  'makeChart_Bars' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_makeChart_Bars_3138965805c4e3f38dbc764_54075808',
  ),
  'makeChart_Lines' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_makeChart_Lines_3138965805c4e3f38dbc764_54075808',
  ),
  'makeChart_Pies' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_makeChart_Pies_3138965805c4e3f38dbc764_54075808',
  ),
  'ChartDefaultOptions' => 
  array (
    'compiled_filepath' => 'C:\\Users\\rafae\\OneDrive\\Documentos\\WebSiteZero - AI4\\Client\\templates_c\\c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18_0.file.functionbook.html.php',
    'uid' => 'c96f7cc5aa7dfb1aea78db7166cf05d9010f2f18',
    'call_name' => 'smarty_template_function_ChartDefaultOptions_3138965805c4e3f38dbc764_54075808',
  ),
));
?>












<?php }
/* smarty_template_function_pagination_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_pagination_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_pagination_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>


	<?php $_smarty_tpl->_assignInScope('list', $_smarty_tpl->tpl_vars['data']->value[0]);?>
	<?php $_smarty_tpl->_assignInScope('add', $_smarty_tpl->tpl_vars['data']->value[1]);?>

	<?php if ($_smarty_tpl->tpl_vars['list']->value->totalpages > 1) {?>
		<?php $_smarty_tpl->_assignInScope('address', ((string)$_smarty_tpl->tpl_vars['add']->value));?>

				<?php if (strstr($_smarty_tpl->tpl_vars['address']->value,"?")) {
$_smarty_tpl->_assignInScope('address', ($_smarty_tpl->tpl_vars['address']->value).("&page="));?>
		<?php } else {
$_smarty_tpl->_assignInScope('address', ($_smarty_tpl->tpl_vars['address']->value).("?page="));
}?>

		<?php $_smarty_tpl->_assignInScope('filter', '');?>
		<?php if (isset($_smarty_tpl->tpl_vars['filter1value']->value)) {
$_smarty_tpl->_assignInScope('filter', ($_smarty_tpl->tpl_vars['filter']->value).("&filter1=".((string)$_smarty_tpl->tpl_vars['filter1value']->value)));
}?>
		<?php if (isset($_smarty_tpl->tpl_vars['filter2value']->value)) {
$_smarty_tpl->_assignInScope('filter', ($_smarty_tpl->tpl_vars['filter']->value).("&filter2=".((string)$_smarty_tpl->tpl_vars['filter2value']->value)));
}?>
		<?php if (isset($_smarty_tpl->tpl_vars['filter3value']->value)) {
$_smarty_tpl->_assignInScope('filter', ($_smarty_tpl->tpl_vars['filter']->value).("&filter3=".((string)$_smarty_tpl->tpl_vars['filter3value']->value)));
}?>

		<?php if ($_smarty_tpl->tpl_vars['list']->value->totalpages <= 5) {?>
			<nav>
				<ul class="pagination">
					<?php
$_smarty_tpl->tpl_vars['page'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['page']->step = 1;$_smarty_tpl->tpl_vars['page']->total = (int) ceil(($_smarty_tpl->tpl_vars['page']->step > 0 ? $_smarty_tpl->tpl_vars['list']->value->totalpages+1 - (1) : 1-($_smarty_tpl->tpl_vars['list']->value->totalpages)+1)/abs($_smarty_tpl->tpl_vars['page']->step));
if ($_smarty_tpl->tpl_vars['page']->total > 0) {
for ($_smarty_tpl->tpl_vars['page']->value = 1, $_smarty_tpl->tpl_vars['page']->iteration = 1;$_smarty_tpl->tpl_vars['page']->iteration <= $_smarty_tpl->tpl_vars['page']->total;$_smarty_tpl->tpl_vars['page']->value += $_smarty_tpl->tpl_vars['page']->step, $_smarty_tpl->tpl_vars['page']->iteration++) {
$_smarty_tpl->tpl_vars['page']->first = $_smarty_tpl->tpl_vars['page']->iteration === 1;$_smarty_tpl->tpl_vars['page']->last = $_smarty_tpl->tpl_vars['page']->iteration === $_smarty_tpl->tpl_vars['page']->total;?>
					<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage == $_smarty_tpl->tpl_vars['page']->value) {?><li class="active"><?php } else { ?><li><?php }?><a href="<?php echo ($_smarty_tpl->tpl_vars['address']->value).($_smarty_tpl->tpl_vars['page']->value);
echo $_smarty_tpl->tpl_vars['filter']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<span class="sr-only">(current)</span></a></li>
					<?php }
}
?>
				</ul>
			</nav>
		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage <= 2) {?>
				<?php $_smarty_tpl->_assignInScope('start', 1);?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage > 2) {?>
				<?php $_smarty_tpl->_assignInScope('start', $_smarty_tpl->tpl_vars['list']->value->actualpage-2);?>
			<?php }?>
			<nav>
				<ul class="pagination">
					<?php $_smarty_tpl->_assignInScope('previous', ($_smarty_tpl->tpl_vars['list']->value->actualpage-1));?>
					<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage != 1) {?><li><a href="<?php echo ($_smarty_tpl->tpl_vars['address']->value).($_smarty_tpl->tpl_vars['previous']->value);
echo $_smarty_tpl->tpl_vars['filter']->value;?>
" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?php }?>
					<?php
$_smarty_tpl->tpl_vars['page'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['page']->step = 1;$_smarty_tpl->tpl_vars['page']->total = (int) min(ceil(($_smarty_tpl->tpl_vars['page']->step > 0 ? $_smarty_tpl->tpl_vars['list']->value->totalpages+1 - ($_smarty_tpl->tpl_vars['start']->value) : $_smarty_tpl->tpl_vars['start']->value-($_smarty_tpl->tpl_vars['list']->value->totalpages)+1)/abs($_smarty_tpl->tpl_vars['page']->step)),5);
if ($_smarty_tpl->tpl_vars['page']->total > 0) {
for ($_smarty_tpl->tpl_vars['page']->value = $_smarty_tpl->tpl_vars['start']->value, $_smarty_tpl->tpl_vars['page']->iteration = 1;$_smarty_tpl->tpl_vars['page']->iteration <= $_smarty_tpl->tpl_vars['page']->total;$_smarty_tpl->tpl_vars['page']->value += $_smarty_tpl->tpl_vars['page']->step, $_smarty_tpl->tpl_vars['page']->iteration++) {
$_smarty_tpl->tpl_vars['page']->first = $_smarty_tpl->tpl_vars['page']->iteration === 1;$_smarty_tpl->tpl_vars['page']->last = $_smarty_tpl->tpl_vars['page']->iteration === $_smarty_tpl->tpl_vars['page']->total;?>
					<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage == $_smarty_tpl->tpl_vars['page']->value) {?><li class="active"><?php } else { ?><li><?php }?><a href="<?php echo ($_smarty_tpl->tpl_vars['address']->value).($_smarty_tpl->tpl_vars['page']->value);
echo $_smarty_tpl->tpl_vars['filter']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<span class="sr-only">(current)</span></a></li>
					<?php }
}
?>
					<?php $_smarty_tpl->_assignInScope('next', ($_smarty_tpl->tpl_vars['list']->value->actualpage+1));?>
					<?php if ($_smarty_tpl->tpl_vars['list']->value->actualpage != $_smarty_tpl->tpl_vars['list']->value->totalpages) {?><li><a href="<?php echo ($_smarty_tpl->tpl_vars['address']->value).($_smarty_tpl->tpl_vars['next']->value);
echo $_smarty_tpl->tpl_vars['filter']->value;?>
" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?php }?>
				</ul>
			</nav>
		<?php }?>
	<?php }
}}
/*/ smarty_template_function_pagination_3138965805c4e3f38dbc764_54075808 */
/* smarty_template_function_makeChartSets_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_makeChartSets_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_makeChartSets_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

	<?php $_smarty_tpl->_assignInScope('chartnumber', $_smarty_tpl->tpl_vars['data']->value[0]);?>
	<?php $_smarty_tpl->_assignInScope('variantarray', $_smarty_tpl->tpl_vars['data']->value[1]);?>
	<?php if (isset($_smarty_tpl->tpl_vars['data']->value[2])) {
$_smarty_tpl->_assignInScope('color1', $_smarty_tpl->tpl_vars['data']->value[2]);
} else {
$_smarty_tpl->_assignInScope('color1', array(180,180,180));
}?>
	<?php if (isset($_smarty_tpl->tpl_vars['data']->value[3])) {
$_smarty_tpl->_assignInScope('color2', $_smarty_tpl->tpl_vars['data']->value[3]);
} else {
$_smarty_tpl->_assignInScope('color2', array(151,18,255));
}?>
	<?php if (isset($_smarty_tpl->tpl_vars['data']->value[4])) {
$_smarty_tpl->_assignInScope('color3', $_smarty_tpl->tpl_vars['data']->value[4]);
} else {
$_smarty_tpl->_assignInScope('color3', array(151,187,205));
}?>

		<?php if (isset($_smarty_tpl->tpl_vars['variantarray']->value->x) && isset($_smarty_tpl->tpl_vars['variantarray']->value->y1)) {?>

		var GlobalLabels<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = [<?php echo implode(', ',$_smarty_tpl->tpl_vars['variantarray']->value->x);?>
];
		<?php if (count($_smarty_tpl->tpl_vars['variantarray']->value->y2) == 0) {?>
			var GlobalDataset<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = [
				{	fillColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.5)",
					strokeColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.8)",
					highlightFill: "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.75)",
					highlightStroke: "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,1)",
					data :  [<?php echo implode(', ',$_smarty_tpl->tpl_vars['variantarray']->value->y1);?>
]
				} ];
		<?php } else { ?>
			var GlobalDataset<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = [
			{
				label: '<?php echo $_smarty_tpl->tpl_vars['variantarray']->value->ylabels[0];?>
',
				fillColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.5)",
				strokeColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.8)",
				highlightFill: "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,0.75)",
				highlightStroke: "rgba(<?php echo $_smarty_tpl->tpl_vars['color1']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color1']->value[2];?>
,1)",
				data :  [<?php echo implode(', ',$_smarty_tpl->tpl_vars['variantarray']->value->y1);?>
]
			}
			,{
				label: '<?php echo $_smarty_tpl->tpl_vars['variantarray']->value->ylabels[1];?>
',
				fillColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color2']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[2];?>
,0.5)",
				strokeColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color2']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[2];?>
,0.8)",
				highlightFill: "rgba(<?php echo $_smarty_tpl->tpl_vars['color2']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[2];?>
,0.75)",
				highlightStroke: "rgba(<?php echo $_smarty_tpl->tpl_vars['color2']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color2']->value[2];?>
,1)",
				data :  [<?php echo implode(', ',$_smarty_tpl->tpl_vars['variantarray']->value->y2);?>
]
			}
			<?php if (count($_smarty_tpl->tpl_vars['variantarray']->value->y3) > 0) {?>
				,{
					label: '<?php echo $_smarty_tpl->tpl_vars['variantarray']->value->ylabels[2];?>
',
					fillColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color3']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[2];?>
,0.5)",
					strokeColor : "rgba(<?php echo $_smarty_tpl->tpl_vars['color3']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[2];?>
,0.8)",
					highlightFill: "rgba(<?php echo $_smarty_tpl->tpl_vars['color3']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[2];?>
,0.75)",
					highlightStroke: "rgba(<?php echo $_smarty_tpl->tpl_vars['color3']->value[0];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[1];?>
,<?php echo $_smarty_tpl->tpl_vars['color3']->value[2];?>
,1)",
					data :  [<?php echo implode(', ',$_smarty_tpl->tpl_vars['variantarray']->value->y3);?>
]
				}
			<?php }?>
		];
		<?php }?>
		var barChartData<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = { 	labels : GlobalLabels<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
,	datasets : GlobalDataset<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 }
	<?php } else { ?>
		<p>Variables x and y1 not identified in chart number: <?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
</p>
	<?php }
}}
/*/ smarty_template_function_makeChartSets_3138965805c4e3f38dbc764_54075808 */
/* smarty_template_function_makeChart_Bars_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_makeChart_Bars_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_makeChart_Bars_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

	var ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = document.getElementById("chart<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
").getContext("2d");
	window.myBar<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = new Chart(ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
).Bar(barChartData<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
, {		responsive : true, scaleBeginAtZero : true		});
<?php
}}
/*/ smarty_template_function_makeChart_Bars_3138965805c4e3f38dbc764_54075808 */
/* smarty_template_function_makeChart_Lines_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_makeChart_Lines_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_makeChart_Lines_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

	var ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = document.getElementById("chart<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
").getContext("2d");
	window.myBar<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = new Chart(ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
).Line(barChartData<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
, {		responsive : true,datasetFill : false,datasetStrokeWidth : 4	});
<?php
}}
/*/ smarty_template_function_makeChart_Lines_3138965805c4e3f38dbc764_54075808 */
/* smarty_template_function_makeChart_Pies_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_makeChart_Pies_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_makeChart_Pies_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

	var ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = document.getElementById("chart<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
").getContext("2d");
	window.myBar<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
 = new Chart(ctx<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
).Pie(barChartData<?php echo $_smarty_tpl->tpl_vars['chartnumber']->value;?>
, {		responsive : true	});
<?php
}}
/*/ smarty_template_function_makeChart_Pies_3138965805c4e3f38dbc764_54075808 */
/* smarty_template_function_ChartDefaultOptions_3138965805c4e3f38dbc764_54075808 */
if (!function_exists('smarty_template_function_ChartDefaultOptions_3138965805c4e3f38dbc764_54075808')) {
function smarty_template_function_ChartDefaultOptions_3138965805c4e3f38dbc764_54075808(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

	
	Chart.defaults.global.pointHitDetectionRadius = 1;
	Chart.defaults.global.multiTooltipTemplate = "<?php echo '<%'; ?>
if (label){<?php echo '%>';
echo '<%'; ?>
=datasetLabel<?php echo '%>'; ?>
 <?php echo '<%'; ?>
}<?php echo '%>';
echo '<%'; ?>
= value <?php echo '%>'; ?>
";
	Chart.defaults.global.showInLegend= true;
	Chart.defaults.global.scaleFontSize= 20;
	Chart.defaults.global.tooltipTitleFontSize= 20;
	Chart.defaults.global.scaleFontStyle= "normal";
	Chart.defaults.global.datasetFill= 0;
	
<?php
}}
/*/ smarty_template_function_ChartDefaultOptions_3138965805c4e3f38dbc764_54075808 */
}
