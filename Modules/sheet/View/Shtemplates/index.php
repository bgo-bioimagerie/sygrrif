<?php $this->title = "SyGRRiF Database units"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/sheet/View/navbar.php"; ?>
<?php require_once 'Modules/sheet/Model/ShTranslator.php';?>

	<div class="col-md-9">
	
		<div class="page-header">
			<h1>
			<?= ShTranslator::Templates($lang) ?>
			  <br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<td><a href="shtemplates/index/id">ID</a></td>
					<td><a href="shtemplates/index/name"><?= CoreTranslator::Name($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $templates as $template ) : 
				?> 
				<tr>
					<?php $unitId = $this->clean ( $template ['id'] ); ?>
					<td><?= $unitId ?></td>
				    <td><?= $this->clean ( $template ['name'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='shtemplates/edit/<?= $unitId ?>'" class="btn btn-xs btn-primary"><?= CoreTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
