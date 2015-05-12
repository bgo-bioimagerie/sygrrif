<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}
</style>
</head>


<?php include "Modules/storage/View/storagenavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="storage/editquotaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?= StTranslator::Edit_Quota($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $userquota['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Login($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $userquota['login'] ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $userquota['name'] ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Firstname($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?= $userquota['firstname'] ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= StTranslator::Quota($lang) ?> (Go)</label>
			<div class="col-xs-10">
				<input class="form-control" id="quota" type="text" name="quota"
				       value="<?= $userquota['quota'] ?>"  
				/>
			</div>
		</div>
		
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='storage/usersquotas'" class="btn btn-default"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
