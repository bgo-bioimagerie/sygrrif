<?php 
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/catalog/Model/CaTranslator.php';
$modelCoreConfig = new CoreConfig();
$coremenucolor = $modelCoreConfig->getParam("coremenucolor");
$coremenucolortxt = $modelCoreConfig->getParam("coremenucolortxt");
if ($coremenucolor == ""){
	$coremenucolor = "#337ab7";
}
if($coremenucolortxt == ""){
	$coremenucolortxt = "#ffffff";
}
?>

<head>

<style>
.bs-docs-header {
	position: relative;
	padding: 30px 15px;
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo  $coremenucolor ?>;
}

#navlink {
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.bs-docs-header {
	position: relative;
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo  $coremenucolor ?>;
}

#navlink {
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: <?php echo  $coremenucolortxt ?>;
	background-color: <?php echo  $coremenucolor ?>;
	border: none;
	-moz-box-shadow: 0px 0px px #000000;
-webkit-box-shadow: 0px 0px px #000000;
-o-box-shadow: 0px 0px 0px #000000;
box-shadow: 0px 0px 0px #000000;
}

legend {
	color: <?php echo  $coremenucolortxt ?>;
}
</style>

</head>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}

$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

$classWell = 'col-md-4 well';
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h2><?php echo  CaTranslator::Catalog_management($lang) ?></h2>

		<div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  CaTranslator::Categories($lang) ?></legend>
					<button onclick="location.href='catalogadmin/categories'" class="btn btn-link" id="navlink"><?php echo  CaTranslator::Categories($lang) ?></button>
					<button onclick="location.href='catalogadmin/editcategory/0'" class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		
		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo  CaTranslator::Entries($lang) ?></legend>
					<button onclick="location.href='catalogadmin/entries'" class="btn btn-link" id="navlink"><?php echo  CaTranslator::Entries($lang) ?> </button>
					<button onclick="location.href='catalogadmin/editentry/0'" class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		
	</div>
</div>


