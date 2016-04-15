<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">


    <!-- Maintenance mode -->
      <div>
        <div class="page-header">
            <h2>
                <?php echo CoreTranslator::Maintenance_Mode($lang)?> <br> <small></small>
            </h2>
        </div>

	<form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
	<div class="col-xs-10">
	<input class="form-control" type="hidden" name="maintenancequery" value="yes"/>
	</div>
	<!-- is_maintenance -->
	 <?php 
            $visibleM = $this->clean($is_maintenance);			
	?>
	<div class="col-xs-12">
            <div class="form-group">
                <label class="control-label col-xs-3"><?php echo  CoreTranslator::InMaintenance($lang) ?></label>
	
                <div class="col-xs-7">
                    <select class="form-control" name="is_maintenance">
                        <OPTION value="1" <?php if ($visibleM == 1){echo "selected=\"selected\"";}?>> <?php echo CoreTranslator::yes($lang) ?> </OPTION>
                        <OPTION value="0" <?php if ($visibleM == 0){echo "selected=\"selected\"";}?>> <?php echo CoreTranslator::no($lang) ?> </OPTION>
                    </select>
                </div>
            </div>
			
            <div class="form-group">
                <label class="control-label col-xs-3"><?php echo  CoreTranslator::MaintenanceMessage($lang) ?></label>
			<div class="col-xs-7">
				<input class="form-control" id="email" type="text" name="maintenance_message" value="<?php echo  $this->clean($maintenance_message) ?>"
				/>
			</div>
            </div>
		
            <div class="col-xs-2 col-xs-offset-10" id="button-div">
                <input type="submit" class="btn btn-primary" value="save" />
            </div>
	</form>
      
      </div>

    	<div class="page-header">
			<h1>
				<?php echo  CoreTranslator::Core_configuration($lang) ?> <br> <small></small>
			</h1>
		</div>
		
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
      
      
      <!-- Menu -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::Activate_desactivate_menus($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		    
		    <?php foreach ($menus as $menu){
		    	$menuName = $menu["name"];
		    	$menuStatus = $menu["status"];
		    ?>
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo $menuName?></label>
				<div class="col-xs-6">
					<select class="form-control" name="menus[]">
						<OPTION value="0" <?php if($menuStatus==0){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::disable($lang) ?> </OPTION>
						<OPTION value="1" <?php if($menuStatus==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
						<OPTION value="2" <?php if($menuStatus==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
						<OPTION value="3" <?php if($menuStatus==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
						<OPTION value="4" <?php if($menuStatus==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
					</select>
				</div>
			</div>
			<?php }?>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
      <!-- LDAP -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::HomeConfig($lang) ?> <br> <small></small>
			</h2>
		  </div>
		  
		  <div class="col-xs-2 col-xs-offset-10">
		  <button type="button" onclick="location.href='homeconfig'" class="btn btn-primary"><?php echo  CoreTranslator::Config($lang) ?></button>
		  </div>
	   </div>
      
      <!-- LDAP -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::LdapConfig($lang) ?> <br> <small></small>
			</h2>
		  </div>
		  
		  <div class="col-xs-2 col-xs-offset-10">
		  <button type="button" onclick="location.href='ldapconfig'" class="btn btn-primary"><?php echo  CoreTranslator::Config($lang) ?></button>
		  </div>
	   </div>
      
      <!-- desable user-->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::non_active_users($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setactivuserquery" value="yes"
			 	/>
		    </div>
		    
		    <?php 
		    	$activeUserSetting = $this->clean($activeUserSetting);
		    ?>
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::Disable_user_account_when($lang) ?></label>
				<div class="col-xs-6">
					<select class="form-control" name="disableuser">
						<OPTION value="1" <?php if($activeUserSetting==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::never($lang) ?> </OPTION>
						<OPTION value="2" <?php if($activeUserSetting==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::contract_ends($lang) ?> </OPTION>
						<OPTION value="3" <?php if($activeUserSetting==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::does_not_login_for_n_year(1, $lang) ?> </OPTION>
						<OPTION value="4" <?php if($activeUserSetting==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::does_not_login_for_n_year(2, $lang) ?> </OPTION>
						<OPTION value="5" <?php if($activeUserSetting==5){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::does_not_login_for_n_year(3, $lang) ?> </OPTION>
					</select>
				</div>
			</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
      <!-- admin email -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::email($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setadminemailquery" value="yes"
			 	/>
		    </div>
		    
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::email($lang) ?></label>
			<div class="col-xs-6">
				<input class="form-control" id="email" type="text" name="email" value="<?php echo  $this->clean($admin_email) ?>"
				/>
			</div>
		</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
      
      <!-- Booking options -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo CoreTranslator::User_list_options($lang)?> <br> <small></small>
			</h2>
		  </div>

		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setuserlistoptionsquery" value="yes"
			 	/>
		    </div>
		    
		    <!-- date_convention -->
		    <?php 
			$visible = $this->clean($userListSettings['visible_date_convention']);			
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Convention:</label></div>
		    <div class="col-xs-7"><select class="form-control" name="visible_date_convention">
				<OPTION value="1" <?php if ($visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($visible == 0){echo "selected=\"selected\"";}?>> Hidden </OPTION>
			</select>
			</div>
			</div>
			
			<!-- date_created -->
		    <?php 
			$visible = $this->clean($userListSettings['visible_date_created']);			
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Date created:</label></div>
		    <div class="col-xs-7"><select class="form-control" name="visible_date_created">
				<OPTION value="1" <?php if ($visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($visible == 0){echo "selected=\"selected\"";}?>> Hidden </OPTION>
			</select>
			</div>
			</div>
			
			<!-- date_last_login -->
		    <?php 
			$visible = $this->clean($userListSettings['visible_date_last_login']);			
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Date last login:</label></div>
		    <div class="col-xs-7"><select class="form-control" name="visible_date_last_login">
				<OPTION value="1" <?php if ($visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($visible == 0){echo "selected=\"selected\"";}?>> Hidden </OPTION>
			</select>
			</div>
			</div>
			
			<!-- date_end_contract -->
		    <?php 
			$visible = $this->clean($userListSettings['visible_date_end_contract']);			
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Date end contract:</label></div>
		    <div class="col-xs-7"><select class="form-control" name="visible_date_end_contract">
				<OPTION value="1" <?php if ($visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($visible == 0){echo "selected=\"selected\"";}?>> Hidden </OPTION>
			</select>
			</div>
			</div>
			
			<!-- source -->
		    <?php 
			$visible = $this->clean($userListSettings['visible_source']);			
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Source:</label></div>
		    <div class="col-xs-7"><select class="form-control" name="visible_source">
				<OPTION value="1" <?php if ($visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($visible == 0){echo "selected=\"selected\"";}?>> Hidden </OPTION>
			</select>
			</div>
			</div>
			
			
 			
 			  <div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      
       <!-- menu color -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::menu_color($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="menucolorquery" value="yes"
			 	/>
		    </div>
		    
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::color($lang) ?> #</label>
			<div class="col-xs-6">
				<input class="form-control" id="coremenucolor" type="color" name="coremenucolor" value="<?php echo  $this->clean($coremenucolor) ?>"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::text_color($lang) ?> #</label>
			<div class="col-xs-6">
				<input class="form-control" id="coremenucolor" type="color" name="coremenucolortxt" value="<?php echo  $this->clean($coremenucolortxt) ?>"
				/>
			</div>
		</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
      <!-- Backup -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::Backup($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="coreconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setactivebackupquery" value="yes"
			 	/>
		    </div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Run_backup($lang) ?>" />
		    </div>
		  </form>
      </div>
      
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif; 