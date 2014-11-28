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
	  <form role="form" class="form-horizontal" action="users/editquery" method="post">
		<div class="page-header">
			<h1>
				Edit User <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $user['id'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?= $user['name'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Firstname</label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = "<?= $user['firstname'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2">Login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?= $user['login'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Email</label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?= $user['email'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Phone</label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?= $user['tel'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_unit">
					<?php foreach ($unitsList as $unit):?>
					    <?php $unitname = $this->clean( $unit['name'] );
					          $unitId = $this->clean( $unit['id'] );
					          $active = "";
					          if ( $user['id_unit'] == $unitId  ){
					          	$active = "selected=\"selected\"";	
					          }
					    ?>
						<OPTION value="<?= $unitId ?>" <?= $active ?> > <?= $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Team</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_team">
					<?php foreach ($teamsList as $team):?>
					    <?php $teamname = $this->clean( $team['name'] ); 
					    	  $teamid = $this->clean( $team['id'] );
					    	  $active = "";
					    	  if ( $user['id_team'] == $teamid  ){
					    	  	$active = "selected=\"selected\"";
					    	  }
					    ?>
						<OPTION value="<?= $teamid ?>" <?= $active ?> > <?= $teamname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Responsible</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_responsible">   
					<?php foreach ($respsList as $resp):?>
					    <?php   $respId = $this->clean( $resp['id'] );
					    		if ($resp['id'] > 1){
							    	$respSummary = $respId . " " . $this->clean( $resp['firstname'] ) . " " . $this->clean( $resp['name'] );
					    		}
					    		else{
					    			$respSummary = "--";
					    		}
					    		$active = "";
					    		if ( $user['id_responsible'] == $respId  ){
					    			$active = "selected=\"selected\"";
					    		}
						?>
						<OPTION value="<?= $respId ?>" <?= $active ?>> <?= $respSummary ?> </OPTION>
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
			      <?php if ( $user['is_responsible'] ){  
			      	$checked = "disabled=\"disabled\" checked"; 
			      ?>
			      	<input type="hidden" value="true" name="is_responsible" />
			      <?php
						} 
						else {
							$checked = "";
						} 
				  ?>
			      
			      <input type="checkbox" name="is_responsible" <?= $checked ?>> is responsible
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Status</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_status">
					<?php foreach ($statusList as $status):?>
					    <?php $statusname = $this->clean( $status['name'] );
					          $statusid = $this->clean( $status['id'] );
					          
					          $active = "";
					          if ( $user['id_status'] == $statusid  ){
					          	$active = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?= $statusid ?>" <?= $active ?>> <?= $statusname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<?php if ( Configuration::get("grr_installed") ) {?>
		<div>
        	<label><input type="checkbox" name="grr_use" value="add to GRR"> Add to GRR </label>
    	</div>
    	<div class="grr box">
    		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-2">GRR Status</label>
				<div class="col-xs-10">
					<select class="form-control" name="grr_status">
						<OPTION value="visiteur" <?php if ($grrstatus == "visiteur"){echo "selected=\"selected\"";} ?> > Visitor </OPTION>
						<OPTION value="utilisateur" <?php if ($grrstatus == "utilisateur"){echo "selected=\"selected\"";} ?> > User </OPTION>
						<OPTION value="gestionnaire_utilisateur" <?php if ($grrstatus == "gestionnaire_utilisateur"){echo "selected=\"selected\"";} ?> > User manager </OPTION>
						<OPTION value="administrateur" <?php if ($grrstatus == "administrateur"){echo "selected=\"selected\"";} ?> > Admin </OPTION>
					</select>
				</div>
			</div>
			<br>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-2">GRR State</label>
				<div class="col-xs-10">
					<select class="form-control" name="grr_etat">
						<OPTION value="actif" <?php if ($grretat == "actif"){echo "selected=\"selected\"";} ?> > Active </OPTION>
						<OPTION value="inactif" <?php if ($grretat == "inactif"){echo "selected=\"selected\"";} ?> > Not active </OPTION>
					</select>
				</div>
			</div>
		</div>
    	<?php }?>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='users'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
      
      <br>
      <div>
      	<div class="page-header">
			<h1>
				Change password <br> <small></small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-4" id="button-div">
				<button type="button" onclick="location.href='users/changepwd/<?=$user['id']?>'" class="btn btn-default" id="navlink">Change password</button>
			</div>
		</div>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
