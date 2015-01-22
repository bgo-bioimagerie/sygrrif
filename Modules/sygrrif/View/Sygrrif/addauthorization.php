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


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/addauthorizationsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Add Authorization <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">User</label>
			<div class="col-xs-10">
				<select class="form-control" name="user_id">
					<?php foreach ($users as $user):?>
					    <?php $username = $this->clean( $user['name'] . " " . $user['firstname'] );
					          $userId = $this->clean( $user['id'] );
					    ?>
						<OPTION value="<?= $userId ?>" > <?= $username ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit at the authorization date time</label>
			<div class="col-xs-10">
				<select class="form-control" name="unit_id">
					<?php foreach ($units as $unit):?>
					    <?php $unitname = $this->clean( $unit['name']);
					          $unitId = $this->clean( $unit['id'] );
					    ?>
						<OPTION value="<?= $unitId ?>" > <?= $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group ">
				<label for="inputEmail" class="control-label col-xs-2">Training date</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
	        <script src="externals/datepicker/js/moments.js"></script>
			<script src="externals/jquery-1.11.1.js"></script>
			<script src="externals/datepicker/js/bootstrap-datetimepicker.min.js"></script>
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
					<?php foreach ($visas as $visa):?>
					    <?php $visaname = $this->clean( $visa['name']);
					          $visaId = $this->clean( $visa['id'] );
					    ?>
						<OPTION value="<?= $visaId ?>" > <?= $visaname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Resource</label>
			<div class="col-xs-10">
				<select class="form-control" name="resource_id">
					<?php foreach ($resources as $resource):?>
					    <?php $resourcename = $this->clean( $resource['name']);
					          $resourceId = $this->clean( $resource['id'] );
					    ?>
						<OPTION value="<?= $resourceId ?>" > <?= $resourcename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button type="button" onclick="location.href='sygrrif/authorizations'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
