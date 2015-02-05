<?php $this->title = "SyGRRiF Database projects"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/core/View/Projects/projectsnavbar.php"; ?>
<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Projects($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="projects/index/id">ID</a></td>
					<td><a href="projects/index/name"><?= CoreTranslator::Name($lang) ?></a></td>
					<td><a href="projects/index/description"><?= CoreTranslator::Description($lang) ?></a></td>
					<td><a href="projects/index/status"><?= CoreTranslator::Status($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $projectsArray as $project ) : 
				
				?> 
				<tr>
					<?php $projectID = $this->clean ( $project ['id'] ); ?>
					<td><?= $projectID ?></td>
				    <td><?= $this->clean ( $project ['name'] ); ?></td>
				    <td><?= $this->clean ( $project ['description'] ); ?></td>
				    <?php  $status = $this->clean ( $project ['status'] );
				    	   $statusTxt = "Open";  
				    	   if ($status == 0){
				    	   		$statusTxt = "Close";
				    	   }
				    	   ?>
				    <td><?= $statusTxt ?></td>
				    <td>
				      <button type='button' onclick="location.href='projects/edit/<?= $projectID ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button>
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
