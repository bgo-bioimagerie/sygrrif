<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
include_once 'Modules/catalog/Model/CaTranslator.php';
?>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">
    	
    	<div class="page-header">
			<h1>
			<?php echo  CaTranslator::Catalog_configuration($lang) ?>
			 <br> <small></small>
			</h1>
		</div>
		
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
			<?php echo  CaTranslator::Install_Repair_database($lang) ?>
				<br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="catalogconfig"
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
		<?php echo  CaTranslator::Install_Txt($lang) ?>
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
			<?php echo  CaTranslator::Activate_desactivate_menus($lang) ?>
				<br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="catalogconfig"
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
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::MenuItem($menuName, $lang) ?></label>
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
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      <br/> 
      
      <!-- Options -->
      <div>
	<div class="page-header">
            <h2>
                <?php echo  CaTranslator::Plugins($lang) ?>
		<br> <small></small>
            </h2>
	</div>
              
        <form role="form" class="form-horizontal" action="catalogconfig" method="post"> 
            
        <div class="col-xs-12">
            <input class="form-control" type="hidden" name="setpluginsquery" value="yes"/>
	</div>
            
      	<div class="form-group col-xs-12">
            <label class="control-label col-xs-4"><?php echo  CaTranslator::Antibody_plugin($lang)?></label>
                <div class="col-xs-6">
                    <select class="form-control" name="antibody_plugin">
                        <OPTION value="0" <?php if($antibody_plugin==0){echo "selected=\"selected\"";} ?> > <?php echo  CaTranslator::Unabled($lang) ?> </OPTION>
                        <OPTION value="1" <?php if($antibody_plugin==1){echo "selected=\"selected\"";} ?> > <?php echo CaTranslator::Enabled($lang) ?> </OPTION>
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
    <p><?php echo  $msgError ?></p>
<?php endif; ?>