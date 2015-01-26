<?php $this->title = "SyGRRiF Database projects"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}
</style>
</head>


<?php include "Modules/core/View/Projects/projectsnavbar.php"; ?>
<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="projects/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Edit Project <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $project['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $project['name'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Description</label>
			<div class="col-xs-10">
				<textarea class="form-control" id="description" type="textarea" name="description"
				><?= $project['description'] ?></textarea>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='projects'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
