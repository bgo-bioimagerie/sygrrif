<?php $this->title = "SyGRRiF Edit Calendar resource"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="calendar/editcalendarresourcequery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($id) == ""){
				$buttonName = "Add";
				echo "Add Calendar Resource";
			}
			else{
				$buttonName = "Edit";
				echo "Edit Calendar Resource";
			}
				?>	
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			Description
				<br> <small></small>
			</h3>
		</div>
	
		
		<?php if ($this->clean($id) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?=$this->clean($id) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Name</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?=$this->clean($name) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Description</label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" type="textarea" name="description"
				><?=$this->clean($description) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Category</label>
			<div class="col-xs-8">
				<select class="form-control" name="category_id">
					<OPTION value="0"> ... </OPTION>
				    <?php $cid = $this->clean($category_id); 
				    foreach ($cateoriesList as $cat){
				    	$selected = "";
				    	if ($cid==$cat["id"]){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?= $cat["id"] ?>" <?= $selected?>> <?=$cat["name"]?> </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
				<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Area</label>
			<div class="col-xs-8">
				<select class="form-control" name="area_id">
					<OPTION value="0"> ... </OPTION>
				    <?php $aid = $this->clean($area_id); 
				    echo "aid = " . $aid;
				    foreach ($areasList as $area){
				    	$selected = "";
				    	if ($aid==$area["id"]){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?= $area["id"] ?>" <?= $selected?>> <?=$area["name"]?> </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Who can book</label>
			<div class="col-xs-8">
					<select class="form-control" name="accessibility_id">
						<?php $accessibility_id = $this->clean($accessibility_id) ?>
						<OPTION value="1" <?php if ($accessibility_id==1){echo "selected=\"selected\"";}?>> User </OPTION>
						<OPTION value="2" <?php if ($accessibility_id==2){echo "selected=\"selected\"";}?>> Authorized User </OPTION>
						<OPTION value="3" <?php if ($accessibility_id==3){echo "selected=\"selected\"";}?>> Manager </OPTION>
						<OPTION value="4" <?php if ($accessibility_id==4){echo "selected=\"selected\"";}?>> Admin </OPTION>
				</select>
			</div>
		</div>
		

		<div class="page-header">
			<h3>
			Settings
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Max number of people</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="nb_people_max"
				       value="<?=$this->clean($nb_people_max) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">Available Days</label>
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
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">Day beginning</label>
				<div class="col-xs-8">
				<select class="form-control" name="day_begin">
				    <?php $sday = $this->clean($day_begin); 
				    for ($i = 0 ; $i < 25 ; $i++){
				    	$selected = "";
				    	if ($sday==$i){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?= $i ?>" <?= $selected?>> <?=$i?>h </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
			<div class="form-group">	
				<label for="inputEmail" class="control-label col-xs-4">Day end</label>
				<div class="col-xs-8">
				<select class="form-control" name="day_end">
			    <?php $eday = $this->clean($day_end); 
				    for ($i = 0 ; $i < 25 ; $i++){
				    	$selected = "";
				    	if ($eday==$i){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?= $i ?>" <?= $selected?>> <?=$i?>h </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Booking size bloc</label>
			<div class="col-xs-8">
				<select class="form-control" name="size_bloc_resa">
				<?php $size_bloc_resa = $this->clean($size_bloc_resa)?>
					<OPTION value="900" <?php  if ($size_bloc_resa == 900){echo "selected=\"selected\"";}?> > 15min </OPTION>
					<OPTION value="1800" <?php  if ($size_bloc_resa == 1800){echo "selected=\"selected\"";}?> > 30min </OPTION>
					<OPTION value="3600" <?php  if ($size_bloc_resa == 3600){echo "selected=\"selected\"";}?> > 1h </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">The user specify</label>
			<div class="col-xs-8">
				<select class="form-control" name="resa_time_setting">
				<?php $resa_time_setting = $this->clean($resa_time_setting)?>
					<OPTION value="0" <?php  if ($resa_time_setting == 0){echo "selected=\"selected\"";}?> > the booking duration </OPTION>
					<OPTION value="1" <?php  if ($resa_time_setting == 1){echo "selected=\"selected\"";}?> > the date/time when reservation ends </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="page-header">
			<h3>
			Prices
				<br> <small></small>
			</h3>
		</div>
				<div class="form-group">
		<table class="table table-striped text-center">
		<?php 
		foreach ($pricingTable as $pricing){
			
			$pid = $this->clean($pricing['id']);
			$pname = $this->clean($pricing['tarif_name']);
			$punique = $this->clean($pricing['tarif_unique']);
			$val_day = 0;
			if (isset($pricing['val_day'])){
				$val_day = $this->clean($pricing['val_day']);
			}
			$val_night = 0;
			if (isset($pricing['val_night'])){
				$val_night = $this->clean($pricing['val_night']);
			}
			$val_we = 0;
			if (isset($pricing['val_we'])){
				$val_we = $this->clean($pricing['val_we']);
			}
			
			if ($punique){
				?>
				<tr>
					<td><b><?= $pname ?></b></td>
					<td></td>
					<td> <input id="tarif" type="text" class="text-center"  name="<?= $pid. "_day" ?>" 
					                         value="<?= $val_day ?>"/> € (H.T.)</td>
					<td></td>
				</tr>
			<?php
			}
			else {
				?>
				<tr>
					<td><b><?= $pname ?></b></td>
					<td>Price day: <input id="tarif" type="text" class="text-center" name="<?= $pid. "_day" ?>" value="<?= $val_day ?>"/> € (H.T.)</td>
				<?php	
				
				$pnight = $this->clean($pricing['tarif_night']);
				$pwe = $this->clean($pricing['tarif_we']);

				if (($pnight == "1") AND ($pwe== "0")){
					?>
					<td>Price Night: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_night" ?>" value="<?= $val_night ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "0") AND ($pwe == "1")){
					?>
					<td>Price w.e: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_we" ?>" value="<?= $val_we ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "1") AND ($pwe == "1")){
					?>
					<td>Price Night: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_night" ?>" value="<?= $val_night ?>"/> € (H.T.)</td>
					<td>Price w.e: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_we" ?>" value="<?= $val_we ?>"/> € (H.T.)</td>
				    <?php
				}
				?>
				</tr>
				<?php
			}
		}
		
		?>
		</table>
		</div>

		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= $buttonName ?>" />
				<button type="button" onclick="location.href='sygrrif/resources'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
