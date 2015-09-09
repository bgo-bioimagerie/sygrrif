<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
include_once 'Modules/supplies/Model/SuTranslator.php';
?>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">
    	
    	<div class="page-header">
			<h1>
			<?= SuTranslator::Supplies_configuration($lang) ?>
			 <br> <small></small>
			</h1>
		</div>
		
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
			<?= SuTranslator::Install_Repair_database($lang) ?>
				<br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="suppliesconfig"
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
		<?= SuTranslator::Install_Txt($lang) ?>
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Install($lang) ?>" />
		</div>
      </form>   
      
      <!-- Supplies Menu -->
      <div>
		  <div class="page-header">
			<h2>
			<?= SuTranslator::Activate_desactivate_menus($lang) ?>
				<br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="suppliesconfig"
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
				<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::MenuItem($menuName, $lang) ?></label>
				<div class="col-xs-6">
					<select class="form-control" name="menus[]">
						<OPTION value="0" <?php if($menuStatus==0){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::disable($lang) ?> </OPTION>
						<OPTION value="1" <?php if($menuStatus==1){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
						<OPTION value="2" <?php if($menuStatus==2){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_users($lang) ?> </OPTION>
						<OPTION value="3" <?php if($menuStatus==3){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_manager($lang) ?> </OPTION>
						<OPTION value="4" <?php if($menuStatus==4){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::enable_for_admin($lang) ?> </OPTION>
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
      <!-- set bill template section -->
      <div>
		<div class="page-header">
		  <h2>
		  <?= SuTranslator::Bill_template($lang) ?>
			<br> <small></small>
		  </h2>
		</div>
		
		<?php 
		if (isset($templateMessage)){
			if ($templateMessage != ""){
				if ( strpos($templateMessage,'Error') !== false){
					?>
					<div class="alert alert-danger">
				<?php 
				} 
				else{
				?>	
				    <div class="alert alert-info">
				<?php 
				    
				}?>
					<p><?= $templateMessage ?></p>
					</div>
					<?php 
			}
		}
		?>
			
      <form action="suppliesconfig" method="post" enctype="multipart/form-data">
      <div class="col-xs-12">
			<input class="form-control" type="hidden" name="templatequery" value="yes"
				/>
	  </div>
      
      
      <div class="col-md-12">
      <div class="form-group">
          <div class="col-md-10">
          <p>
          <?= SuTranslator::Bill_template_txt($lang); ?>
          </p>
    	
    	  <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
      </div>
      <div class="col-xs-2 col-xs-offset-10" id="button-div">
    	<input class="btn btn-primary" type="submit" value="<?= SuTranslator::Upload($lang) ?>" name="submit">
      </div>
      </div>
	  </form>   
	  
	  
	  
	  <form role="form" class="form-horizontal" action="suppliesconfig" method="post">
      <div class="col-xs-12">
			<input class="form-control" type="hidden" name="usersquery" value="yes" />
	  </div>
      
    
      <div class="page-header">
		  <h2>
		  <?= SuTranslator::Users_database($lang); ?>
			<br> <small></small>
		  </h2>
		</div>
      <div class="form-group col-xs-12">
	  	<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Users_database($lang) ?></label>
			<div class="col-xs-6">
				<select class="form-control" name="menus[]">
					<OPTION value="0" <?php if($supliesusersdatabase=="local"){echo "selected=\"selected\"";} ?> > local </OPTION>
					<OPTION value="1" <?php if($supliesusersdatabase=="core"){echo "selected=\"selected\"";} ?> > core </OPTION>
				</select>
			</div>
		</div>
		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		</div>
	  </form> 
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>