<?php $this->title = "Fiche-Projet"?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>

<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset=UTF-8" />
	</head>


	<div class="container">
		<h1>
		<?= ProjetTranslator::Listedesprojet($lang) ?>
		<br> <small></small>
		</h1> 
		<body>	
	
			<table id="dataTable" class="table table-striped table-hover">
				<thead>
					<tr class="active">
						<th> <?= ProjetTranslator::ID($lang) ?></th>
						<th><?= ProjetTranslator::titre($lang) ?></th> <!-- à remplacer par le numéro de la fiche projet une fois ajouté à la base de donnée -->
						<th>Numero fiche projet</th>
						<th><?= ProjetTranslator::Acronyme($lang)?></th>
						<th>Modifier</th>
						<th><?= ProjetTranslator::generer($lang)?> </th>
						<th>Supprimer</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $liste as $projet ) : ?> 
					<tr>
					<?php $idform= $this->clean($projet ['idform']);?>
						<td><?= $idform?></td>
						<!--  titre -->
					<?php $titre = $this->clean ( $projet ['titre'] ); ?>
						<td><?= $titre?> </td>
						<!-- numero fiche projet -->
					<?php $numerofiche = $this->clean ( $projet ['numerofiche'] );?>
						<td><?= $numerofiche?></td>
						<!-- acronyme-->
					<?php $acronyme = $this->clean ( $projet ['acronyme'] ); ?>
						<td><?= $acronyme?></td>
						<!-- Modifier contenu -->
						
						<td><button type='button' onclick="location.href='projet/index/<?=$numerofiche?>'" class="btn btn-xs btn-primary" id="navlink"><?= ProjetTranslator::modifier($lang)?></button> </td>
				    	<td><button type='button' onclick="location.href='Generationpdf/index/<?=$numerofiche?>'" class="btn btn-xs btn-primary" id="navlink"><?= ProjetTranslator::generer($lang)?> </button> </td>
						<td><button type="button" onClick="location.href='Projet/Deletefiche/<?=$this->clean($projet['idform']) ?>'"><img src="Modules\projet\View\Projet\suplogo.jpg"/></button></td>
				    	
			    	 </tr>
			    		<?php endforeach; ?>
				</tbody>
			</table>
			
		</body>	
	</div>
	

</html>
<br/> <br/>

<?php include 'Modules/core/View/timepicker_script.php';?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
