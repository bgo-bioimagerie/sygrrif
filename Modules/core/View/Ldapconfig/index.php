<?php $this->title = "ldap configuration"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form role="form" class="form-horizontal" action="ldapconfig/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::LdapConfig($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			<?php echo  CoreTranslator::LdapConfig($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::UseLdap($lang)?></label>
			<div class="col-xs-8">
			<?php $active = $this->clean($ldapConfig["useLdap"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="useLdap">
  					<OPTION value="1" <?php if($active > 0){echo $selected;} ?>> <?php echo  CoreTranslator::yes($lang)?> </OPTION>
  					<OPTION value="0" <?php if($active == 0){echo $selected;} ?>> <?php echo  CoreTranslator::no($lang)?> </OPTION>
  					
  				</select>
		    </div>
		</div>
	
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::userDefaultStatus($lang)?></label>
			<div class="col-xs-8">
			<?php $active = $this->clean($ldapConfig["ldapDefaultStatus"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="ldapDefaultStatus">
  					<OPTION value="1" <?php if($active == 1){echo $selected;} ?>> <?php echo  CoreTranslator::Translate_status($lang, "visitor")?> </OPTION>
  					<OPTION value="2" <?php if($active == 2){echo $selected;} ?>> <?php echo  CoreTranslator::Translate_status($lang, "user") ?> </OPTION>
  				</select>
		    </div>
		</div>
	
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapSearch($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapSearchAtt" value="<?php echo  $this->clean($ldapConfig["ldapSearchAtt"]) ?>" />
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapName($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapNameAtt" value="<?php echo  $this->clean($ldapConfig["ldapNameAtt"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapFirstname($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapFirstnameAtt" value="<?php echo  $this->clean($ldapConfig["ldapFirstnameAtt"]) ?>" />
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapMail($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapMailAtt" value="<?php echo  $this->clean($ldapConfig["ldapMailAtt"]) ?>" />
			</div>
		</div>
		
		<div class="page-header">
			<h3>
			<?php echo  CoreTranslator::LdapAccess($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapAdress($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapAdress" value="<?php echo  $this->clean($ldapConnect["ldapAdress"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapPort($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapPort" value="<?php echo  $this->clean($ldapConnect["ldapPort"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapId($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapId" value="<?php echo  $this->clean($ldapConnect["ldapId"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapPwd($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="password" name="ldapPwd" value="<?php echo  $this->clean($ldapConnect["ldapPwd"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::ldapBaseDN($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapBaseDN" value="<?php echo  $this->clean($ldapConnect["ldapBaseDN"]) ?>" />
			</div>
		</div>
		
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='coreconfig'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
