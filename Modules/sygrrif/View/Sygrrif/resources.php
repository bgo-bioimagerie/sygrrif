<?php $this->title = "SyGRRiF Ressources"?>

<?php echo $navBar?>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Resource($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/resources/id">ID</a></th>
					<th><a href="sygrrif/resources/name"><?= SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/resources/description"><?= SyTranslator::Description($lang) ?></a></th>
					<th><a href="sygrrif/resources/area_name"><?= SyTranslator::Area($lang)?></a></th>
					<th><a href="sygrrif/resources/type_name"><?= SyTranslator::Type($lang)?></a></th>
					<th><a href="sygrrif/resources/category_name"><?= SyTranslator::Category($lang)?></a></th>
					<th><a href="sygrrif/resources/display_order"><?= SyTranslator::Display_order($lang)?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $resourcesArray as $resource ) : ?> 
				<tr>
					<?php $resourceId = $this->clean ( $resource ['id'] ); ?>
					<td><?= $resourceId ?></td>
				    <td><?= $this->clean ( $resource ['name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['description'] ); ?></td>
				    <td><?= $this->clean ( $resource ['area_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['type_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['category_name'] ); ?></td>
				    <td><?= $this->clean ( $resource ['display_order'] ); ?></td>
				    <td>	
				    	<?php 
				    	if ($resource["accessibility_id"] <= $_SESSION["user_status"]){
				    	?>
				      <button type='button' onclick="location.href='<?= $resource ["controller"]."/".$resource ["edit_action"]."/".$resourceId ?>'" class="btn btn-xs btn-primary"><?= SyTranslator::Edit($lang) ?></button>
				    	<?php 
				    	}
				    	?>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
