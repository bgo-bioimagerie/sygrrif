<?php $this->title = "SyGRRiF Visa"?>

<?php echo $navBar?>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

if ($authorisations_location == 2){
	include "../../../core/View/usersnavbar.php";
}
else{
	include "Modules/sygrrif/View/navbar.php"; 
}
?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Visa($lang)?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/visa/id">ID</a></th>
					<th><a href="sygrrif/visa/name"><?= SyTranslator::Name($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $visaTable as $visa ) : ?>
				<?php $visaId = $this->clean ( $visa ['id'] ); 
					if ($visaId > 1){
				?> 
				<tr>
					<td><?= $visaId ?></td>
				    <td><?= $this->clean ( $visa ['name'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='sygrrif/editvisa/<?= $visaId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
