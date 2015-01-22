
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
		<h1>Consomables</h1>

		<div class='col-md-4 well'>
			<fieldset>
				<legend>Users</legend>
					<button onclick="location.href='suppliesusers/index'"
						class="btn btn-link" id="navlink">users</button>
					<button onclick="location.href='suppliesusers/edituser'"
						class="btn btn-link" id="navlink">Add</button>
				<br/>
					<button onclick="location.href='suppliesusers/units'"
						class="btn btn-link" id="navlink">Units</button>
					<button onclick="location.href='suppliesusers/editunit'"
						class="btn btn-link" id="navlink">Add</button>

			</fieldset>
		</div>
		<div class='col-md-4 well'>
			<fieldset>
				<legend>Comsomables</legend>
					<button onclick="location.href='consom/alllist'"
						class="btn btn-link" id="navlink">all Consom</button>
			</fieldset>
		</div>
		<div class='col-md-4 well'>
			<fieldset>
				<legend>Export</legend>
					<button onclick="location.href='concsom/bill'"
						class="btn btn-link" id="navlink">Bill</button>
			</fieldset>
		</div>

	</div>
</div>


