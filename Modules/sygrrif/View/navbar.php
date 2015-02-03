
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

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1>SyGRRif</h1>

		
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Area and Resources</legend>
					<button onclick="location.href='sygrrif/areas'"
						class="btn btn-link" id="navlink">Areas</button>
					<button onclick="location.href='sygrrif/addarea'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='sygrrif/resourcescategory'"
						class="btn btn-link" id="navlink">Resource categories</button>
					<button onclick="location.href='sygrrif/addresourcescategory'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='sygrrif/colorcodes'"
						class="btn btn-link" id="navlink">Resource color code</button>
					<button onclick="location.href='sygrrif/addcolorcode'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='sygrrif/resources'"
						class="btn btn-link" id="navlink">Resources</button>
					<button onclick="location.href='sygrrif/addresource'"
						class="btn btn-link" id="navlink">Add</button>

			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Users Authorizations</legend>
					<button onclick="location.href='sygrrif/visa'"
						class="btn btn-link" id="navlink">Visa</button>
					<button onclick="location.href='sygrrif/addvisa'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='sygrrif/authorizations'"
						class="btn btn-link" id="navlink">Active Authorizations</button>
					<button onclick="location.href='sygrrif/uauthorizations'"
						class="btn btn-link" id="navlink">Unactive Authorizations</button>
					<button onclick="location.href='sygrrif/addauthorization'"
						class="btn btn-link" id="navlink">Add Authorizations</button>
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Pricing</legend>
					<button onclick="location.href='sygrrif/pricing'"
						class="btn btn-link" id="navlink">Pricing</button>
					<button onclick="location.href='sygrrif/addpricing'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='sygrrif/unitpricing'"
						class="btn btn-link" id="navlink">Pricing/Unit</button>
					<button onclick="location.href='sygrrif/addunitpricing'"
						class="btn btn-link" id="navlink">Add</button>
			</fieldset>
		</div>

		<div class='col-md-3 well'>
			<fieldset>
				<legend>Export</legend>
				<p>
					<button onclick="location.href='sygrrif/statistics'"
						class="btn btn-link" id="navlink">Statistics Resources</button>
					<button onclick="location.href='sygrrif/statpriceunits'"
						class="btn btn-link" id="navlink">Bill per unit</button>
					<button onclick="location.href='sygrrifbillmanager'"
						class="btn btn-link" id="navlink">Bills manager</button>	
					<button onclick="location.href='sygrrifstatsusers/statusers'"
						class="btn btn-link" id="navlink">Statistics users</button>	
					<button onclick="location.href='sygrrif/statauthorizations'"
						class="btn btn-link" id="navlink">Statistics authorizations</button>
						
					<?php 
					$ModulesManagerModel = new ModulesManager();
					$use_project = $ModulesManagerModel->getDataMenusUserType("projects");
					if ($use_project > 0){
					?>	
					<br/>
							<button onclick="location.href='sygrrifstats/billproject'"
						class="btn btn-link" id="navlink">bill project</button>
					<?php 
					}
					?>
							
				</p>
			</fieldset>
		</div>

	</div>
</div>


