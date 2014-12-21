<?php $this->title = "SyGRRiF Edit Calendar Reservation"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>

<?php
$readOnlyGlobal = ""; 
if (!$canEditReservation){
	$readOnlyGlobal = "readonly";
}

?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="calendar/editreservationquery"
		method="post">
	
		<div class="page-header">
			<h1>
				Edit Reservation <br> <small></small>
			</h1>
		</div>

	    <input class="form-control" id="id" type="hidden"  name="resource_id" value="<?=$this->clean($resourceBase['id']) ?>" <?=$readOnlyGlobal?>/>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Resource</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="resource_name" value="<?=$this->clean($resourceBase['name']) ?>" readonly/>
			</div>
		</div>
	
		<?php if (isset($reservationInfo)){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">Reservation number</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="reservation_id" value="<?=$this->clean($reservationInfo['id']) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
	
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">booking on behalf of</label>
			<div class="col-xs-8">
					<?php 
					$allowedBookForOther = true;
					if ( $this->clean($curentuser['id_status']) < 3){
						$readonly = false;
					}
					?>
			
					<select class="form-control" name="recipient_id" <?=$readOnlyGlobal?>>
						<?php
						if ($allowedBookForOther){
							$curentUserId = $this->clean($curentuser['id']); 
							foreach ($users as $user){
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $curentUserId){
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
						?>
				</select>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Short description</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="short_description"
				       value="<?php if (isset($reservationInfo)){ echo $this->clean($reservationInfo['short_description']);} ?>" 
				       <?=$readOnlyGlobal?> 
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Full description</label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" type="text" name="full_description" <?=$readOnlyGlobal?>
				><?php if (isset($reservationInfo)){ echo $this->clean($reservationInfo['full_description']);} ?></textarea>
			</div>
		</div>
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
			<label for="inputEmail" class="control-label col-xs-4">Beginning of the reservation:</label>
			<div class="col-xs-8">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="begin_date"
					       value="<?= $sdate ?>" <?=$readOnlyGlobal?>/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		        <script src="bootstrap/datepicker/js/moments.js"></script>
				<script src="bootstrap/jquery-1.11.1.js"></script>
				<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
	      		<script type="text/javascript">
				$(function () {
					$('#datetimepicker5').datetimepicker({
						pickTime: false
					});
				});
			    </script>
		    </div>
		    <br></br>
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				<div class="col-xs-3">
				<b>time:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_hour"
				       value="<?= $sh ?>" <?=$readOnlyGlobal?> 
				/>
				</div>
				<div class="col-xs-1">
				<b>:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_min"
				       value="<?= $sm ?>"  <?=$readOnlyGlobal?>
				/>
				</div>
			</div>
		</div>
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
			<label for="inputEmail" class="control-label col-xs-4">End of the reservation:</label>
			<div class="col-xs-8">
				<div class='input-group date' id='datetimepicker6'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="end_date"
					       value="<?= $edate ?>" <?=$readOnlyGlobal?>/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		        <script src="bootstrap/datepicker/js/moments.js"></script>
				<script src="bootstrap/jquery-1.11.1.js"></script>
				<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
	      		<script type="text/javascript">
				$(function () {
					$('#datetimepicker6').datetimepicker({
						pickTime: false
					});
				});
			    </script>
		    </div>
			</div>
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				<div class="col-xs-3">
				<b>time:</b>
				</div>
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
		
		<?php 
		if ($this->clean($resourceBase["type_id"])==2){ // is unitary
		?>
		<input class="form-control" id="id" type="hidden"  name="is_unitary" value="1" />
		<br></br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= $this->clean($resourceInfo["quantity_name"]) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="number"  name="quantity" value="<?=$this->clean($reservationInfo["quantity"])?>"
				<?=$readOnlyGlobal?>/>
			</div>
		</div>
		<?php 	
		}
		?>
		<br></br>
		<!-- color code -->
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Color code</label>
			<div class="col-xs-8">
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
		</br>
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
		        <button type="button" onclick="location.href='calendar/removeentry/<?=$this->clean($reservationInfo['id']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
		        <?php }} ?>
				<button type="button" class="btn btn-default" onclick="location.href='calendar/book'">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
