<?php $this->title = "SyGRRiF Edit Calendar resource"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>

<script>
        function addRow(tableID) {

        	var idx = 1;
        	if(tableID == "dataTable"){
        		idx = 1;
            } 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            //document.write(rowCount);
            var row = table.insertRow(rowCount);
            //document.write(row);
            var colCount = table.rows[idx].cells.length;
            //document.write(colCount);
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[idx].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "hidden":
                            newcell.childNodes[0].value = "";
                            break;        
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
 
        function deleteRow(tableID) {
            try {

            var idx = 2;
            if(tableID == "dataTable"){
            	idx = 2;
            }     
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= idx) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }
 
    </script>

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
				<input class="form-control" id="id" type="text"  name="id" value="<?php echo $this->clean($id) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?php echo $this->clean($name) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Description($lang) ?></label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" name="description"
				><?php echo $this->clean($description) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Category($lang) ?></label>
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
				    	<OPTION value="<?php echo  $cat["id"] ?>" <?php echo  $selected?>> <?php echo $cat["name"]?> </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Area($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="area_id">
					<OPTION value="0"> ... </OPTION>
				    <?php $aid = $this->clean($area_id); 
				    //echo "aid = " . $aid;
				    foreach ($areasList as $area){
				    	$selected = "";
				    	if ($aid==$area["id"]){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?php echo  $area["id"] ?>" <?php echo  $selected?>> <?php echo $area["name"]?> </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Who_can_book($lang) ?> </label>
			<div class="col-xs-8">
				<select class="form-control" name="accessibility_id">
					<?php $accessibility_id = $this->clean($accessibility_id) ?>
				 
					<OPTION value="1" <?php if ($accessibility_id==1){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::User($lang) ?> </OPTION>
					<OPTION value="2" <?php if ($accessibility_id==2){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Authorized_users($lang) ?> </OPTION>
					<OPTION value="3" <?php if ($accessibility_id==3){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Manager($lang) ?> </OPTION>
					<OPTION value="4" <?php if ($accessibility_id==4){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Admin($lang) ?> </OPTION>
				 
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-8">
			<input class="form-control" id="id" type="text"  name="display_order" value="<?php echo $this->clean($display_order) ?>"/>
			</div>
		</div>
			
		
		

		<div class="page-header">
			<h3>
			<?php echo  SyTranslator::Settings($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Max_number_of_people($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="nb_people_max"
				       value="<?php echo $this->clean($nb_people_max) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Available_Days($lang)?></label>
				<div class="col-xs-8">
					<div class="checkbox">
    				<label>
    				    <?php $monday = $days_array[0]; ?>
      					<input type="checkbox" name="monday" <?php if ($monday==1){echo "checked";}?>> <?php echo  SyTranslator::Monday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $tuesday = $days_array[1]; ?>
      					<input type="checkbox" name="tuesday" <?php if ($tuesday==1){echo "checked";}?>> <?php echo  SyTranslator::Tuesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    					<?php $wednesday = $days_array[2]; ?>
      					<input type="checkbox" name="wednesday" <?php if ($wednesday==1){echo "checked";}?>> <?php echo  SyTranslator::Wednesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $thursday = $days_array[3]; ?>
      					<input type="checkbox" name="thursday" <?php if ($thursday==1){echo "checked";}?>> <?php echo  SyTranslator::Thursday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $friday = $days_array[4]; ?>
      					<input type="checkbox" name="friday" <?php if ($friday==1){echo "checked";}?>> <?php echo  SyTranslator::Friday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $saturday = $days_array[5]; ?>
      					<input type="checkbox" name="saturday" <?php if ($saturday==1){echo "checked";}?>> <?php echo  SyTranslator::Saturday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $sunday = $days_array[6]; ?>
      					<input type="checkbox" name="sunday" <?php if ($sunday==1){echo "checked";}?>> <?php echo  SyTranslator::Sunday($lang)?>
    				</label>
  					</div>
				</div>
			</div>
		<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Day_beginning($lang) ?></label>
				<div class="col-xs-8">
				<select class="form-control" name="day_begin">
				    <?php $sday = $this->clean($day_begin); 
				    for ($i = 0 ; $i < 25 ; $i++){
				    	$selected = "";
				    	if ($sday==$i){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?php echo  $i ?>" <?php echo  $selected?>> <?php echo $i?>h </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
			<div class="form-group">	
				<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Day_end($lang)?></label>
				<div class="col-xs-8">
				<select class="form-control" name="day_end">
			    <?php $eday = $this->clean($day_end); 
				    for ($i = 0 ; $i < 25 ; $i++){
				    	$selected = "";
				    	if ($eday==$i){
				    		$selected = "selected=\"selected\"";
				    	}
				    	?>
				    	<OPTION value="<?php echo  $i ?>" <?php echo  $selected?>> <?php echo $i?>h </OPTION>
				    <?php 
				    }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Booking_size_bloc($lang)?></label>
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
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::The_user_specify($lang)?></label>
			<div class="col-xs-8">
				<select class="form-control" name="resa_time_setting">
				<?php $resa_time_setting = $this->clean($resa_time_setting)?>
					<OPTION value="0" <?php  if ($resa_time_setting == 0){echo "selected=\"selected\"";}?> > <?php echo  SyTranslator::the_booking_duration($lang)?> </OPTION>
					<OPTION value="1" <?php  if ($resa_time_setting == 1){echo "selected=\"selected\"";}?> > <?php echo  SyTranslator::the_date_time_when_reservation_ends($lang)?> </OPTION>
				</select>
			</div>
		</div>	
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Default_color($lang)?></label>
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
						<OPTION value="<?php echo  $idColor ?>" <?php echo  $selected ?> > <?php echo  $nameColor ?> </OPTION>
					<?php 
					}
					?>
				</select>
			</div>
		</div>	
		
		<div class="page-header">
			<h3>
			<?php echo  SyTranslator::Prices($lang)?>
				<br> <small></small>
			</h3>
		</div>
		<div class="form-group">
		<table class="table table-striped text-center">
		<?php 
		foreach ($pricingTable as $pricing){
			
			$pid = $this->clean($pricing['id']);
			$pname = $this->clean($pricing['name']);
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
					<td><b><?php echo  $pname ?></b></td>
					<td></td>
					<td> <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid. "_day" ?>" 
					                         value="<?php echo  $val_day ?>"/> € (H.T.)</td>
					<td></td>
				</tr>
			<?php
			}
			else {
				?>
				<tr>
					<td><b><?php echo  $pname ?></b></td>
					<td><?php echo  SyTranslator::Price_day($lang) ?>: <input id="tarif" type="text" class="text-center" name="<?php echo  $pid. "_day" ?>" value="<?php echo  $val_day ?>"/> € (H.T.)</td>
				<?php	
				
				$pnight = $this->clean($pricing['tarif_night']);
				$pwe = $this->clean($pricing['tarif_we']);

				if (($pnight == "1") AND ($pwe== "0")){
					?>
					<td><?php echo  SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_night" ?>" value="<?php echo  $val_night ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "0") AND ($pwe == "1")){
					?>
					<td><? SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_we" ?>" value="<?php echo  $val_we ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "1") AND ($pwe == "1")){
					?>
					<td><?php echo  SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_night" ?>" value="<?php echo  $val_night ?>"/> € (H.T.)</td>
					<td><?php echo  SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_we" ?>" value="<?php echo  $val_we ?>"/> € (H.T.)</td>
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

		<div class="page-header">
			<h3>
			<?php echo  SyTranslator::Packages($lang)?>
				<br> <small></small>
			</h3>
		</div>
		
		<!--   FORFAIT    -->
		<div class="form-group">
			<div class="col-xs-12">
				<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<!-- <td style="min-width:10em;">ID</td>  -->
						<td style="min-width:10em;">Forfait</td>
						<td style="min-width:10em;">Duration</td>
						
						<?php foreach ($pricingTable as $pricing){ 
							?>
							<td style="min-width:10em;">tarif <br/><?php echo  $pricing["name"] ?></td>
							<?php 
						}
						?>
						
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($pakages as $pakage){
													
							?>
							<tr>
								<td><input type="checkbox" name="chk" />
								
								<input class="form-control" type="hidden" name="pid[]" value="<?php echo  $pakage["id_package"] ?>"/>
								</td>
								<td><input class="form-control" type="text" name="pname[]" value="<?php echo  $pakage["name"] ?>"/></td>
								<td><input class="form-control" type="text" name="pduration[]" value="<?php echo  $pakage["duration"] ?>"/></td>
								<?php foreach ($pricingTable as $pricing){ 
									$priceValue = 0;
									if (isset($pakage["price_" .$pricing["id"]])){
										$priceValue = $pakage["price_" .$pricing["id"]];	
									}
									?>
									<td><input class="form-control" type="text" name="p_<?php echo $pricing["id"]?>[]" value="<?php echo $priceValue?>"/></td>
								<?php
								}
								?>
									
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($pakages) < 1){
						?>
						<tr>
							<td><input type="checkbox" name="chk" />
							<input class="form-control" type="hidden" name="pid[]" value=""/></td>
								<td><input class="form-control" type="text" name="pname[]" value=""/></td>
								<td><input class="form-control" type="text" name="pduration[]" value=""/></td>
	
								<?php foreach ($pricingTable as $pricing){ 
									?>
									<td><input class="form-control" type="text" name="p_<?php echo $pricing["id"]?>[]" value=""/></td>
								<?php
								}
								?>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="<?php echo SyTranslator::Add($lang)?>"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="<?php echo SyTranslator::Remove($lang)?>"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
		</div>
		
		<div class="row">
		<div class="col-xs-5 col-xs-offset-7" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  $buttonName ?>" />
		        <?php if ($this->clean($id) != ""){ ?>
		        	<button type="button" onclick="location.href='<?php echo "calendar/deletecalendarresource/".$this->clean($id) ?>'" class="btn btn-danger"><?php echo  SyTranslator::Delete($lang) ?></button>
				<?php } ?>
				<button type="button" onclick="location.href='sygrrifareasresources/resources'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
