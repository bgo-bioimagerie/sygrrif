<?php $this->title = "SyGRRiF Database acoount"?>

<?php echo $navBar?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/manageaccountquery" method="post">
		<div class="page-header">
			<h1>
				Manage account <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value=<?= $user['id'] ?> readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value=<?= $user['name'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Firstname</label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = <?= $user['firstname'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2">Login</label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?= $user['login'] ?>" readonly
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
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $unit ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Team</label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $team ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Responsible</label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $resp ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"></label>
			<div class="col-xs-10">
			  <div class="checkbox">
			    <label>
			      <?php if ( $user['is_responsible'] ){  
			      	$checked = "checked"; 
			      ?>
			      	<input type="hidden" value="true" name="is_responsible" />
			      <?php
						} 
						else {
							$checked = "";
						} 
				  ?>
			      
			      <input type="checkbox" name="is_responsible" <?= $checked ?> disabled="disabled"> is responsible
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Status</label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $status ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
      
      <br>
      <div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/accountchangepwdquery" method="post">
		<div class="page-header">
			<h1>
				Change password <br> <small></small>
			</h1>
		</div>
		
		<input class="form-control" id="id" type="hidden" name="id" value=<?= $user['id'] ?>
				/>
		
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2">Curent password</label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="previouspwd" name="previouspwd" placeholder="Password">
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2">New password</label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			</div>
		<div class="form-group">
		</div>
			<label for="pwdc" class="control-label col-xs-2">Confirm</label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwdc" name="pwdc" placeholder="Password">
			</div>
		</div>
		<br>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
	  </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
