<?php 
require_once 'Modules/core/Model/CoreConfig.php';
$modelCoreConfig = new CoreConfig();
$sygrrifmenucolor = $modelCoreConfig->getParam("sygrrifmenucolor");
$sygrrifmenucolortxt = $modelCoreConfig->getParam("sygrrifmenucolortxt");
if ($sygrrifmenucolor == ""){
	$sygrrifmenucolor = "337ab7";
}
if($sygrrifmenucolortxt == ""){
	$sygrrifmenucolortxt = "ffffff";
}
?>

<head>

<style>
.bs-docs-header {
	position: relative;
	color: #<?php echo $sygrrifmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #<?php echo $sygrrifmenucolor?>;
}

#navlink {
	color: #<?php echo $sygrrifmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #<?php echo $sygrrifmenucolortxt?>;
	background-color: #<?php echo $sygrrifmenucolor?>;
	border: none;
	-moz-box-shadow: 0px 0px px #000000;
-webkit-box-shadow: 0px 0px px #000000;
-o-box-shadow: 0px 0px 0px #000000;
box-shadow: 0px 0px 0px #000000;
}

legend {
	color: #<?php echo $sygrrifmenucolortxt?>;
}

</style>

</head>

<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}

$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

$classWell = 'col-md-3 well';
?>
<div class="bs-docs-header" id="content">
	<div class="container">
		<h1>SyGRRif</h1>

		<div class=<?php echo $classWell?> >
			<fieldset>
				<legend><?php echo  SyTranslator::Area_and_Resources($lang) ?></legend>
					<button onclick="location.href='sygrrifareasresources/areas'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Areas($lang) ?></button>
					<button onclick="location.href='sygrrifareasresources/addarea'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sygrrifareasresources/resourcescategory'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Resource_categories($lang) ?></button>
					<button onclick="location.href='sygrrifareasresources/addresourcescategory'"
						class="btn btn-link" id="navlink">+</button>
						
				<br/>
					<button onclick="location.href='sygrrifareasresources/resources'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Resources($lang) ?></button>
					<button onclick="location.href='sygrrifareasresources/addresource'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sygrrifareasresources/colorcodes'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::color_code($lang) ?></button>
					<button onclick="location.href='sygrrifareasresources/addcolorcode'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sygrrifareasresources/blockresources'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::block_resources($lang) ?></button>		
			</fieldset>
		</div>
		
		<div class=<?php echo $classWell?> >
			<fieldset>
				<legend><?php echo  SyTranslator::Users_Authorizations($lang) ?></legend>
					<button onclick="location.href='sygrrifauthorisations/visa'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Visa($lang) ?></button>
					<button onclick="location.href='sygrrifauthorisations/editvisa'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sygrrifauthorisations/authorizations'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Active_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrifauthorisations/uauthorizations'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Unactive_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrifauthorisations/editauthorization'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Add_Authorizations($lang) ?></button>
			</fieldset>
		</div>
		
		<div class=<?php echo $classWell?> >
			<fieldset>
				<legend><?php echo  SyTranslator::Pricing($lang) ?> </legend>
					<button onclick="location.href='sygrrifpricing/pricing'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Pricings($lang) ?></button>
				<br/>
				<?php 
					$ModulesManagerModel = new ModulesManager();
					$use_project = $ModulesManagerModel->getDataMenusUserType("projects");
					if ($use_project > 0){
					?>	
					<br/>
							<button onclick="location.href='sygrrifpricing/billproject'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::bill_project($lang) ?></button>
					<?php 
					}
					else{
						?>
						<button onclick="location.href='sygrrifpricing/statpriceunits'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Bill_per_unit($lang) ?></button>
					<?php	
					}
					?>
					<button onclick="location.href='sygrrifbillmanager'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Bills_manager($lang) ?></button>
			</fieldset> 
		</div>

		<div class=<?php echo $classWell?> >
			<fieldset>
				<legend><?php echo  SyTranslator::Export_stats($lang) ?></legend>
				<p>
					<button onclick="location.href='sygrrifstats/statistics'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Statistics_Resources($lang) ?></button>
					<br/>
					<button onclick="location.href='sygrrifstatsusers/statusers'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Authorized_users($lang) ?></button>	
					<br/>
					<button onclick="location.href='sygrrif/statauthorizations'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Statistics_authorizations($lang) ?></button>
					<br/>
					<button onclick="location.href='sygrrifstats/report'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::grr_report($lang) ?></button>
							
				</p>
			</fieldset>
		</div>

	</div>
</div>


