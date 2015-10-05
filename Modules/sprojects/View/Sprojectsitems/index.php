<?php $this->title = "sprojects Items"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/sprojects/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  SpTranslator::sprojects_Items($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sprojectsitems/index/id">ID</a></td>
					<td><a href="sprojectsitems/index/name"><?php echo  CoreTranslator::Name($lang) ?></a></td>
					<td><a href="sprojectsitems/index/name"><?php echo  CoreTranslator::Description($lang) ?></a></td>
					<td><a href="sprojectsitems/index/name"><?php echo  SpTranslator::Is_active($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $itemsArray as $item ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $item ['id'] ); ?>
					<td><?php echo  $itemId ?></td>
				    <td><?php echo  $this->clean ( $item ['name'] ); ?></td>
				    <td><?php echo  $this->clean ( $item ['description'] ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $item ['is_active'] );
				    if ($is_active){$is_active = "yes";}
				    else{$is_active = "no";}
				    ?>
				    <td><?php echo  $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='sprojectsitems/edit/<?php echo  $itemId ?>'" class="btn btn-xs btn-primary"><?php echo  CoreTranslator::Edit($lang) ?></button>
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

