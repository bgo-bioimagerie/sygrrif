
<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<head>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">

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
		<h2>Anticorps</h2>
		<div class="col-md-10 col-md-offset-1">
		
		<div class='col-md-6 well'>
			<fieldset>
				<!--  <legend></legend>  -->
				    <button onclick="location.href='sources/'" class="btn btn-link" id="navlink">Sources</button>
					<button onclick="location.href='sources/add'" class="btn btn-link" id="navlink">Ajouter source</button>
				<br/>
				    <button onclick="location.href='isotypes/'" class="btn btn-link" id="navlink">Isotypes</button>
					<button onclick="location.href='isotypes/add'" class="btn btn-link" id="navlink">Ajouter Isotype</button>
				<br/>	
				    <button onclick="location.href='especes/'" class="btn btn-link" id="navlink">Espèces Tissus</button>
					<button onclick="location.href='especes/add'" class="btn btn-link" id="navlink">Ajouter Espèce Tissus</button>
				<br/>		
				    <button onclick="location.href='organes/'" class="btn btn-link" id="navlink">Organes</button>
					<button onclick="location.href='organes/add'" class="btn btn-link" id="navlink">Ajouter organe</button>	
			</fieldset>
		</div>
		
		<div class='col-md-6 well'>
			<fieldset>
				<!--  <legend></legend>  -->
				
				    <button onclick="location.href='protocols/'" class="btn btn-link" id="navlink">Protocoles</button>
					<button onclick="location.href='protocols/edit'" class="btn btn-link" id="navlink">Ajouter Protocoles</button>
				<br/>
					<button onclick="location.href='anticorps'" class="btn btn-link" id="navlink">Anticorps</button>
					<button onclick="location.href='anticorps/edit'" class="btn btn-link" id="navlink">Ajouter anticorps</button>
					
			</fieldset>
		</div>
				
	
		</div>
	</div>
</div>


