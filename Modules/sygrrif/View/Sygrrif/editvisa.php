<?php $this->title = "SyGRRiF Edit VISA"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

if ($authorisations_location == 2){
	include "../../../core/View/usersnavbar.php";
}
else{
	include "Modules/sygrrif/View/navbar.php"; 
}
?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/editvisaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Edit_Visa($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			<input class="form-control" id="id" type="text"  name="id" value="<?php echo  $visa['id']?>" readonly/>
		</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?php echo  $visa['name'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
		        <?php if ($this->clean($visa['id']) != ""){ ?>
		        	<button type="button" onclick="location.href='<?php echo "sygrrif/deletevisa/".$this->clean($visa['id']) ?>'" class="btn btn-danger" id="navlink"><?php echo  SyTranslator::Delete($lang)?></button>
				<?php } ?>
				<button type="button" onclick="location.href='sygrrif/visa'" class="btn btn-default" id="navlink"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
