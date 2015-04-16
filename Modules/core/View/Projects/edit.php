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
			<?= CoreTranslator::Edit_Project($lang) ?>
				<br> <small></small>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Description($lang)?></label>
			<div class="col-xs-10">
				<textarea class="form-control" id="description" name="description"
				><?= $project['description'] ?></textarea>
			</div>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Status($lang)?></label>
			<div class="col-xs-10">
			<?php $active = $this->clean($project["status"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="status">
  					<OPTION value="1" <?php if($active){echo $selected;} ?>> <?= CoreTranslator::Open($lang) ?> </OPTION>
  					<OPTION value="0" <?php if(!$active){echo $selected;} ?>><?= CoreTranslator::Close($lang) ?> </OPTION>
  					
  				</select>
		    </div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='projects'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>