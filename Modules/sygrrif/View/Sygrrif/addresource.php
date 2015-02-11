<?php $this->title = "SyGRRiF add resource"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/addresource"
		method="post">
		<div class="page-header">
				<h1>
				    <?= SyTranslator::Add_a_resource($lang) ?>
					<br> <small><?= SyTranslator::Select_the_resource_type($lang) ?></small>
				</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3"><?= SyTranslator::Resource_type($lang) ?></label>
			<div class="col-xs-9">
					<select class="form-control" name="resource_type">
					<?php 
					    foreach ($resourcesTypes as $type){
					          $typename = $this->clean( $type['name']  );
					          $typeId = $this->clean( $type['id'] );
					    ?>
						<OPTION value="<?= $typeId ?>" > <?= $typename ?> </OPTION>
					<?php } ?>
				</select>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <button type="button" onclick="location.href='sygrrif/resources'" class="btn btn-default" id="navlink"><?= SyTranslator::Cancel($lang) ?></button>
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Next($lang) ?>" />
		</div>
	</form>	
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
