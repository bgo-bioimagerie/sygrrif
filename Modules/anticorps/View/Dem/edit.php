<?php $this->title = "Anticorps: Modifier prélèvement"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="dem/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Modifier Dém <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Id</label>
			<div class="col-xs-10">
				<input class="form-control" id="id" type="text" name="id" disabled
				       value="<?php echo  $dem['id'] ?>"  
				/>
			</div>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?php echo  $dem['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Nom</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="nom"
				       value="<?php echo  $dem['nom'] ?>"  
				/>
			</div>
		</div>
		<br></br>		
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
		        <button type="button" onclick="location.href='<?php echo "dem/delete/".$dem['id'] ?>'" class="btn btn-danger"><?php echo  SyTranslator::Delete($lang)?></button>
				<button type="button" onclick="location.href='dem'" class="btn btn-default">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
