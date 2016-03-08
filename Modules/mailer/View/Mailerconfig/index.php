<?php $this->title = "Mailer" ?>

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
				<?php echo  MailerTranslator::Mailer_configuration($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<!-- 
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				<?php echo  CoreTranslator::Install_Repair_database($lang) ?> <br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="coreconfig"
		method="post">
		
		<?php if (isset($installError)): ?>
        <div class="alert alert-danger" role="alert">
    	<p><?php echo  $installError ?></p>
    	</div>
		<?php endif; ?>
		<?php if (isset($installSuccess)): ?>
        <div class="alert alert-success" role="alert">
    	<p><?php echo  $installSuccess ?></p>
    	</div>
		<?php endif; ?>
		
		<p>
		<?php echo  CoreTranslator::Install_Txt($lang) ?>
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Install($lang) ?>" />
		</div>
      </form>
       -->
      
      <!-- Sygrrif Menu -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::Activate_desactivate_menus($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="mailerconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		    
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4">email</label>
				<div class="col-xs-6">
					<select class="form-control" name="emailmenu">
						<OPTION value="0" <?php if($menuStatus["status"]==0){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::disable($lang) ?> </OPTION>
						<OPTION value="1" <?php if($menuStatus["status"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
						<OPTION value="2" <?php if($menuStatus["status"]==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
						<OPTION value="3" <?php if($menuStatus["status"]==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
						<OPTION value="4" <?php if($menuStatus["status"]==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
					</select>
				</div>
			</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif; ?>