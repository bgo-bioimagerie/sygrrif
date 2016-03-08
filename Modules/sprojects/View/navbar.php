<?php 
require_once 'Modules/core/Model/CoreConfig.php';
$modelCoreConfig = new CoreConfig();
$sprojectsmenucolor = $modelCoreConfig->getParam("sprojectsmenucolor");
$sprojectsmenucolortxt = $modelCoreConfig->getParam("sprojectsmenucolortxt");
if ($sprojectsmenucolor == ""){
	$sprojectsmenucolor = "#337ab7";
}
if($sprojectsmenucolortxt == ""){
	$sprojectsmenucolortxt = "#ffffff";
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
	color: <?php echo $sprojectsmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo $sprojectsmenucolor?>;
	border: none;
}

#navlink {
	color: <?php echo $sprojectsmenucolortxt?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	border: none;
}

.well {
	color: <?php echo $sprojectsmenucolortxt?>;
	background-color: <?php echo $sprojectsmenucolor?>;
	border: 0px solid <?php echo $sprojectsmenucolor?>;
-moz-box-shadow: 0px 0px px #000000;
-webkit-box-shadow: 0px 0px px #000000;
-o-box-shadow: 0px 0px 0px #000000;
box-shadow: 0px 0px 0px #000000;
}

legend {
	color: <?php echo $sprojectsmenucolortxt?>;
	border: none;
}
</style>

</head>

<?php
include_once 'Modules/core/Model/CoreTranslator.php';
include_once 'Modules/sprojects/Model/SpTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1> <?php echo  SpTranslator::sprojects($lang) ?> </h1>

		<?php 
		$modelConfig = new CoreConfig();
		$supliesusersdatabase = $modelConfig->getParam("sprojectsusersdatabase");
		if ($supliesusersdatabase == "local"){
		?>
		
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  CoreTranslator::Users_Institutions($lang) ?> </legend>
						<button onclick="location.href='sprojectsbelongings/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Belongings($lang) ?></button>
						<button onclick="location.href='sprojectsbelongings/edit'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sprojectsunits/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Units($lang)?></button>
					<button onclick="location.href='sprojectsunits/edit'"
						class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='sprojectsusers/index'"
						class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Users($lang) ?></button>
					<button onclick="location.href='sprojectsusers/add'"
						class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		<?php 
		}
		?>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SpTranslator::sprojects_Pricing($lang)?></legend>	

					<button onclick="location.href='sprojectsItems/index'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Items($lang) ?></button>
					<button onclick="location.href='sprojectsItems/edit'"
						class="btn btn-link" id="navlink">+</button>
				
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SpTranslator::Orders($lang)?></legend>
								
					<button onclick="location.href='sprojectsentries/openedentries'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Opened_orders($lang)?></button>
				<br/>
					<button onclick="location.href='sprojectsentries/editentries'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::New_orders($lang)?></button>
				<br/>
					<button onclick="location.href='sprojectsentries/closedentries'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Closed_orders($lang)?></button>	
				<br/>		
					<button onclick="location.href='sprojectsentries/allentries'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::All_orders($lang)?></button>


			
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?php echo  SpTranslator::Billing($lang)?></legend>	
					<button onclick="location.href='sprojectsbillmanager'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Bills_manager($lang)?></button>
				<br/>
					<button onclick="location.href='sprojectsbillmanager/billsstats'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Bills_statistics($lang)?></button>
				<br/>		 
					<button onclick="location.href='sprojectsstats'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Statistics($lang)?></button>
				<br/>
					<button onclick="location.href='sprojectsstats/responsiblelist'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Responsible_list($lang)?></button>		
			</fieldset>
		</div>
                
                <div class='col-md-3 well'>
			<fieldset>
                            <legend><?php echo  SpTranslator::Statistics($lang)?></legend>	
                                <button onclick="location.href='sprojectsbalancesheet'"
						class="btn btn-link" id="navlink"><?php echo  SpTranslator::Balance_sheet($lang)?></button>
			</fieldset>
		</div>

	</div>
</div>


