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
				$buttonName = SyTranslator::Add($lang);
				echo SyTranslator::Add_Calendar_Resource($lang);
			}
			else{
				$buttonName = SyTranslator::Edit($lang);
				echo SyTranslator::Edit_Calendar_Resource($lang);
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
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Name($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?=$this->clean($name) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Description($lang) ?></label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" name="description"
				><?=$this->clean($description) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Category($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Area($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Who_can_book($lang) ?> </label>
			<div class="col-xs-8">
				<select class="form-control" name="accessibility_id">
					<?php $accessibility_id = $this->clean($accessibility_id) ?>
				 
					<OPTION value="1" <?php if ($accessibility_id==1){echo "selected=\"selected\"";}?>> <?= SyTranslator::User($lang) ?> </OPTION>
					<OPTION value="2" <?php if ($accessibility_id==2){echo "selected=\"selected\"";}?>> <?= SyTranslator::Authorized_users($lang) ?> </OPTION>
					<OPTION value="3" <?php if ($accessibility_id==3){echo "selected=\"selected\"";}?>> <?= SyTranslator::Manager($lang) ?> </OPTION>
					<OPTION value="4" <?php if ($accessibility_id==4){echo "selected=\"selected\"";}?>> <?= SyTranslator::Admin($lang) ?> </OPTION>
				 
				</select>
			</div>
		</div>
		

		<div class="page-header">
			<h3>
			<?= SyTranslator::Settings($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Max_number_of_people($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="nb_people_max"
				       value="<?=$this->clean($nb_people_max) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Available_Days($lang)?></label>
				<div class="col-xs-8">
					<div class="checkbox">
    				<label>
    				    <?php $monday = $days_array[0]; ?>
      					<input type="checkbox" name="monday" <?php if ($monday==1){echo "checked";}?>> <?= SyTranslator::Monday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $tuesday = $days_array[1]; ?>
      					<input type="checkbox" name="tuesday" <?php if ($tuesday==1){echo "checked";}?>> <?= SyTranslator::Tuesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    					<?php $wednesday = $days_array[2]; ?>
      					<input type="checkbox" name="wednesday" <?php if ($wednesday==1){echo "checked";}?>> <?= SyTranslator::Wednesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $thursday = $days_array[3]; ?>
      					<input type="checkbox" name="thursday" <?php if ($thursday==1){echo "checked";}?>> <?= SyTranslator::Thursday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $friday = $days_array[4]; ?>
      					<input type="checkbox" name="friday" <?php if ($friday==1){echo "checked";}?>> <?= SyTranslator::Friday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $saturday = $days_array[5]; ?>
      					<input type="checkbox" name="saturday" <?php if ($saturday==1){echo "checked";}?>> <?= SyTranslator::Saturday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $sunday = $days_array[6]; ?>
      					<input type="checkbox" name="sunday" <?php if ($sunday==1){echo "checked";}?>> <?= SyTranslator::Sunday($lang)?>
    				</label>
  					</div>
				</div>
			</div>
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Day_beginning($lang) ?></label>
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
				<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Day_end($lang)?></label>
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
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Booking_size_bloc($lang)?></label>
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
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::The_user_specify($lang)?></label>
			<div class="col-xs-8">
				<select class="form-control" name="resa_time_setting">
				<?php $resa_time_setting = $this->clean($resa_time_setting)?>
					<OPTION value="0" <?php  if ($resa_time_setting == 0){echo "selected=\"selected\"";}?> > <?= SyTranslator::the_booking_duration($lang)?> </OPTION>
					<OPTION value="1" <?php  if ($resa_time_setting == 1){echo "selected=\"selected\"";}?> > <?= SyTranslator::the_date_time_when_reservation_ends($lang)?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Default_color($lang)?></label>
			<div class="col-xs-8">
				<select class="form-control" name="default_color_id">
					<?php foreach( $colors as $color ){
						$idColor = $this->clean($color["id"]);
						$nameColor = $this->clean($color["name"]);
						$selected = "";
						if ($this->clean($default_color_id) == $idColor){
							$selected = "selected=\"selected\"";
						}
						?>
						<OPTION value="<?= $idColor ?>" <?= $selected ?> > <?= $nameColor ?> </OPTION>
					<?php 
					}
					?>
				</select>
			</div>
		</div>	
		
		<div class="page-header">
			<h3>
			<?= SyTranslator::Prices($lang)?>
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
					<td><?= SyTranslator::Price_day($lang) ?>: <input id="tarif" type="text" class="text-center" name="<?= $pid. "_day" ?>" value="<?= $val_day ?>"/> € (H.T.)</td>
				<?php	
				
				$pnight = $this->clean($pricing['tarif_night']);
				$pwe = $this->clean($pricing['tarif_we']);

				if (($pnight == "1") AND ($pwe== "0")){
					?>
					<td><? SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_night" ?>" value="<?= $val_night ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "0") AND ($pwe == "1")){
					?>
					<td><? SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_we" ?>" value="<?= $val_we ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "1") AND ($pwe == "1")){
					?>
					<td><? SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_night" ?>" value="<?= $val_night ?>"/> € (H.T.)</td>
					<td><? SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?= $pid . "_we" ?>" value="<?= $val_we ?>"/> € (H.T.)</td>
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

		<div class="row">
		<div class="col-xs-5 col-xs-offset-7" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= $buttonName ?>" />
		        <?php if ($this->clean($id) != ""){ ?>
		        	<button type="button" onclick="location.href='<?="calendar/deletecalendarresource/".$this->clean($id) ?>'" class="btn btn-danger"><?= SyTranslator::Delete($lang) ?></button>
				<?php } ?>
				<button type="button" onclick="location.href='sygrrif/resources'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
