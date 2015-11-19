<?php $this->title = "SyGRRiF add Authorization"?>

<?php echo $navBar?>

<head>
<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">

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
	<form role="form" class="form-horizontal" action="sygrrif/addauthorizationsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Add_Authorization($lang) ?> <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::User($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="user_id">
					<?php foreach ($users as $user):?>
					    <?php $username = $this->clean( $user['name'] . " " . $user['firstname'] );
					          $userId = $this->clean( $user['id'] );
					    ?>
						<OPTION value="<?php echo  $userId ?>" > <?php echo  $username ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<!-- 
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Unit_at_the_authorization_date_time($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="unit_id">
					<?php foreach ($units as $unit):?>
					    <?php $unitname = $this->clean( $unit['name']);
					          $unitId = $this->clean( $unit['id'] );
					    ?>
						<OPTION value="<?php echo  $unitId ?>" > <?php echo  $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		-->
		<div class="form-group ">
				<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Training_date($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?php echo  $lang ?>' >
					<input type='text' class="form-control" name="date"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Visa($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="visa_id">
					<?php foreach ($visas as $visa):?>
					    <?php $visaname = $this->clean( $visa['name']);
					          $visaId = $this->clean( $visa['id'] );
					    ?>
						<OPTION value="<?php echo  $visaId ?>" > <?php echo  $visaname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Resource($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="resource_id">
					<?php foreach ($resources as $resource):?>
					    <?php $resourcename = $this->clean( $resource['name']);
					          $resourceId = $this->clean( $resource['id'] );
					    ?>
						<OPTION value="<?php echo  $resourceId ?>" > <?php echo  $resourcename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/authorizations'" class="btn btn-default" id="navlink"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
