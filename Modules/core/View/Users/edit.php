<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>

<style type="text/css">
    .box{
        display: none;
    }
</style>

</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/editquery" method="post">
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Edit_User($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $user['id'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?= $user['name'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Firstname($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = "<?= $user['firstname'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2"><?= CoreTranslator::Login($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?= $user['login'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Email($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?= $user['email'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Phone($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?= $user['tel'] ?>"
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
							    	$respSummary = $this->clean( $resp['name'] ) . " " . $this->clean( $resp['firstname'] );
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
			      
			      <input type="checkbox" name="is_responsible" <?= $checked ?>> <?= CoreTranslator::is_responsible($lang)?>
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Status($lang)?></label>
			<div class="col-xs-10">
				<select class="form-control" name="id_status">
					<?php foreach ($statusList as $status):?>
					    <?php $statusname = $this->clean( $status['name'] );
					          $statusid = $this->clean( $status['id'] );
					          
					          $active = "";
					          if ( $user['id_status'] == $statusid  ){
					          	$active = "selected=\"selected\"";
					          }
					    ?>
						<OPTION value="<?= $statusid ?>" <?= $active ?>> <?= $statusname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Convention($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="convention" type="text" name="convention" value = "<?= $user['convention'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Date_convention($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?= CoreTranslator::dateFromEn($user['date_convention'], $lang) ?>" name="date_convention">
		    </div>
		</div>
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Date_end_contract($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?= CoreTranslator::dateFromEn($user['date_end_contract'], $lang) ?>" name="date_end_contract">
		    </div>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Is_user_active($lang)?></label>
			<div class="col-xs-10">
			<?php $active = $this->clean($user["is_active"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="is_active">
  					<OPTION value="1" <?php if($active){echo $selected;} ?>> <?= CoreTranslator::yes($lang)?> </OPTION>
  					<OPTION value="0" <?php if(!$active){echo $selected;} ?>> <?= CoreTranslator::no($lang)?> </OPTION>
  					
  				</select>
		    </div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang)?>" />
				<button type="button" onclick="location.href='users'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang)?></button>
		</div>
		
      </form>
      
      <br>
      <div>
      	<div class="page-header">
			<h1>
			<?= CoreTranslator::Change_password($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-4" id="button-div">
				<button type="button" onclick="location.href='users/changepwd/<?=$user['id']?>'" class="btn btn-default" id="navlink"><?= CoreTranslator::Change_password($lang) ?></button>
			</div>
		</div>
	  </div>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
