<?php $this->title = "SyGRRiF Edit Calendar Reservation"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>

<?php
$readOnlyGlobal = ""; 
if (!$canEditReservation){
	$readOnlyGlobal = "readonly";
}
?>

<header>
<style>

<?php 
if (!isset($reservationInfo) ){
?>
	#package_div {
	    display: none;
	} 
<?php 
}
else{
	if ( $reservationInfo["package_id"] == 0){
	?>
	#package_div {
	    display: none;
	} 
<?php 
}
else{
?>
	#resa_time_div {
	    display: none;
	}
<?php
}
}
?>
	
</style>
</header>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="calendar/editreservationquery"
		method="post">
	
		<div class="page-header">
			<h1>
				<?php echo SyTranslator::Edit_Reservation($lang); ?>
				<br> <small></small>
			</h1>
		</div>

	    <input class="form-control" id="id" type="hidden"  name="resource_id" value="<?php echo $this->clean($resourceBase['id']) ?>" <?php echo $readOnlyGlobal?>/>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Resource($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="resource_name" value="<?php echo $this->clean($resourceBase['name']) ?>" readonly/>
			</div>
		</div>
	
		<?php if (isset($reservationInfo)){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Reservation_number($lang)?></label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="reservation_id" value="<?php echo $this->clean($reservationInfo['id']) ?>" readonly/>
				</div>
			</div>
			<?php 		
		}
		?>
	
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::booking_on_behalf_of($lang)?></label>
			<div class="col-xs-8">
					<?php 
					$allowedBookForOther = true;
					if ( $this->clean($curentuser['id_status']) < 3){
						$allowedBookForOther = false;
					}
					
					$recipientID = 0;
					if(isset($reservationInfo)){
						$recipientID = $this->clean($reservationInfo["recipient_id"]);
					}
					if ($allowedBookForOther==false && isset($reservationInfo) && $recipientID != $this->clean($curentuser['id'])){
						?>
						<select class="form-control" name="recipient_id" disabled="disabled">
							<?php
							foreach ($users as $user){
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $recipientID){
									?>
									<OPTION value="<?php echo  $userId ?>"> <?php echo  $userName?> </OPTION>
									<?php
								} 
							}
							?>
						</select>
						
						<?php
					}
					else{
					?>
					
					<select class="form-control" name="recipient_id">
						<?php
						if ($allowedBookForOther){
							$recipientID = $this->clean($reservationInfo["recipient_id"]);
							if ($recipientID == "" && $recipientID == 0){
								$recipientID = $this->clean($curentuser['id']); 
							} 
							foreach ($users as $user){
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $recipientID){
									$selected = "selected=\"selected\"";
								}
								?>
								<OPTION value="<?php echo  $userId ?>" <?php echo  $selected ?>> <?php echo  $userName?> </OPTION>
								<?php 
							}
						}
						else{
							?>
							<OPTION value="<?php echo  $this->clean($curentuser['id']) ?>"> <?php echo $this->clean($curentuser['name']) . " " . $this->clean($curentuser['firstname'])?> </OPTION>
							<?php
						}
					}
						?>
				</select>
			</div>
		</div>
		
		
		<?php 
		$modelCoreConfig = new CoreConfig();
		$editBookingDescriptionSettings = $modelCoreConfig->getParam("SyDescriptionFields");
	
		$shortDescName = SyTranslator::Short_description($lang);
		$fullDescName = SyTranslator::Full_description($lang);
		if ($editBookingDescriptionSettings > 1){
			$shortDescName = SyTranslator::Description($lang);
			$fullDescName = SyTranslator::Description($lang);
		}
		
		?>
		
		<?php if ($projectsList == ""){?>
		
			<?php if ($editBookingDescriptionSettings == 1 || $editBookingDescriptionSettings == 2){?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  $shortDescName ?></label>
				<div class="col-xs-8">
					<input class="form-control" id="name" type="text" name="short_description"
					       value="<?php if (isset($reservationInfo)){ echo $this->clean($reservationInfo['short_description']);} ?>" 
					       <?php echo $readOnlyGlobal?> 
					/>
				</div>
			</div>
			<?php 
			}
		}
		else{
			?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Project</label>
			<div class="col-xs-8">
				<select class="form-control" name="short_description">
				<?php 
				$curentProject = $this->clean($reservationInfo['short_description']);
				foreach ($projectsList as $project){
					$projectID = $this->clean($project["id"]);
					$projectName = $this->clean($project["name"]);
					$selected = "";
					if ($curentProject == $projectID){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?php echo  $projectID ?>" <?php echo  $selected ?>> <?php echo  $projectName?> </OPTION>
					<?php
				}
				?>
				</select>
			</div>
		</div>
		<?php
		}
		?>
		
		<?php if ($editBookingDescriptionSettings == 1 || $editBookingDescriptionSettings == 3){?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  $fullDescName ?></label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" name="full_description" <?php echo $readOnlyGlobal?>
				><?php if (isset($reservationInfo)){ echo $this->clean($reservationInfo['full_description']);} ?></textarea>
			</div>
		</div>
		<?php }?>
		
		<!-- Supplementary cal info -->
		<?php 
		foreach ($calSups as $calSup){
			$star = "";
			$required = "";
			if ($calSup["mandatory"] == 1){
				$star = "*";
				$required = "required"; 
			}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo $calSup["name"] .$star ?></label>
			<div class="col-xs-8">
			        <input type='hidden' name="calsupName[]" value="<?php echo  $calSup["name"] ?>"/>
			        <?php 
			        $calSupDataHere = "";
				    if (isset($calSupsData[$calSup["name"]])){
				    	$calSupDataHere = $this->clean($calSupsData[$calSup["name"]]);
				    }
					if ($calSupDataHere == "" && $calSup["name"] == "tel"){
						$calSupDataHere = $curentuser["tel"];
					}
			        ?>
					<input type='text' class="form-control" name="calsupValue[]"
					       value="<?php  ?>" <?php echo $readOnlyGlobal?> <?php echo $required?>/>
		    </div>	
		</div>
		<?php	
		}
		?>
		
		
		
		
		<!-- RESERVATION TIME -->
		<div class="form-group">
				<?php 
				if (isset($reservationInfo)){
					$stime = $this->clean($reservationInfo['start_time']);
					$sdate = date("Y-m-d", $stime);
					$sh = date("H", $stime);
					$sm = date("i", $stime);
				}
				else{
					$sdate = $date;
					$sh = $timeBegin['h'];
					$sm = $timeBegin['m'];
				}
				?>
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Beginning_of_the_reservation($lang)?>:</label>
			<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" name="begin_date"
					       value="<?php echo  CoreTranslator::dateFromEn($sdate, $lang) ?>" <?php echo $readOnlyGlobal?>/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">    
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::time($lang)?>:</label>
				
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_hour"
				       value="<?php echo  $sh ?>" <?php echo $readOnlyGlobal?> 
				/>
				</div>
				<div class="col-xs-1">
				<b>:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_min"
				       value="<?php echo  $sm ?>"  <?php echo $readOnlyGlobal?>
				/>
				</div>
			</div>
		</div>
		
		
		<?php 
		if (count($packages) > 0){
		?>	
		<div class="checkbox col-xs-8 col-xs-offset-4">
    		<label>
    		<?php 
    		$checked = "";
    		if (isset($reservationInfo)){
	    		if ($reservationInfo["package_id"] > 0){
	    			$checked = "checked";	
	    		}
    		}
    		?>
			<input id="use_package" type="checkbox" name="use_package" value="yes"/ <?php echo $checked?>> <?php echo  SyTranslator::Use_Package($lang) ?>
			</label>
  		</div>
  		
  		<div id="package_div">
  			<div class="form-group">
				<label class="control-label col-xs-4"><?php echo SyTranslator::Select_Package($lang)?></label>
				<div class="col-xs-8">
					<select class="form-control" name="package_choice">
						<?php 
						foreach($packages as $package){
							$selected = "";
							if (isset($reservationInfo)){
								if($reservationInfo["package_id"]==$package["id"]){
									$selected = "selected=\"selected\"";
								}
							}
							?>
							<OPTION value="<?php echo $package["id"]?>" <?php echo  $selected ?> > <?php echo  $package["name"] ?> </OPTION>
							<?php
						}
						?>
					</select>
				</div>
			</div>
  		
  		</div>
		<?php
		}
		?>
		
		<div id="resa_time_div">
		<?php 
		
		if( $this->clean($resourceInfo["resa_time_setting"]) == 1){
			?>
			<div class="form-group">
					<?php 
					if (isset($reservationInfo)){
						$etime = $this->clean($reservationInfo['end_time']);
						$edate = date("Y-m-d", $etime);
						$eh = date("H", $etime);
						$em = date("i", $etime);
					}
					else{
						$edate = $date;
						$eh = $timeEnd['h'];
						$em = $timeEnd['m'];
					}
					?>
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::End_of_the_reservation($lang)?>:</label>
				<div class="col-xs-8">
					<div class='input-group date form_date_<?php echo  $lang ?>'>
						<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="end_date"
						       value="<?php echo  CoreTranslator::dateFromEn($edate, $lang) ?>" <?php echo $readOnlyGlobal?>/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-xs-8 col-xs-offset-4">
					<!-- time -->
					<label for="end_hour" class="control-label col-xs-4"><?php echo SyTranslator::time($lang)?>:</label>
					
					<div class="col-xs-3">
					<input class="form-control" id="name" type="text" name="end_hour"
					       value="<?php echo  $eh ?>"  <?php echo $readOnlyGlobal?>
					/>
					</div>
					<div class="col-xs-1">
					<b>:</b>
					</div>
					<div class="col-xs-3">
					<input class="form-control" id="name" type="text" name="end_min"
					       value="<?php echo  $em ?>"  <?php echo $readOnlyGlobal?>
					/>
					</div>
				</div>
			</div>
		<?php 
		}
		else{
			$duration = 30*60;
			if (isset($reservationInfo)){
				$duration = $this->clean($reservationInfo['end_time']) - $this->clean($reservationInfo['start_time']);
			}
			
			$viewDuration = 1;
			$durationPrint = $duration/60;
			if ( $duration/60 > 120 ){
				$viewDuration = 2;
				$durationPrint = $duration/3600;
			}
			if ( $duration/(3600) > 48 ){
				$viewDuration = 3;
				$durationPrint = $duration/(3600*24);
			}
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Duration($lang)?></label>
				<div class="col-xs-4">
					<input class="form-control" id="name" type="text" name="duration"
					       value="<?php echo  $durationPrint ?>" 
					/>
				</div>
				<div class="col-xs-4">
					<select class="form-control" name="duration_step">
						<OPTION value="1" <?php if($viewDuration==1){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Minutes($lang) ?> </OPTION>
						<OPTION value="2" <?php if($viewDuration==2){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Hours($lang) ?> </OPTION>
						<OPTION value="3" <?php if($viewDuration==3){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Days($lang) ?> </OPTION>
					</select>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		<?php  
		if ($this->clean($resourceBase["type_id"])==2){ // is unitary
		?>
		<input class="form-control" id="id" type="hidden"  name="is_unitary" value="1" />
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  $this->clean($resourceInfo["quantity_name"]) ?></label>
			<div class="col-xs-8">
				<?php 
				$quantity = 1;
				if (isset($reservationInfo)){
					$quantity = $this->clean($reservationInfo["quantity"]);
				}
				?>
				<input class="form-control" id="id" type="number"  name="quantity" value="<?php echo $quantity?>"
				<?php echo $readOnlyGlobal?>/>
			</div>
		</div>
		<?php 	
		}
		if ($this->clean($resourceBase["type_id"])==3){ // is time and unitary
		?>
			<input class="form-control" id="id" type="hidden"  name="is_timeandunitary" value="1" />
			<br></br>
			<?php 
			$quantitiesNames = explode(",", $this->clean($resourceInfo["quantity_name"]));
			$quantities = array();
			for($t = 0 ; $t < count($quantitiesNames) ; $t++){
				$quantities[$t] = 0;
			}
			if (isset($reservationInfo)){
				$quantity = $this->clean($reservationInfo["quantity"]);
				$quantities = explode(",", $quantity);
			}
			
			for($i = 0 ; $i < count($quantitiesNames) ; $i++){	
				if ($quantitiesNames[$i] != "" && $quantitiesNames[$i] != " "){			
				?>
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-4"><?php echo  $this->clean($quantitiesNames[$i]) ?></label>
					<div class="col-xs-8">
						<?php 
						$quantity = 0;
						?>
						<input class="form-control" id="id" type="number"  name="quantity[]" value="<?php echo $quantities[$i]?>"
						<?php echo $readOnlyGlobal?>/>
					</div>
				</div>
				<?php
				}
			}
			?>
		<?php 	
		}
		?>
				
		
		
		<!-- color code -->
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Color_code($lang)?></label>
			<div class="col-xs-8">
			<select class="form-control" name="color_code_id" <?php echo $readOnlyGlobal?>>
			<?php 
			$colorID = $resourceInfo["default_color_id"];
			
			
			if (isset($reservationInfo)){
				$colorID = $this->clean($reservationInfo["color_type_id"]);
			}
			else{
				
			}		
			
			foreach ($colorCodes as $colorCode){
				$codeID = $this->clean($colorCode["id"]);
				$codeName = $this->clean($colorCode["name"]);
				$selected = "";
				if ($codeID == $colorID ){
					$selected = "selected=\"selected\"";
				}
				?>
				<OPTION value="<?php echo  $codeID ?>" <?php echo  $selected ?>> <?php echo  $codeName?> </OPTION>
				<?php 
			}
			?>
			</select>
			</div>
		</div>		
		
		<?php if ($canEditReservation){
			?>
			<div class="col-xs-4 col-xs-offset-8">
		<?php
		}else{
		?>
		<div class="col-xs-1 col-xs-offset-11">
		        <?php } if ($canEditReservation){
				?>	
				<input type="submit" class="btn btn-primary" value="<?php echo SyTranslator::Save($lang)?>" />
				<?php if (isset($reservationInfo)){?>
		        <button type="button" onclick="location.href='calendar/removeentry/<?php echo $this->clean($reservationInfo['id']) ?>'" class="btn btn-danger">Delete</button>
		        <?php }} ?>
				<button type="button" class="btn btn-default" onclick="location.href='calendar/book'"><?php echo SyTranslator::Cancel($lang)?></button>
		</div>
      
      
      <?php 
      if ($showSeries == true){
	      if (isset($reservationInfo['repeat_id']) && $reservationInfo['repeat_id'] == 0){
	      	$showSeries = false;
	      } 
      }
      if ($showSeries){
      ?>
      
		<div class="page-header">
			<h1>
				Edit series <br> <small>This will affect all the reservations of the series </small>
			</h1>
		</div>
			
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Series type</label>
			<div class="col-xs-8">
			<select class="form-control" name="series_type_id" <?php echo $readOnlyGlobal?>>
				<?php 
				$series_type_id = 0;
				if (isset($seriesInfo)){
					$series_type_id = $this->clean($seriesInfo['series_type_id']);
				}
				$selected = "selected=\"selected\"";
				?>
				<OPTION value="0" <?php if($series_type_id == 0){echo $selected;} ?>> None </OPTION>
				<OPTION value="1" <?php if($series_type_id == 1){echo $selected;} ?>> Every day </OPTION>
				<OPTION value="2" <?php if($series_type_id == 2){echo $selected;} ?>> Every week </OPTION>
				<OPTION value="3" <?php if($series_type_id == 3){echo $selected;} ?>> Every 2 weeks </OPTION>
				<OPTION value="4" <?php if($series_type_id == 4){echo $selected;} ?>> Every 3 weeks </OPTION>
				<OPTION value="5" <?php if($series_type_id == 5){echo $selected;} ?>> Every 4 weeks </OPTION>
				<OPTION value="6" <?php if($series_type_id == 6){echo $selected;} ?>> Every 5 weeks </OPTION>
				<OPTION value="7" <?php if($series_type_id == 7){echo $selected;} ?>> Every month same date </OPTION>
				<OPTION value="8" <?php if($series_type_id == 8){echo $selected;} ?>> Every month same week day </OPTION>
				<OPTION value="9" <?php if($series_type_id == 9){echo $selected;} ?>> Every year same date </OPTION>
			</select>
			</div>
		</div>	
		
		<div class="form-group">
		<?php
		$days_array = array(0,0,0,0,0,0,0);
		if (isset($seriesInfo)){
			$days_array = $this->clean($seriesInfo['days_option']);
		}
		?>
				<label for="inputEmail" class="control-label col-xs-4">Days for week periodicity</label>
				<div class="col-xs-8">
					<div class="checkbox">
    				<label>
    				    <?php $monday = $days_array[0]; ?>
      					<input type="checkbox" name="monday" <?php if ($monday==1){echo "checked";}?>> Monday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $tuesday = $days_array[1]; ?>
      					<input type="checkbox" name="tuesday" <?php if ($tuesday==1){echo "checked";}?>> Tuesday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    					<?php $wednesday = $days_array[2]; ?>
      					<input type="checkbox" name="wednesday" <?php if ($wednesday==1){echo "checked";}?>> Wednesday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $thursday = $days_array[3]; ?>
      					<input type="checkbox" name="thursday" <?php if ($thursday==1){echo "checked";}?>> Thursday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $friday = $days_array[4]; ?>
      					<input type="checkbox" name="friday" <?php if ($friday==1){echo "checked";}?>> Friday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $saturday = $days_array[5]; ?>
      					<input type="checkbox" name="saturday" <?php if ($saturday==1){echo "checked";}?>> Saturday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $sunday = $days_array[6]; ?>
      					<input type="checkbox" name="sunday" <?php if ($sunday==1){echo "checked";}?>> Sunday
    				</label>
  					</div>
				</div>
			</div>
		
		<!-- End series time -->
		<div class="form-group ">
		<?php 
		$series_end_date = "";
		if (isset($seriesInfo)){
			$series_end_date = $this->clean($seriesInfo['end_date']);
		}
		?>
			<label for="inputEmail" class="control-label col-xs-4">Date end series</label>
				<div class="col-xs-8">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="series_end_date"
					       value="<?php echo  $series_end_date ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<?php if ($canEditReservation){
		?>
			<div class="col-xs-4 col-xs-offset-8">
		<?php
		}else{
		?>
		<div class="col-xs-1 col-xs-offset-11">
		        <?php } if ($canEditReservation){
				?>	
				<input type="submit" class="btn btn-primary" value="Save" />
				<?php if (isset($reservationInfo)){?>
		        <button type="button" onclick="location.href='calendar/removeseries/<?php echo $this->clean($seriesInfo['id']) ?>'" class="btn btn-danger">Delete</button>
		        <?php }} ?>
				<button type="button" class="btn btn-default" onclick="location.href='calendar/book'">Cancel</button>
		</div>
      </form>
      <?php 
	  }
      ?>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php"?>

<script>
document.getElementById('use_package').onchange = function() {
document.getElementById('package_div').style.display = this.checked ? 'block' : 'none';
document.getElementById('resa_time_div').style.display = ! this.checked ? 'block' : 'none';

};
</script>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
