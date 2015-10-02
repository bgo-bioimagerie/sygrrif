
<?php 
require_once 'Modules/core/Model/CoreConfig.php';
$modelCoreConfig = new CoreConfig();
$coremenucolor = $modelCoreConfig->getParam("coremenucolor");
$coremenucolortxt = $modelCoreConfig->getParam("coremenucolortxt");
if ($coremenucolor == ""){
	$coremenucolor = "337ab7";
}
if($coremenucolortxt == ""){
	$coremenucolortxt = "ffffff";
}
?>

<head>

<style>
.bs-docs-header {
	position: relative;
	padding: 30px 15px;
	color: #<?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #<?php echo  $coremenucolor ?>;
}

#navlink {
	color: #<?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.bs-docs-header {
	position: relative;
	color: #<?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #<?php echo  $coremenucolor ?>;
}

#navlink {
	color: #<?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #<?php echo  $coremenucolortxt ?>;
	background-color: #<?php echo  $coremenucolor ?>;
	border: none;
}

legend {
	color: #<?php echo  $coremenucolortxt ?>;
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
if ($authorisations_location == 2){
	require_once 'Modules/sygrrif/Model/SyTranslator.php';
	$classWell = 'col-md-3 well';
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h2><?php echo  CoreTranslator::Users_Institutions($lang) ?></h2>
		
		<div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  CoreTranslator::Units($lang) ?></legend>
					<button onclick="location.href='units/'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Units($lang) ?></button>
				<br />
					<button onclick="location.href='units/add'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Add_unit($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo  CoreTranslator::Users($lang) ?></legend>
					<button onclick="location.href='users'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Active_Users($lang) ?> </button>
				<br/>
					<button onclick="location.href='users/unactiveusers'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Unactive_Users($lang) ?></button>
				<br/>
					<button onclick="location.href='users/add'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Add_User($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo  CoreTranslator::Export($lang) ?></legend>
					<button onclick="location.href='users/exportresponsable'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Responsible($lang) ?> </button>
			</fieldset>
		</div>
		
		<?php if ($authorisations_location == 2){ ?>
			<div class=<?php echo  $classWell ?>>
				<?php include "Modules/sygrrif/View/authorizations_navbar.php"?>
			</div>
		<?php } ?>
		
	</div>
</div>


