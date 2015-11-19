<?php $this->title = "SyGRRiF resource categories"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Resource_categories($lang)?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/resourcescategory/id">ID</a></th>
					<th><a href="sygrrif/resourcescategory/name"><?php echo  SyTranslator::Name($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $categoriesTable as $category ) : ?>
				<?php $categoryId = $this->clean ( $category ['id'] ); 
				?> 
				<tr>
					<td><?php echo  $categoryId ?></td>
				    <td><?php echo  $this->clean ( $category ['name'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='sygrrif/editresourcescategory/<?php echo  $categoryId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  SyTranslator::Edit($lang) ?></button>
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
