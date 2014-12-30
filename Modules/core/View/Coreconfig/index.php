<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">
    	
    	<div class="page-header">
			<h1>
				Core configuration <br> <small></small>
			</h1>
		</div>
		
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				Install/Repair database <br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="coreconfig"
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
		To repair the Core mudule, click "Install". This will create the 
		Core tables in the database if they don't exists or repair them
		if they exists
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="Install" />
		</div>
      </form>
      
      
      <!-- Sygrrif Menu -->
      <div>
		  <div class="page-header">
			<h2>
				Activate/desactivate menus <br> <small></small>
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
				<label for="inputEmail" class="control-label col-xs-4"><?=$menuName?></label>
				<div class="col-xs-6">
					<select class="form-control" name="menus[]">
						<OPTION value="0" <?php if($menuStatus==0){echo "selected=\"selected\"";} ?> > disable </OPTION>
						<OPTION value="1" <?php if($menuStatus==1){echo "selected=\"selected\"";} ?> > enable for visitors </OPTION>
						<OPTION value="2" <?php if($menuStatus==2){echo "selected=\"selected\"";} ?> > enable for users </OPTION>
						<OPTION value="3" <?php if($menuStatus==3){echo "selected=\"selected\"";} ?> > enable for manager </OPTION>
						<OPTION value="4" <?php if($menuStatus==4){echo "selected=\"selected\"";} ?> > enable for admin </OPTION>
					</select>
				</div>
			</div>
			<?php }?>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
      <!-- desable user-->
      <div>
		  <div class="page-header">
			<h2>
				non-active users <br> <small></small>
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
				<label for="inputEmail" class="control-label col-xs-4">Disable user account when</label>
				<div class="col-xs-6">
					<select class="form-control" name="disableuser">
						<OPTION value="1" <?php if($activeUserSetting==1){echo "selected=\"selected\"";} ?> > never </OPTION>
						<OPTION value="2" <?php if($activeUserSetting==2){echo "selected=\"selected\"";} ?> > contract ends </OPTION>
						<OPTION value="3" <?php if($activeUserSetting==3){echo "selected=\"selected\"";} ?> > does not login for 1 year </OPTION>
						<OPTION value="4" <?php if($activeUserSetting==4){echo "selected=\"selected\"";} ?> > does not login for 2 year </OPTION>
						<OPTION value="5" <?php if($activeUserSetting==5){echo "selected=\"selected\"";} ?> > does not login for 3 year </OPTION>
					</select>
				</div>
			</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>