<?php $this->title = "SyGRRiF edit Authorization"?>

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
	include "Modules/core/View/usersnavbar.php";
}
else{
	include "Modules/sygrrif/View/navbar.php"; 
}
?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/editauthorizationsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Edit_Authorization($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">ID</label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text" name="id" value="<?php echo  $this->clean($authorization['id'])?>" readonly
				/>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::User($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="user_id">
					<?php 
					    $authUserId = $this->clean($authorization['user_id']);
					    foreach ($users as $user){
					          $username = $this->clean( $user['name'] . " " . $user['firstname'] );
					          $userId = $this->clean( $user['id'] );
					          $checked = "";
					          if ($authUserId == $userId){
					          	$checked = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?php echo  $userId ?>" <?php echo  $checked ?>> <?php echo  $username ?> </OPTION>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Unit_at_the_authorization_date_time($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="unit_id">
					<?php 
					$authUnitId = $this->clean($authorization['lab_id']);
					foreach ($units as $unit):?>
					    <?php $unitname = $this->clean( $unit['name']);
					          $unitId = $this->clean( $unit['id'] );
					          $checked = "";
					          if ($authUnitId == $unitId){
					          	$checked = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?php echo  $unitId ?>" <?php echo  $checked ?>> <?php echo  $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Training_date($lang)?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>' >
					<input type='text' class="form-control" name="date"
					       value="<?php echo  CoreTranslator::dateFromEn($this->clean($authorization['date']), $lang)  ?>"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Visa($lang)?></label>
			<div class="col-xs-8">
				<select class="form-control" name="visa_id">
					<?php 
					$authVisaId = $this->clean($authorization['visa_id']);
					foreach ($visas as $visa):?>
					    <?php $visaname = $this->clean( $visa['name']);
					          $visaId = $this->clean( $visa['id'] );
					          $checked = "";
					          if ($authVisaId == $visaId){
					          	$checked = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?php echo  $visaId ?>" <?php echo  $checked ?> > <?php echo  $visaname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Resource($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="resource_id">
					<?php 
					$authResourceId = $this->clean($authorization['resource_id']);
					foreach ($resources as $resource):?>
					    <?php $resourcename = $this->clean( $resource['name']);
					          $resourceId = $this->clean( $resource['id'] );
					          $checked = "";
					          if ($authResourceId == $resourceId){
					          	$checked = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?php echo  $resourceId ?>" <?php echo  $checked ?>> <?php echo  $resourcename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Is_active($lang) ?> </label>
			<div class="col-xs-8">
				<select class="form-control" name="is_active">
				<?php 
				$is_active = $this->clean($authorization['is_active']);
				?>
				<OPTION value="1" <?php if ($is_active == 1){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
				<OPTION value="0" <?php if ($is_active == 0){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/authorizations'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
