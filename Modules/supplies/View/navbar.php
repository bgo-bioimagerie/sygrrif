
<head>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">


<link href="data:text/css;charset=utf-8,"
	data-href="bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet"
	id="bs-theme-stylesheet">


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
include_once 'Modules/core/Model/CoreTranslator.php';
include_once 'Modules/supplies/Model/SuTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1> <?= SuTranslator::Supplies($lang) ?> </h1>

		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= CoreTranslator::Users_Institutions($lang) ?> </legend>
					<button onclick="location.href='suppliesusers/index'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Users($lang) ?></button>
					<button onclick="location.href='suppliesusers/edit'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Add($lang)?></button>
				<br/>
					<button onclick="location.href='suppliesunits/index'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Units($lang)?></button>
					<button onclick="location.href='suppliesunits/add'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Add($lang)?></button>

			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SuTranslator::Supplies_Pricing($lang)?></legend>	
							
					<button onclick="location.href='suppliespricing'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Pricing($lang)?></button>
					<button onclick="location.href='suppliespricing/addpricing'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Add($lang)?></button>
				<br/>
					<button onclick="location.href='suppliespricing/unitpricing'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Pricing_per_unit($lang) ?></button>
					<button onclick="location.href='suppliespricing/addunitpricing'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Add($lang)?></button>
				<br/>
					<button onclick="location.href='suppliesItems/index'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Items($lang) ?></button>
					<button onclick="location.href='suppliesItems/edit'"
						class="btn btn-link" id="navlink"><?= CoreTranslator::Add($lang)?></button>
				
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SuTranslator::Orders($lang)?></legend>
					<button onclick="location.href='suppliesentries'"
						class="btn btn-link" id="navlink"><?= SuTranslator::All_orders($lang)?></button>
				</br>
					<button onclick="location.href='suppliesentries/openedentries'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Opened_orders($lang)?></button>
				</br>
					<button onclick="location.href='suppliesentries/closedentries'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Closed_orders($lang)?></button>	
				</br>
					<button onclick="location.href='suppliesentries/editentries'"
						class="btn btn-link" id="navlink"><?= SuTranslator::New_orders($lang)?></button>			
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend><?= SuTranslator::Billing($lang)?></legend>
					<button onclick="location.href='suppliesbill'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Bill($lang)?></button>
				</br>		
					<button onclick="location.href='Suppliesbillmanager'"
						class="btn btn-link" id="navlink"><?= SuTranslator::Bills_manager($lang)?></button>
						
			</fieldset>
			
			
			
		</div>

	</div>
</div>


