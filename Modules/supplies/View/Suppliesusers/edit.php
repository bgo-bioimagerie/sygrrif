<?php $this->title = "Suplies edit user"?>

<?php echo $navBar?>

<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="externals/datepicker/js/moments.js"></script>
	<script src="externals/dist/js/bootstrap.min.js"></script>

<style type="text/css">
    .box{
        display: none;
    }
</style>
<script type="text/javascript" src="externals/jquery-1.11.1.js"></script>
</head>


<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="suppliesusers/editquery" method="post">
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Edit_User($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		<?php if ($this->clean($user["id"]) != ""){?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $this->clean($user['id']) ?>" readonly
				/>
			</div>
		</div>
		<?php }?>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?= $this->clean($user['name']) ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Firstname($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = "<?= $this->clean($user['firstname']) ?>" 
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Email($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?= $this->clean($user['email']) ?>" 
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Phone($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?= $this->clean($user['tel']) ?>" 
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="id_unit">
					<?php foreach ($unitsList as $unit):?>
					    <?php $unitname = $this->clean( $unit['name'] );
					          $unitId = $this->clean( $unit['id'] );
					          $active = "";
					          if ( $user['id_unit'] == $unitId  ){
					          	$active = "selected=\"selected\"";	
					          }
					    ?>
						<OPTION value="<?= $unitId ?>" <?= $active ?> > <?= $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Responsible($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="id_responsible">   
					<?php foreach ($respsList as $resp):?>
					    <?php   $respId = $this->clean( $resp['id'] );
					    		if ($resp['id'] > 1){
							    	$respSummary = $respId . " " . $this->clean( $resp['firstname'] ) . " " . $this->clean( $resp['name'] );
					    		}
					    		else{
					    			$respSummary = "--";
					    		}
					    		$active = "";
					    		if ( $user['id_responsible'] == $respId  ){
					    			$active = "selected=\"selected\"";
					    		}
						?>
						<OPTION value="<?= $respId ?>" <?= $active ?>> <?= $respSummary ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"></label>
			<div class="col-xs-10">
			  <div class="checkbox">
			    <label>
			      <?php if ( $this->clean($user['is_responsible']) ){  
			      	$checked = "disabled=\"disabled\" checked"; 
			      ?>
			      	<input type="hidden" value="true" name="is_responsible" />
			      <?php
						} 
						else {
							$checked = "";
						} 
				  ?>
			      
			      <input type="checkbox" name="is_responsible" <?= $checked ?>> <?= CoreTranslator::is_responsible($lang) ?>
			      
			    </label>
              </div>
			</div>
		</div>
		</br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Is_user_active($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="active">
			<?php $active = $this->clean($user["is_active"]); 
  			?>
  				<OPTION value="1" <?= $active ?>> <?= CoreTranslator::yes($lang); ?> </OPTION>
  				<OPTION value="0" <?= $active ?>> <?= CoreTranslator::no($lang); ?> </OPTION>
  			</select>
  			
		    </div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='suppliesusers'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
      
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
