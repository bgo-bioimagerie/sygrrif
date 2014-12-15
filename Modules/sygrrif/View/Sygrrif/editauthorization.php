<?php $this->title = "SyGRRiF edit Authorization"?>

<?php echo $navBar?>

<head>
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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
	<form role="form" class="form-horizontal" action="sygrrif/editauthorizationsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Edit Authorization <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
				<input class="form-control" id="id" type="text" name="id" value="<?= $this->clean($authorization['id'])?>" readonly
				/>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">User</label>
			<div class="col-xs-10">
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
						<OPTION value="<?= $userId ?>" <?= $checked ?>> <?= $username ?> </OPTION>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit at the authorization date time</label>
			<div class="col-xs-10">
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
						<OPTION value="<?= $unitId ?>" <?= $checked ?>> <?= $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group ">
				<label for="inputEmail" class="control-label col-xs-2">Training date</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date"
					       value="<?= $this->clean($authorization['date']) ?>"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
	        <script src="bootstrap/datepicker/js/moments.js"></script>
			<script src="bootstrap/jquery-1.11.1.js"></script>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
			$(function () {
				$('#datetimepicker5').datetimepicker({
					pickTime: false
				});
			});
		    </script>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Visa</label>
			<div class="col-xs-10">
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
						<OPTION value="<?= $visaId ?>" <?= $checked ?> > <?= $visaname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Resource</label>
			<div class="col-xs-10">
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
						<OPTION value="<?= $resourceId ?>" <?= $checked ?>> <?= $resourcename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='sygrrif/authorizations'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
