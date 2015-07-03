<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>

<?php 
require_once 'Modules/projet/Model/GestionTarif.php';
?>

<table  class="table table-striped table-hover ">
	<th>ID</th>
	<th>Name</th>
	<th>Montant </th>
	<th>Type</th>
	<th>Valide </th>
	<th>Modifier</th>
	<th>Supprimer</th>
	<tbody>
	
	
	<?php foreach($liste as $l){?>
	<tr class="active">
	<?php $idt=$this->clean($l['idt']);?>
	<td><?= $idt?> </td>
	<?php $tnom=$this->clean($l['tnom']);?>
	<td><?=$tnom?></td>
	<?php $montant=$this->clean($l['montant']);?>
	<td><?=$montant;?></td>
	<?php $type=$this->clean($l['type']);?>
	<td><?=$type?></td>
	<?php $dureevalidite=$this->clean($l['dureevalidite']);?>
	<td><?=$dureevalidite?></td>
	<td><button type='button' onclick="location.href='Tarifs/index/<?= $idt ?>'" class="btn btn-xs btn-primary" id="navlink">Modifier</button> </td>
	<td><button type="button" onClick="location.href='Tarifs/DeleteTarif/<?=$this->clean($l['idt']) ?>'"><img src="Modules\projet\View\Projet\suplogo.jpg"/></button></td>
</tr>
	<?php }?>
	</tbody>
	

</table>