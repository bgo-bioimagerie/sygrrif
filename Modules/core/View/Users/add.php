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
	  <form role="form" class="form-horizontal" action="users/addquery" method="post">
		<div class="page-header">
			<h1>
				Add User <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" 
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Firstname</label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2">Login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2">Password</label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			</div>
			<label for="pwdc" class="control-label col-xs-2">Confirm</label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwdc" name="pwdc" placeholder="Password">
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Email</label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Phone</label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit</label>
			<div class="col-xs-10">
				<select class="form-control" name="unit">
					<?php foreach ($unitsList as $unit):?>
					    <?php $unitname = $this->clean( $unit['name'] );
					          $unitId = $this->clean( $unit['id'] );
					    ?>
						<OPTION value="<?= $unitId ?>" > <?= $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Team</label>
			<div class="col-xs-10">
				<select class="form-control" name="team">
					<?php foreach ($teamsList as $team):?>
					    <?php $teamname = $this->clean( $team['name'] ); 
					    	  $teamid = $this->clean( $team['id'] );
					    ?>
						<OPTION value="<?= $teamid ?>"> <?= $teamname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Responsible</label>
			<div class="col-xs-10">
				<select class="form-control" name="responsible">   
					<?php foreach ($respsList as $resp):?>
					    <?php   $respId = $this->clean( $resp['id'] );
							    $respSummary = $respId . " " . $this->clean( $resp['firstname'] ) . " " . $this->clean( $resp['name'] );
					    ?>
						<OPTION value="<?= $respId ?> " > <?= $respSummary ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"></label>
			<div class="col-xs-10">
			  <div class="checkbox">
			    <label>
			      <input type="checkbox" name="is_responsible" > is responsible
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Status</label>
			<div class="col-xs-10">
				<select class="form-control" name="status">
					<?php foreach ($statusList as $status):?>
					    <?php $statusname = $this->clean( $status['name'] );
					          $statusid = $this->clean( $status['id'] );
					    ?>
						<OPTION value="<?= $statusid ?>"> <?= $statusname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='users'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
