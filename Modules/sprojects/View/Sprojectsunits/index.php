<?php $this->title = "sprojects units"?>

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
			<?php echo  CoreTranslator::Units($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sprojectsunits/index/id">ID</a></td>
					<td><a href="sprojectsunits/index/name"><?php echo  CoreTranslator::Name($lang) ?></a></td>
					<td><a href="sprojectsunits/index/address"><?php echo  CoreTranslator::Address($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $unitsArray as $unit ) : 
				if ($this->clean( $unit ['id'] ) > 1){
				?> 
				<tr>
					<?php $unitId = $this->clean ( $unit ['id'] ); ?>
					<td><?php echo  $unitId ?></td>
				    <td><?php echo  $this->clean ( $unit ['name'] ); ?></td>
				    <td><?php echo  $this->clean ( $unit ['address'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sprojectsunits/edit/<?php echo  $unitId ?>'" class="btn btn-xs btn-primary"><?php echo  CoreTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
