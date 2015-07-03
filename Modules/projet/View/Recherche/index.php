<?php $this->title = "Recherche";?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php echo $navBar;?>
<?php require_once 'Modules/projet/View/projetnavbar.php';  ?>

<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';
?>
<?php echo  $date; ?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form class="form-horizontal" enctype='multipart/form-data' id="multiphase" action="recherche/search" method="post">

	<div class="form-group">
		<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::Champs($lang) ?>:</label><br/>
			<div class="col-lg-2">
				<select class="form-control" id="champs" name="champs" >
					
					<option >Numero fiche</option>
					<option>Type projet</option>
					<option >Acronyme</option>
					<option >Type d'activite</option>
					<option >Invesigateur Principal</option>
					<option>Promoteur</option>
					<option >NAC</option>
					<option >OPG</option>
					<option >Correspondant Neurinfo</option>
					<option >Shanoir</option>
					<option >Prix</option>
					
			</select> 
			</div> 
			<div class="col-lg-2">
				<select class="form-control" id="ishere" name="ishere" >
					<option value="oui">Contient:</option>
					<option value="non">Ne contient pas:</option>
			</select> 
			</div> 
			<div class="col-lg-2">
				<input type="text" name="valeur" id="valeur" class="form-control" /> 
			</div> 
			
	</div>
	
	<div class="form-group">
		<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::typeactivite($lang) ?>:</label><br/>
			<div class="col-lg-8">
				<select class="form-control" id="typeactivite" name="typeactivite" >
					<option >---Choisissez---</option>
					<option >Promotion Partenaires CHU-RENNES</option>
					<option >Promotion Partenaires CRLCC-Inria-UR1</option>
					<option >Promotions industrielles</option>
					<option >Promotions institutionnelles Partenaire</option>
					<option >Promotions institutionnelles non Partenaire</option>
					<option><?=ProjetTranslator::psfpf($lang)?></option>
					<option ><?=ProjetTranslator::psfpnf($lang)?></option>
					<option >Projets scientifiques-hors fiche pilote</option>
					<option ><?=ProjetTranslator::AC($lang)?></option>
					<option ><?=ProjetTranslator::qualite($lang)?></option>
					<option >Formation</option>
					<option >Visites</option>
			</select> 
			</div> 
	</div>
	<div class="form-group">
		<label for="select" class="col-lg-2 control-label">Choisissez:</label><br/>
			<div class="col-lg-10" >
				<select class="form-control" id="nac" name="nac" >
					<option>---Choisissez---</option>
					<option>Neuro </option>    
					<option> Abdo</option>
					<option>Cardio</option>
				</select>
			</div>
				<br/>
	</div>
<center>
<input type="submit" value="<?=ProjetTranslator::chercher($lang)?>" class="btn btn-primary"></center>
</form>
</body>