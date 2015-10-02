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
				    <?php echo  SyTranslator::Add_a_resource($lang) ?>
					<br> <small><?php echo  SyTranslator::Select_the_resource_type($lang) ?></small>
				</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Resource_type($lang) ?></label>
			<div class="col-xs-9">
					<select class="form-control" name="resource_type">
					<?php 
					    foreach ($resourcesTypes as $type){
					          $typename = $this->clean( $type['name']  );
					          $typeId = $this->clean( $type['id'] );
					    ?>
						<OPTION value="<?php echo  $typeId ?>" > <?php echo  $typename ?> </OPTION>
					<?php } ?>
				</select>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <button type="button" onclick="location.href='sygrrif/resources'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Next($lang) ?>" />
		</div>
	</form>	
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
