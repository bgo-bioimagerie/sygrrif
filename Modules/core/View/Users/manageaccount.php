<?php $this->title = "SyGRRiF Database account"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

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
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value=<?= $user['name'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Firstname($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = <?= $user['firstname'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2"><?= CoreTranslator::Login($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?= $user['login'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Email($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?= $user['email'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Phone($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?= $user['tel'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $unit ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Responsible($lang)?></label>
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
			      
			      <input type="checkbox" name="is_responsible" <?= $checked ?> disabled="disabled"><?= CoreTranslator::is_responsible($lang)?>
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Status($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?= $status ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Convention($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="convention" type="text" name="convention" value = "<?= $user['convention'] ?>"
				disabled="disabled" />
			</div>
		</div>
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Date_convention($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?= $user['date_convention'] ?>" name="date_convention" disabled="disabled">
		    </div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang)  ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang)?></button>
		</div>
	
		
      </form>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/accountchangepwdquery" method="post">
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Change_password($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		 
		<input class="form-control" id="id" type="hidden" name="id" value=<?= $user['id'] ?> >
		<input class="form-control" id="login" type="hidden" name="login" value=<?= $user['login'] ?> >
				
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2"><?= CoreTranslator::Curent_password($lang)  ?> </label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="previouspwd" name="previouspwd" placeholder="Password">
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2"><?= CoreTranslator::New_password($lang)?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			</div>
		<div class="form-group">
		</div>
			<label for="pwdc" class="control-label col-xs-2"><?= CoreTranslator::Confirm($lang) ?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwdc" name="pwdc" placeholder="Password">
			</div>
		</div>
		<br>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
	  </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
