<?php $this->title = "Storage" ?>

<?php echo $navBar ?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">
    	
    	<div class="page-header">
			<h1>
				<?= StTranslator::Storage_configuration($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				<?= CoreTranslator::Install_Repair_database($lang) ?> <br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="storageconfig"
		method="post">
		
		<?php if (isset($installError)): ?>
        <div class="alert alert-danger" role="alert">
    	<p><?= $installError ?></p>
    	</div>
		<?php endif; ?>
		<?php if (isset($installSuccess)): ?>
        <div class="alert alert-success" role="alert">
    	<p><?= $installSuccess ?></p>
    	</div>
		<?php endif; ?>
		
		<p>
		<?= CoreTranslator::Install_Txt($lang) ?>
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Install($lang) ?>" />
		</div>
      </form>
  
      
      <!-- Storage Menu -->
      <div>
		  <div class="page-header">
			<h2>
				<?= CoreTranslator::Activate_desactivate_menus($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="storageconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		    
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4">Storage</label>
				<div class="col-xs-6">
					<select class="form-control" name="storagemenu">
						<OPTION value="0" <?php if($menuStatus["status"]==0){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::disable($lang) ?> </OPTION>
						<OPTION value="1" <?php if($menuStatus["status"]==1){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
						<OPTION value="2" <?php if($menuStatus["status"]==2){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_users($lang) ?> </OPTION>
						<OPTION value="3" <?php if($menuStatus["status"]==3){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_manager($lang) ?> </OPTION>
						<OPTION value="4" <?php if($menuStatus["status"]==4){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_admin($lang) ?> </OPTION>
					</select>
				</div>
			</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
      <!-- Default storage quota -->
      <div>
		  <div class="page-header">
			<h2>
				<?= StTranslator::Default_quota($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="storageconfig" method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setquotaquery" value="yes"
			 	/>
		    </div>
		    
		    <div class="col-xs-12">
		      <div class="col-xs-2 col-xs-offset-2">
			    <label class="control-label"><?= StTranslator::Quota($lang) . " (Go)" ?></label>
			  </div>
			  <div class="col-xs-6">
			    <?php 
			    if (!isset($quota)){
			    	$quota = 12;
			    }
			    ?>
			    <input class="form-control" type="text" name="quota" value="<?= $quota ?>" />
		      </div>	
		    </div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>