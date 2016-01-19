<?php 
require_once 'Modules/core/Model/CoreConfig.php';
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
		<h2><?php echo  CoreTranslator::Users($lang) ?></h2>

		<div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  CoreTranslator::Belongings($lang) . " & " . CoreTranslator::Units($lang) ?></legend>
					<button onclick="location.href='corebelongings/'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Belongings($lang) ?></button>
					<button onclick="location.href='corebelongings/edit'" class="btn btn-link" id="navlink">+</button>
				<br/>	
					<button onclick="location.href='coreunits/'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Units($lang) ?></button>
					<button onclick="location.href='coreunits/edit'" class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		
		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo  CoreTranslator::Users($lang) ?></legend>
					<button onclick="location.href='coreusers/activeusers'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Users($lang) ?> </button>
					<button onclick="location.href='coreusers/add'" class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='coreusers/unactiveusers'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Unactive_Users($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo  CoreTranslator::Export($lang) ?></legend>
					<button onclick="location.href='coreusers/exportresponsable'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Responsible($lang) ?> </button>
			</fieldset>
		</div>
		
	</div>
</div>


