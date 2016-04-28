<?php 
require_once 'Modules/core/Model/CoreConfig.php';
require_once 'Modules/networking/Model/NtTranslator.php';
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
-webkit-box-shadow: 0 0 0 #000000;
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

$classWell = 'col-md-4 well';
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h2><?php //echo  QoTranslator::Quotes($lang) ?></h2>

		<div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo NtTranslator::Roles($lang) ?></legend>
					<button onclick="location.href='ntroles'" class="btn btn-link" id="navlink"><?php echo  NtTranslator::Roles($lang) ?> </button>
                                        <button onclick="location.href='ntroles/edit/0'" class="btn btn-link" id="navlink">+</button>
                                <br/>
                                        <button onclick="location.href='ntgroups/rolesrights'" class="btn btn-link" id="navlink"><?php echo  NtTranslator::GroupsRights($lang) ?> </button>
                                        <button onclick="location.href='ntgroups/rolesrightsedit/0'" class="btn btn-link" id="navlink">+</button>
                                <br/>
                                        <button onclick="location.href='ntprojects/rolesrights'" class="btn btn-link" id="navlink"><?php echo  NtTranslator::ProjectsRights($lang) ?> </button>
                                        <button onclick="location.href='ntprojects/rolesrightsedit/0'" class="btn btn-link" id="navlink">+</button>
                       
                        </fieldset>
		</div>
                <div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo NtTranslator::Groups($lang) ?></legend>
					<button onclick="location.href='ntgroups'" class="btn btn-link" id="navlink"><?php echo  NtTranslator::Groups($lang) ?> </button>
                                        <button onclick="location.href='ntgroups/edit/0'" class="btn btn-link" id="navlink">+</button>
                       </fieldset>
		</div>
                <div class=<?php echo  $classWell ?>>
			<fieldset>
				<legend><?php echo NtTranslator::Projects($lang) ?></legend>
					<button onclick="location.href='ntprojects'" class="btn btn-link" id="navlink"><?php echo  NtTranslator::Projects($lang) ?> </button>
                                        <button onclick="location.href='ntprojects/edit/0'" class="btn btn-link" id="navlink">+</button>
                       </fieldset>
		</div>
	</div>
</div>


