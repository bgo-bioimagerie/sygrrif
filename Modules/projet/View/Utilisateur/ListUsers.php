<?php $this->title = "SyGRRiF Users";?>
<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>
<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';
?>
<?php 
require_once 'Modules/projet/Model/Utilisateur.php';
?>

<table  class="table table-striped table-hover ">
	<th>ID</th>
	<th><?= ProjetTranslator::nom($lang) ?></th>
	<th><?= ProjetTranslator::prenom($lang) ?> </th>
	<th>Identifiant</th>
	<th>Courrier </th>
	<th><?= ProjetTranslator::tel($lang) ?></th>
	<th>Status</th>
	<th>Charte</th>
	<th>Modifier</th>
	<th>Supprimer</th>
	<tbody>
	
	
	<?php foreach($liste as $l){?>
	<tr class="active">
	<?php $id=$this->clean($l['id']);?>
	<td><?= $id?> </td>
	<?php $nom=$this->clean($l['nom']);?>
	<td><?=$nom?></td>
	<?php $prenom=$this->clean($l['prenom']);?>
	<td><?=$prenom?></td>
	<?php $identifiant=$this->clean($l['identifiant']);?>
	<td><?=$identifiant?></td>
	<?php $courrier=$this->clean($l['courrier']);?>
	<td><?=$courrier;?></td>
	<?php $tel=$this->clean($l['tel']);?>
	<td><?=$tel?></td>
	<?php $status=$this->clean($l['status']);?>
	<td><?=$status?></td>
	<?php $charte=$this->clean($l['charte']);?>
	<td><?=$charte?></td>
	
	<td><button type='button' onclick="location.href='Utilisateur/index/<?=$id?>'" class="btn btn-xs btn-primary" id="navlink">Modifier</button> </td>
	<td><button type="button" onClick="location.href='Utilisateur/DeleteUser<?=$this->clean($l['id']) ?>'"><img src="Modules\projet\View\Projet\suplogo.jpg"/></button></td>
	</tr>
	<?php }?>
	</tbody>
	

</table>