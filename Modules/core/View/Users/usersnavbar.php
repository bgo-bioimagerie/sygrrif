
<head>

<style>
.bs-docs-header {
	position: relative;
	padding: 30px 15px;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #cdbfe3;
	background-color: #337ab7;
	border: none;
}

legend {
	color: #ffffff;
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
		<h2><?= CoreTranslator::Users_Institutions($lang) ?></h2>
		
		<div class=<?= $classWell ?> >
			<fieldset>
				<legend><?= CoreTranslator::Units($lang) ?></legend>
					<button onclick="location.href='units/'" class="btn btn-link" id="navlink"><?= CoreTranslator::Units($lang) ?></button>
				<br />
					<button onclick="location.href='units/add'" class="btn btn-link" id="navlink"><?= CoreTranslator::Add_unit($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?= $classWell ?>>
			<fieldset>
				<legend><?= CoreTranslator::Users($lang) ?></legend>
					<button onclick="location.href='users'" class="btn btn-link" id="navlink"><?= CoreTranslator::Active_Users($lang) ?> </button>
				<br/>
					<button onclick="location.href='users/unactiveusers'" class="btn btn-link" id="navlink"><?= CoreTranslator::Unactive_Users($lang) ?></button>
				<br/>
					<button onclick="location.href='users/add'" class="btn btn-link" id="navlink"><?= CoreTranslator::Add_User($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?= $classWell ?>>
			<fieldset>
				<legend><?= CoreTranslator::Export($lang) ?></legend>
					<button onclick="location.href='users/exportresponsable'" class="btn btn-link" id="navlink"><?= CoreTranslator::Responsible($lang) ?> </button>
			</fieldset>
		</div>
		
		<?php if ($authorisations_location == 2){ ?>
			<div class=<?= $classWell ?>>
				<?php include "Modules/sygrrif/View/authorizations_navbar.php"?>
			</div>
		<?php } ?>
		
	</div>
</div>


