<?php $this->title = "SyGRRiF Réservation"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>

<?php 
require_once 'Modules/projet/Model/ResTranslator.php';
?>
<?php
$readOnlyGlobal = ""; 
if (!$canEditReservation){
	$readOnlyGlobal = "readonly";
}
?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="Reservation/ajouterreservationquery" method="post" enctype='multipart/form-data'>
	
		<div class="page-header">
			<h1>
				<?php echo ResTranslator::Ajouter_Reservation($lang); ?>
				<br> <small></small>
			</h1>
		</div>
		<input class="form-control" id="id" type="hidden"  name="resource_id" value="<?=$this->clean($resourceBase['id']) ?>" <?=$readOnlyGlobal?>/>
		
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::Resource($lang)?></label>
			<div class="col-lg-10">
				<input class="form-control" id="id" type="text"  name="resource_name" value="<?=$this->clean($resourceBase['name']) ?>" readonly/>
			</div>
		</div>
	<?php if (isset($reservationInfo)){
			?>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::Reservation_number($lang)?></label>
				<div class="col-lg-10">
				<input class="form-control" id="id" type="text"  name="reservation_id" value="<?=$this->clean($reservationInfo['id']) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
	
	    <div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::booking_on_behalf_of($lang)?></label>
			<div class="col-lg-10">
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
									<OPTION value="<?= $userId ?>"> <?= $userName?> </OPTION>
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
								<OPTION value="<?= $userId ?>" <?= $selected ?>> <?= $userName?> </OPTION>
								<?php 
							}
						}
						else{
							?>
							<OPTION value="<?= $this->clean($curentuser['id']) ?>"> <?=$this->clean($curentuser['name']) . " " . $this->clean($curentuser['firstname'])?> </OPTION>
							<?php
						}
					}
						?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=ResTranslator::protocol($lang)?></label>
			<div class="col-lg-10" >
					<?php $vard = $donnee;
						
					?>
					
						<select class="form-control" id="acronyme" name="acronyme"> 
						<option>----</option>
						<?php foreach($vard as $d){?>
							<option value="<?php echo $d["acronyme"];?>"> <?php echo $d["acronyme"];?></option>
							<?php } ?>  
					    <option>Autres </option>
							
						</select>
					</div>
					
		</div>
		
		
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=ResTranslator::codeanonymation($lang)?></label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="codeanonym" name="codeanonym" <?php if(isset($reservationInfo)){?> value="<?php echo $reserv['codeanonym'];?>"<?php }?>/>
			</div>
		</div>
		
		<!-- numéro de reservation si l'utilisateur coche jour/semaine/mois il aura le input pour insérer le numéro associé  -->
		
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=ResTranslator::numerovisite($lang)?></label> <br/>
			<div class="col-lg-10">
			<?php $vard = $donnee; //il faut prendre le numéro de visite depuis la fiche projet dans select et puis avec un champ autre qui permet d'ajouter une nouvelle entrée?> 
					
						<select class="form-control" id="numerovisite" name="numerovisite"> 
						<option>----</option>
						<?php foreach($vard as $d){?>
							<option value="<?php echo $d["numerovisite"];?>"> <?php echo $d["numerovisite"];?></option>
							<?php } ?>  
					    <option>Autres </option>
							
						</select>
			 </div>
			
		</div>
			
		
		<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::Beginning_of_the_reservation($lang)?>:</label>
			<div class="col-lg-10">
				<div class='input-group date form_date_<?= $lang ?>'>
					<input type='text' class="form-control" name="begin_date"
					       value="<?= CoreTranslator::dateFromEn($date, $lang) ?>" <?=$readOnlyGlobal?>/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">    
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				
				<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::time($lang)?>:</label>
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
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_hour"
				       value="<?= $eh ?>" <?=$readOnlyGlobal?> 
				/>
				</div>
				<div class="col-xs-1">
				<b>:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_min"
				       value="<?= $em ?>"  <?=$readOnlyGlobal?>
				/>
				</div>
			</div>
		</div>
		
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
				<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::End_of_the_reservation($lang)?>:</label>
				<div class="col-lg-10">
					<div class='input-group date form_date_<?= $lang ?>'>
						<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="end_date"
						       value="<?= CoreTranslator::dateFromEn($edate, $lang) ?>" <?=$readOnlyGlobal?>/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-xs-8 col-xs-offset-4">
					<!-- time -->
					<label for="end_hour" class="col-lg-2 control-label"><?=SyTranslator::time($lang)?>:</label>
					
					<div class="col-xs-3">
					<input class="form-control" id="name" type="text" name="end_hour"
					       value="<?= $eh ?>"  <?=$readOnlyGlobal?>
					/>
					</div>
					<div class="col-xs-1">
					<b>:</b>
					</div>
					<div class="col-xs-3">
					<input class="form-control" id="name" type="text" name="end_min"
					       value="<?= $em ?>"  <?=$readOnlyGlobal?>
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
			?>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::Duration($lang)?></label>
				<div class="col-lg-10">
					<input class="form-control" id="name" type="text" name="duration"
					       value="<?= $duration/60 ?>" 
					/>
				</div>
			</div>
		<?php
		}
		?>
		
		<?php  
		if ($this->clean($resourceBase["type_id"])==2){ // is unitary
		?>
		<input class="form-control" id="id" type="hidden"  name="is_unitary" value="1" />
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?= $this->clean($resourceInfo["quantity_name"]) ?></label>
			<div class="col-lg-10">
				<?php 
				$quantity = 1;
				if (isset($reservationInfo)){
					$quantity = $this->clean($reservationInfo["quantity"]);
				}
				?>
				<input class="form-control" id="id" type="number"  name="quantity" value="<?=$quantity?>"
				<?=$readOnlyGlobal?>/>
			</div>
		</div>
		<?php 	
		}
		?>
		<!-- color code -->
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label"><?=SyTranslator::Color_code($lang)?></label>
			<div class="col-lg-10">
			<select class="form-control" name="color_code_id" <?=$readOnlyGlobal?>>
			<?php 
			$colorID = 1;
			if (isset($reservationInfo)){
				$colorID = $this->clean($reservationInfo["color_type_id"]);
			}
			foreach ($colorCodes as $colorCode){
				$codeID = $this->clean($colorCode["id"]);
				$codeName = $this->clean($colorCode["name"]);
				$selected = "";
				if ($codeID == $colorID ){
					$selected = "selected=\"selected\"";
				}
				?>
				<OPTION value="<?= $codeID ?>" <?= $selected ?>> <?= $codeName?> </OPTION>
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
				<input type="submit" class="btn btn-primary" value="<?=SyTranslator::Save($lang)?>" />
				<?php if (isset($reservationInfo)){?>
		        <button type="button" onclick="location.href='calendar/removeentry/<?=$this->clean($reservationInfo['id']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
		        <?php }} ?>
				<button type="button" class="btn btn-default" onclick="location.href='calendar/book'"><?=SyTranslator::Cancel($lang)?></button>
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
			<label for="inputEmail" class="col-lg-2 control-label">Series type</label>
			<div class="col-lg-10">
			<select class="form-control" name="series_type_id" <?=$readOnlyGlobal?>>
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
				<label for="inputEmail" class="col-lg-2 control-label">Days for week periodicity</label>
				<div class="col-lg-10">
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
			<label for="inputEmail" class="col-lg-2 control-label">Date end series</label>
				<div class="col-lg-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="series_end_date"
					       value="<?= $series_end_date ?>" />
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
		        <button type="button" onclick="location.href='calendar/removeseries/<?=$this->clean($seriesInfo['id']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
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
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
      
