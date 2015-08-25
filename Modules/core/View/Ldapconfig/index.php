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
			<?= CoreTranslator::LdapConfig($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			<?= CoreTranslator::LdapConfig($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::UseLdap($lang)?></label>
			<div class="col-xs-8">
			<?php $active = $this->clean($ldapConfig["useLdap"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="useLdap">
  					<OPTION value="1" <?php if($active > 0){echo $selected;} ?>> <?= CoreTranslator::yes($lang)?> </OPTION>
  					<OPTION value="0" <?php if($active == 0){echo $selected;} ?>> <?= CoreTranslator::no($lang)?> </OPTION>
  					
  				</select>
		    </div>
		</div>
	
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::userDefaultStatus($lang)?></label>
			<div class="col-xs-8">
			<?php $active = $this->clean($ldapConfig["ldapDefaultStatus"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="ldapDefaultStatus">
  					<OPTION value="1" <?php if($active == 1){echo $selected;} ?>> <?= CoreTranslator::Translate_status($lang, "visitor")?> </OPTION>
  					<OPTION value="2" <?php if($active == 2){echo $selected;} ?>> <?= CoreTranslator::Translate_status($lang, "user") ?> </OPTION>
  				</select>
		    </div>
		</div>
	
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapSearch($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapSearchAtt" value="<?= $this->clean($ldapConfig["ldapSearchAtt"]) ?>" />
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapName($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapNameAtt" value="<?= $this->clean($ldapConfig["ldapNameAtt"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapFirstname($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapFirstnameAtt" value="<?= $this->clean($ldapConfig["ldapFirstnameAtt"]) ?>" />
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapMail($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapMailAtt" value="<?= $this->clean($ldapConfig["ldapMailAtt"]) ?>" />
			</div>
		</div>
		
		<div class="page-header">
			<h3>
			<?= CoreTranslator::LdapAccess($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapAdress($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapAdress" value="<?= $this->clean($ldapConnect["ldapAdress"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapPort($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapPort" value="<?= $this->clean($ldapConnect["ldapPort"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapId($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapId" value="<?= $this->clean($ldapConnect["ldapId"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapPwd($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="password" name="ldapPwd" value="<?= $this->clean($ldapConnect["ldapPwd"]) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::ldapBaseDN($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="ldapBaseDN" value="<?= $this->clean($ldapConnect["ldapBaseDN"]) ?>" />
			</div>
		</div>
		
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='coreconfig'" class="btn btn-default"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
