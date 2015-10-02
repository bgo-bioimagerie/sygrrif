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
			    <input class="form-control" id="id" type="text" name="id" value=<?php echo  $user['id'] ?> readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value=<?php echo  $user['name'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Firstname($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = <?php echo  $user['firstname'] ?>
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2"><?php echo  CoreTranslator::Login($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?php echo  $user['login'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Email($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?php echo  $user['email'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Phone($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?php echo  $user['tel'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?php echo  $unit ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Responsible($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?php echo  $resp ?>" readonly
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
			      
			      <input type="checkbox" name="is_responsible" <?php echo  $checked ?> disabled="disabled"><?php echo  CoreTranslator::is_responsible($lang)?>
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Status($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="" type="text" name=""
				       value = "<?php echo  $status ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Convention($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="convention" type="text" name="convention" value = "<?php echo  $user['convention'] ?>"
				disabled="disabled" />
			</div>
		</div>
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_convention($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?php echo  $user['date_convention'] ?>" name="date_convention" disabled="disabled">
		    </div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang)  ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?php echo  CoreTranslator::Cancel($lang)?></button>
		</div>
	
		
      </form>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/accountchangepwdquery" method="post">
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Change_password($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		 
		<input class="form-control" id="id" type="hidden" name="id" value=<?php echo  $user['id'] ?> >
		<input class="form-control" id="login" type="hidden" name="login" value=<?php echo  $user['login'] ?> >
				
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2"><?php echo  CoreTranslator::Curent_password($lang)  ?> </label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="previouspwd" name="previouspwd" placeholder="Password">
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2"><?php echo  CoreTranslator::New_password($lang)?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			</div>
		<div class="form-group">
		</div>
			<label for="pwdc" class="control-label col-xs-2"><?php echo  CoreTranslator::Confirm($lang) ?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwdc" name="pwdc" placeholder="Password">
			</div>
		</div>
		<br>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
	  </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
