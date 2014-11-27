<?php $this->title = "SyGRRiF Database change password users"?>

<?php echo $navBar?>

<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/changepwdquery" method="post">
		<div class="page-header">
			<h1>
				Change passeword <br> <small> for user</small>
			</h1>
			<div class="form-group">
				<div class="col-xs-4">
					<input class="form-control" id="firstname" type="text" name="firstname" value=<?= $user['firstname'] ?> readonly />
				</div>
				<div class="col-xs-4">
					<input class="form-control" id="name" type="text" name="name" value=<?= $user['name'] ?> readonly />
				</div>
				<label for="pwd" class="control-label col-xs-2">ID:</label>
				<div class="col-xs-2">
					<input class="form-control" id="id" type="text" name="id" value=<?= $user['id'] ?> readonly />
				</div>
			</div>
		</div>
		<div class="row">
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2">Password</label>
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
				<button type="button" onclick="location.href='users'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
		</div>
      </form>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
