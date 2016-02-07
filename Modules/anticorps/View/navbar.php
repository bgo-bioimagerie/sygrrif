
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
    margin-bottom:0px;
}

legend {
	color: #ffffff;
}
</style>


</head>

<div class="bs-docs-header" id="content" style="margin-bottom:-20px">
	<div class="container">
		<h2>Anticorps</h2>
		<div class="col-md-12">
		<div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
				<legend>Listing </legend>
					<button onclick="location.href='anticorps'" class="btn btn-link" id="navlink">Anticorps</button>
					<button onclick="location.href='anticorps/edit'" class="btn btn-link" id="navlink">+</button>
				<br/>
					<button onclick="location.href='protocols/'" class="btn btn-link" id="navlink">Protocoles</button>
					<button onclick="location.href='protocols/edit'" class="btn btn-link" id="navlink">+</button>
			</fieldset>
		</div>
		
		<div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
			    <legend>Référence </legend>
				    <button onclick="location.href='sources/'" class="btn btn-link" id="navlink">Sources</button>
					<button onclick="location.href='sources/add'" class="btn btn-link" id="navlink">+</button>
				<br/>
				    <button onclick="location.href='isotypes/'" class="btn btn-link" id="navlink">Isotypes</button>
					<button onclick="location.href='isotypes/add'" class="btn btn-link" id="navlink">+</button>	
			</fieldset>
		</div>
		
		<div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
				<legend>Tissus </legend>	
				    <button onclick="location.href='especes/'" class="btn btn-link" id="navlink">Espèces</button>
					<button onclick="location.href='especes/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='organes/'" class="btn btn-link" id="navlink">Organes</button>
					<button onclick="location.href='organes/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='prelevements/'" class="btn btn-link" id="navlink">Prélèvements</button>
					<button onclick="location.href='prelevements/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='status/'" class="btn btn-link" id="navlink">Status</button>
					<button onclick="location.href='status/add'" class="btn btn-link" id="navlink">+</button>	
			</fieldset>
		</div>
		
		<div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
				<legend>Détails Proto </legend>	
				    <button onclick="location.href='kit/'" class="btn btn-link" id="navlink">KIT</button>
					<button onclick="location.href='kit/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='proto/'" class="btn btn-link" id="navlink">Proto</button>
					<button onclick="location.href='proto/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='fixative/'" class="btn btn-link" id="navlink">Fixative</button>
					<button onclick="location.href='fixative/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='option/'" class="btn btn-link" id="navlink">Option</button>
					<button onclick="location.href='option/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='enzymes/'" class="btn btn-link" id="navlink">Enzyme</button>
					<button onclick="location.href='enzymes/add'" class="btn btn-link" id="navlink">+</button>	
			</fieldset>
		</div>
		
		<div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
				<legend> ... </legend>	
				    <button onclick="location.href='dem/'" class="btn btn-link" id="navlink">Dém</button>
					<button onclick="location.href='dem/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='aciinc/'" class="btn btn-link" id="navlink">AcI Inc</button>
					<button onclick="location.href='aciinc/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='linker/'" class="btn btn-link" id="navlink">Linker</button>
					<button onclick="location.href='linker/add'" class="btn btn-link" id="navlink">+</button>	
				<br/>		
				    <button onclick="location.href='inc/'" class="btn btn-link" id="navlink">Linker Inc</button>
					<button onclick="location.href='inc/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='acii/'" class="btn btn-link" id="navlink">acII</button>
					<button onclick="location.href='acii/add'" class="btn btn-link" id="navlink">+</button>	
			</fieldset>
		</div>
		
                <div class='col-md-2 well'>
			<fieldset style="margin-bottom:-20px">
				<legend> ... </legend>	
				    <button onclick="location.href='application/'" class="btn btn-link" id="navlink">Application</button>
                                    <button onclick="location.href='application/add'" class="btn btn-link" id="navlink">+</button>
				<br/>		
				    <button onclick="location.href='staining/'" class="btn btn-link" id="navlink">Marquage</button>
                                    <button onclick="location.href='staining/add'" class="btn btn-link" id="navlink">+</button>	
				
			</fieldset>
		</div>    
                    
		</div>
	</div>
</div>


