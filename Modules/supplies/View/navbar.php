<?php 
require_once 'Modules/core/Model/CoreConfig.php';
$modelCoreConfig = new CoreConfig();
$suppliesmenucolor = $modelCoreConfig->getParam("suppliesmenucolor");
$suppliesmenucolortxt = $modelCoreConfig->getParam("suppliesmenucolortxt");
if ($suppliesmenucolor == ""){
	$suppliesmenucolor = "#337ab7";
}
if($suppliesmenucolortxt == ""){
	$suppliesmenucolortxt = "#ffffff";
}
?>

<head>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">


<link href="data:text/css;charset=utf-8,"
	data-href="bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet"
	id="bs-theme-stylesheet">


<style>
.bs-docs-header {
	position: relative;
	color: <?php echo $suppliesmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo $suppliesmenucolor?>;
        
}

#navlink {
	color: <?php echo $suppliesmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: <?php echo $suppliesmenucolortxt?>;
	background-color: <?php echo $suppliesmenucolor?>;
	border: 0px solid red;
	-moz-box-shadow: 0px 0px 0px <?php echo $suppliesmenucolor?>;
        -webkit-box-shadow: 0px 0px 0px <?php echo $suppliesmenucolor?>;
        -o-box-shadow: 0px 0px 0px <?php echo $suppliesmenucolor?>;
        box-shadow: 0px 0px 0px <?php echo $suppliesmenucolor?>;
}

legend {
	color: <?php echo $suppliesmenucolortxt?>;
        
}
</style>

</head>

<?php
include_once 'Modules/core/Model/CoreTranslator.php';
include_once 'Modules/supplies/Model/SuTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1> <?php echo  SuTranslator::Supplies($lang) ?> </h1>

		<?php 
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("supliesusersdatabase");
		if ($supliesusersdatabase == "local"){
		?>
		
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  CoreTranslator::Users_Institutions($lang) ?> </legend>
						<button onclick="location.href='suppliesbelongings/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Belongings($lang) ?></button>
						<button onclick="location.href='suppliesbelongings/edit'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='suppliesunits/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Units($lang)?></button>
					<button onclick="location.href='suppliesunits/edit'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='suppliesusers/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Users($lang) ?></button>
					<button onclick="location.href='suppliesusers/add'"
						class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		<?php 
		}
		?>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SuTranslator::Supplies_Pricing($lang)?></legend>	
							
					<button onclick="location.href='suppliesItems/index'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::Items($lang) ?></button>
					<button onclick="location.href='suppliesItems/edit'"
						class="btn btn-link" id="navlink">+</button>
				
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SuTranslator::Orders($lang)?></legend>
					<button onclick="location.href='suppliesentries/allentries'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::All_orders($lang)?></button>
				<br/>
					<button onclick="location.href='suppliesentries/openedentries'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::Opened_orders($lang)?></button>
				<br/>
					<button onclick="location.href='suppliesentries/closedentries'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::Closed_orders($lang)?></button>	
				<br/>
					<button onclick="location.href='suppliesentries/editentries'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::New_orders($lang)?></button>			
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SuTranslator::Billing($lang)?></legend>
					<button onclick="location.href='suppliesbill'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::Bill($lang)?></button>
				<br/>
                                	<button onclick="location.href='suppliesbill/billall'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::BillAll($lang)?></button>
				<br/>
					<button onclick="location.href='Suppliesbillmanager'"
						class="btn btn-link" id="navlink"><?php echo  SuTranslator::Bills_manager($lang)?></button>
						
			</fieldset>
			
		</div>
	</div>
</div>


