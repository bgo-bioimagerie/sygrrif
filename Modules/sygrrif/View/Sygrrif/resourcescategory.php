<?php $this->title = "SyGRRiF resource categories"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Resource_categories($lang)?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrif/resourcescategory/id">ID</a></td>
					<td><a href="sygrrif/resourcescategory/name"><?= SyTranslator::Name($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $categoriesTable as $category ) : ?>
				<?php $categoryId = $this->clean ( $category ['id'] ); 
				?> 
				<tr>
					<td><?= $categoryId ?></td>
				    <td><?= $this->clean ( $category ['name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editresourcescategory/<?= $categoryId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
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
