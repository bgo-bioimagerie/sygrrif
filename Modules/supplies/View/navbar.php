
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
		<h1>Supplies</h1>

		<div class='col-md-3 well'>
			<fieldset>
				<legend>Users/units</legend>
					<button onclick="location.href='suppliesusers/index'"
						class="btn btn-link" id="navlink">Users</button>
					<button onclick="location.href='suppliesusers/edit'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='suppliesunits/index'"
						class="btn btn-link" id="navlink">Units</button>
					<button onclick="location.href='suppliesunits/add'"
						class="btn btn-link" id="navlink">Add</button>

			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Supplies/Pricing</legend>	
							
					<button onclick="location.href='suppliespricing'"
						class="btn btn-link" id="navlink">Pricing</button>
					<button onclick="location.href='suppliespricing/addpricing'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='suppliespricing/unitpricing'"
						class="btn btn-link" id="navlink">Pricing per unit</button>
					<button onclick="location.href='suppliespricing/addunitpricing'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='suppliesItems/index'"
						class="btn btn-link" id="navlink">Items</button>
					<button onclick="location.href='suppliesItems/edit'"
						class="btn btn-link" id="navlink">Add</button>
				
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Orders</legend>
					<button onclick="location.href='suppliesentries'"
						class="btn btn-link" id="navlink">All orders</button>
				</br>
					<button onclick="location.href='suppliesentries/openedentries'"
						class="btn btn-link" id="navlink">Opened orders</button>
				</br>
					<button onclick="location.href='suppliesentries/closedentries'"
						class="btn btn-link" id="navlink">Closed orders</button>	
				</br>
					<button onclick="location.href='suppliesentries/editentries'"
						class="btn btn-link" id="navlink">New orders</button>			
			</fieldset>
		</div>
		<div class='col-md-3 well'>
			<fieldset>
				<legend>Stats & Bills</legend>
					<button onclick="location.href='suppliesbill'"
						class="btn btn-link" id="navlink">Bill</button>
			</fieldset>
		</div>

	</div>
</div>


