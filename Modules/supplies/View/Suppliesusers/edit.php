<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<head>

<style type="text/css">
    .box{
        display: none;
    }
</style>

</head>


<?php include "Modules/supplies/View/navbar.php"; ?>
<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="suppliesusers/editquery" method="post">
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Edit_User($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?php echo  $user['id'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?php echo  $user['name'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Firstname($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				       value = "<?php echo  $user['firstname'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2"><?php echo  CoreTranslator::Login($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
					   value = "<?php echo  $user['login'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Email($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				       value = "<?php echo  $user['email'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Phone($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				       value = "<?php echo  $user['tel'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Unit($lang) ?></label>
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
						<OPTION value="<?php echo  $unitId ?>" <?php echo  $active ?> > <?php echo  $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Responsible($lang) ?></label>
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
						<OPTION value="<?php echo  $respId ?>" <?php echo  $active ?>> <?php echo  $respSummary ?> </OPTION>
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
			      	<!--  <input type="hidden" value="true" name="is_responsible" /> -->
			      <?php
						} 
						else {
							$checked = "";
						} 
				  ?>
			      
			      <input type="checkbox" name="is_responsible" <?php echo  $checked ?>> <?php echo  CoreTranslator::is_responsible($lang)?>
			      
			    </label>
              </div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Status($lang)?></label>
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
						<OPTION value="<?php echo  $statusid ?>" <?php echo  $active ?>> <?php echo  CoreTranslator::Translate_status($lang, $statusname)  ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br>
		<!-- 
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Convention($lang)?></label>
			<div class="col-xs-10">
				
				/>
			</div>
		</div>
		-->
		<input class="form-control" id="convention" type="hidden" name="convention" value = "<?php echo  $user['convention'] ?>">
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_convention($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?php echo  CoreTranslator::dateFromEn($user['date_convention'], $lang) ?>" name="date_convention">
		    </div>
		</div>
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_end_contract($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?php echo  CoreTranslator::dateFromEn($user['date_end_contract'], $lang) ?>" name="date_end_contract">
		    </div>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Is_user_active($lang)?></label>
			<div class="col-xs-10">
			<?php $active = $this->clean($user["is_active"]); 
				$selected = "selected=\"selected\"";
  			?>
  				<select class="form-control" name="is_active">
  					<OPTION value="1" <?php if($active){echo $selected;} ?>> <?php echo  CoreTranslator::yes($lang)?> </OPTION>
  					<OPTION value="0" <?php if(!$active){echo $selected;} ?>> <?php echo  CoreTranslator::no($lang)?> </OPTION>
  					
  				</select>
		    </div>
		</div>
		<div class="form-group">
                        <label for="inputEmail" class="control-label col-xs-2">isLdap</label>
                        <div class="col-xs-10">
                                <input class="form-control" id="name" type="text" name="isLdap" value="<?php echo  $user['source'] ?>" readonly
                                />
                        </div>
                </div>

		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang)?>" />
				<button type="button" onclick="location.href='suppliesusers'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang)?></button>
		</div>
		
      </form>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
