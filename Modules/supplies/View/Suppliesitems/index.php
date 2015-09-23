<?php $this->title = "Supplies Items"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= SuTranslator::Supplies_Items($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="suppliesitems/index/id">ID</a></td>
					<td><a href="suppliesitems/index/name"><?= CoreTranslator::Name($lang) ?></a></td>
					<td><a href="suppliesitems/index/name"><?= CoreTranslator::Description($lang) ?></a></td>
					<td><a href="suppliesitems/index/name"><?= SuTranslator::Is_active($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $itemsArray as $item ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $item ['id'] ); ?>
					<td><?= $itemId ?></td>
				    <td><?= $this->clean ( $item ['name'] ); ?></td>
				    <td><?= $this->clean ( $item ['description'] ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $item ['is_active'] );
				    if ($is_active){$is_active = "yes";}
				    else{$is_active = "no";}
				    ?>
				    <td><?= $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='suppliesitems/edit/<?= $itemId ?>'" class="btn btn-xs btn-primary"><?= CoreTranslator::Edit($lang) ?></button>
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

