
<head>

<style>
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
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1>SyGRRif</h1>

		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SyTranslator::Area_and_Resources($lang) ?></legend>
					<button onclick="location.href='sygrrif/areas'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Areas($lang) ?></button>
					<button onclick="location.href='sygrrif/addarea'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/resourcescategory'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Resource_categories($lang) ?></button>
					<button onclick="location.href='sygrrif/addresourcescategory'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
						
				<br/>
					<button onclick="location.href='sygrrif/resources'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Resources($lang) ?></button>
					<button onclick="location.href='sygrrif/addresource'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/colorcodes'"
						class="btn btn-link" id="navlink"><?= SyTranslator::color_code($lang) ?></button>
					<button onclick="location.href='sygrrif/addcolorcode'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/blockresources'"
						class="btn btn-link" id="navlink"><?= SyTranslator::block_resources($lang) ?></button>		
			</fieldset>
		</div>
		<!--  
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SyTranslator::Users_Authorizations($lang) ?></legend>
					<button onclick="location.href='sygrrif/visa'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Visa($lang) ?></button>
					<button onclick="location.href='sygrrif/addvisa'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/authorizations'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Active_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/uauthorizations'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Unactive_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/addauthorization'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add_Authorizations($lang) ?></button>
			</fieldset>
		</div> 
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SyTranslator::Pricing($lang) ?> </legend>
					<button onclick="location.href='sygrrif/pricing'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Pricings($lang) ?></button>
					<button onclick="location.href='sygrrif/addpricing'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/unitpricing'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Pricing_Unit($lang) ?></button>
					<button onclick="location.href='sygrrif/addunitpricing'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
			</fieldset> 
		</div>-->
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SyTranslator::Pricing($lang) ?> </legend>
					<button onclick="location.href='Tarifs/ListTarif'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Pricings($lang) ?></button>
					<button onclick="location.href='Tarifs/index'" class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
			</fieldset> 
		</div>

		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SyTranslator::Export($lang) ?></legend>
				<p>
					<button onclick="location.href='sygrrif/statistics'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Statistics_Resources($lang) ?></button>
					
					<?php 
					$ModulesManagerModel = new ModulesManager();
					$use_project = $ModulesManagerModel->getDataMenusUserType("projects");
					if ($use_project > 0){
					?>	
					<br/>
							<button onclick="location.href='sygrrifstats/billproject'"
						class="btn btn-link" id="navlink"><?= SyTranslator::bill_project($lang) ?></button>
					<?php 
					}
					else{
						?>
						<button onclick="location.href='sygrrif/statpriceunits'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Bill_per_unit($lang) ?></button>
					<?php	
					}
					?>
					<button onclick="location.href='sygrrifbillmanager'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Bills_manager($lang) ?></button>	
							<!-- 
					<button onclick="location.href='sygrrifstatsusers/statusers'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Authorized_users($lang) ?></button>	
					<button onclick="location.href='sygrrif/statauthorizations'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Statistics_authorizations($lang) ?></button> -->
					<button onclick="location.href='sygrrifstats/report'"
						class="btn btn-link" id="navlink"><?= SyTranslator::grr_report($lang) ?></button>
							
				</p>
			</fieldset>
		</div>

	</div>
</div>


