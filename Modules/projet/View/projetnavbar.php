<head>
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="externals/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="externals/datepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


<style>
.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 0px 0 rgba(0, 0, 0, .1);
	background-color: #00E0B0;
	border:0px solid #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 0px 0 rgba(0, 0, 0, .1);
	border:0px solid #337ab7;
	
}

#well {
	
	margin-top:10px;
	margin-bottom:25px;
	color: #cdbfe3;
	background-color: #00E0B0;
	border:0px solid #337ab7;
}


a{
color:#fff; 
}
</style>

</head>
<?php 

require_once 'Modules/projet/Model/ProjetTranslator.php';

$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<div class="bs-docs-header" id="content">
	<div class="container">
	<h1 style="color:#fff;"><?= ProjetTranslator::navbartitre($lang) ?></h1>

	<form role="form" class="form-horizontal" action="" method="post" id="navform">
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= ProjetTranslator::ficheprojet($lang) ?></legend>
				<div >
					<a href="Projet/index">Ajouter une nouvelle fiche-projet</a>
				</div>
			</fieldset>
		</div>
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= ProjetTranslator::listeprojets($lang) ?></legend>
				<div  >
					<a href="projet/listeform"> <?= ProjetTranslator::Listedesprojet($lang) ?></a>
				</div>
			</fieldset>
		</div>
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= ProjetTranslator::Tarifs($lang)?></legend>
				<div  >
					<a href="Tarifs/index"><?= ProjetTranslator::ajoutertarif($lang)?></a>
				</div>
			</fieldset>
		</div>
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= ProjetTranslator::user($lang)?></legend>
				<div>
					<a href="Users/add"> <?= ProjetTranslator::adduser($lang)?></a>
				</div>
			</fieldset>
		</div>
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= ProjetTranslator::listneur($lang) ?></legend>
				<div >
					<a href="Tarifs/ListTarif"><?=ProjetTranslator::listetarif($lang)?></a>
				</div>
			</fieldset>
		 </div>
	 <div class='col-md-3' id="well">
		<fieldset>
				<legend><?= ProjetTranslator::userneur($lang) ?></legend>
				<div  >
					<a href="Users/index"><?=ProjetTranslator::listeuser($lang)?></a>

				</div>
		</fieldset>
	 </div>
	  <div class='col-md-3' id="well">
		<fieldset>
				<legend><?=ProjetTranslator::rapport($lang)?></legend>
				<div  >
					<a href="recherche/search"><?=ProjetTranslator::Neurrappot($lang)?></a>

				</div>
		</fieldset>
	 </div>
		   <div class='col-md-3' id="well">
		<fieldset>
				<legend><?=ProjetTranslator:: stat($lang)?></legend>
				<div  >
					<a href="Stat/report"><?=ProjetTranslator::statNI($lang)?></a>

				</div>
		</fieldset>
	 </div>
		 
		 
	  </form>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>
