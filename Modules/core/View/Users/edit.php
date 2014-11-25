<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
				Edit User <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" 
				       value="<?= $this->clean($user['name']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Firstname</label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
					   value="<?= $this->clean($user['firstname']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					value="<?= $this->clean($user['login']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Email</label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
					value="<?= $this->clean($user['email']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Phone</label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				    value="<?= $this->clean($user['tel']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit</label>
			<div class="col-xs-10">
				<input class="form-control" id="unit" type="text" name="unit"
						value="<?= $this->clean($user['unit']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Team</label>
			<div class="col-xs-10">
				<input class="form-control" id="team" type="text" name="team"
					   value="<?= $this->clean($user['team']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Responsible</label>
			<div class="col-xs-10">
				<input class="form-control" id="responsible" type="text" name="responsible"
						value="<?= $this->clean($user['responsible']); ?>"
				/>
			</div>
		</div>
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Status</label>
			<div class="col-xs-10">
				<select class="form-control" name="entry_type[]">
					<?php foreach ($statusList as $status):?>
					    <?php $statusname = $this->clean( $status['name'] ); 
					          $userstatus = $this->clean($user['status']);
					          $selected = "";
					          if ($userstatus == $statusname){
					          	$selected = "selected";
					          }
					    ?>
						<OPTION value="<?= $statusname ?>" <?= $selected ?>> <?= $statusname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br></br>
		<div class="col-md-3 col-md-offset-9">
				<button onclick="location.href='users/saveuseredits'" class="btn btn-primary" id="navlink">Save</button>
				<button type="button" onclick="location.href='users'" class="btn btn-default" id="navlink">Cancel</button>
		</div>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
