<?php $this->title = "SyGRRiF Ressources"?>

<?php echo $navBar?>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Resource($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/resources/id">ID</a></th>
					<th><a href="sygrrif/resources/name"><?php echo  SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/resources/description"><?php echo  SyTranslator::Description($lang) ?></a></th>
					<th><a href="sygrrif/resources/area_name"><?php echo  SyTranslator::Area($lang)?></a></th>
					<th><a href="sygrrif/resources/type_name"><?php echo  SyTranslator::Type($lang)?></a></th>
					<th><a href="sygrrif/resources/category_name"><?php echo  SyTranslator::Category($lang)?></a></th>
					<th><a href="sygrrif/resources/display_order"><?php echo  SyTranslator::Display_order($lang)?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $resourcesArray as $resource ) : ?> 
				<tr>
					<?php $resourceId = $this->clean ( $resource ['id'] ); ?>
					<td><?php echo  $resourceId ?></td>
				    <td><?php echo  $this->clean ( $resource ['name'] ); ?></td>
				    <td><?php echo  $this->clean ( $resource ['description'] ); ?></td>
				    <td><?php echo  $this->clean ( $resource ['area_name'] ); ?></td>
				    <td><?php echo  $this->clean ( $resource ['type_name'] ); ?></td>
				    <td><?php echo  $this->clean ( $resource ['category_name'] ); ?></td>
				    <td><?php echo  $this->clean ( $resource ['display_order'] ); ?></td>
				    <td>	
				    	<?php 
				    	if ($resource["accessibility_id"] <= $_SESSION["user_status"]){
				    	?>
				      <button type='button' onclick="location.href='<?php echo  $resource ["controller"]."/".$resource ["edit_action"]."/".$resourceId ?>'" class="btn btn-xs btn-primary"><?php echo  SyTranslator::Edit($lang) ?></button>
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
<p><?php echo  $msgError ?></p>
<?php endif; ?>
