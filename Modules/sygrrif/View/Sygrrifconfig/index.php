<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>
<?php
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<head>

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


<div class="container">
    	<div class="col-md-10 col-md-offset-1">
    	
    	<div class="page-header">
			<h1>
				SyGRRif configuration <br> <small></small>
			</h1>
		</div>
		
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				Install/Repair database <br> <small></small>
			</h2>
		</div>
		</div>
		
		<form role="form" class="form-horizontal" action="sygrrifconfig"
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
		To install the SyGRRif mudule, click "Install". This will create the 
		SyGRRif tables in the database if they don't exists or repair them
		if they exists
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="Install" />
		</div>
      </form>
      
      
      <!-- Sygrrif Menu -->
      <div>
		  <div class="page-header">
			<h2>
				Activate/desactivate menus <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		  
		    <div class="col-xs-12">
		    
		    <?php foreach ($menus as $menu){
		    	$menuName = $menu["name"];
		    	$menuStatus = $menu["status"];
		    ?>
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4"><?=$menuName?></label>
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
			
			<div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Authorisations_menu_location($lang)?></label>
				<div class="col-xs-6">
					<select class="form-control" name="authorisations_location">
						<OPTION value="1" <?php if($authorisations_location==1){echo "selected=\"selected\"";} ?> > SyGRRif </OPTION>
						<OPTION value="2" <?php if($authorisations_location==2){echo "selected=\"selected\"";} ?> > <?= CoreTranslator::Users_Institutions($lang) ?> </OPTION>
					</select>
				</div>
			</div>
					
			
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
      <!-- set bill template section -->
      <div>
		<div class="page-header">
		  <h2>
			Bill template <br> <small></small>
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
			
      <form action="sygrrifconfig" method="post" enctype="multipart/form-data">
      <div class="col-xs-10">
			<input class="form-control" type="hidden" name="templatequery" value="yes"
				/>
	  </div>
      
      <div class="form-group">
          <div class="col-md-10">
          <p>
          Select a xls file that will be used as template 
          to generate the SyGRRif bill</p>
    	
    	  <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
      </div>
      <div class="col-xs-2 col-xs-offset-10" id="button-div">
    	<input class="btn btn-primary" type="submit" value="Upload" name="submit">
      </div>
	  </form>
	  
	  <br></br>	
	  <br></br>
	  <!-- Booking options -->
      <div>
		  <div class="page-header">
			<h2>
				Booking summary options <br> <small></small>
			</h2>
		  </div>
		
		  <?php 
		  if ( isset($bookingOptionMessage) ){
		  	if ($bookingOptionMessage != ""){
		  		?>
		  		<div class="alert alert-info">	  
		  		<p><?= $bookingOptionMessage ?></p>
		  		</div>
		  		<?php 
		  	}
		  }	
		
		  ?>
		  
		  <?php 
		  if (isset($bookingSettings) && $bookingSettings != ""){
		  ?>
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setbookingoptionsquery" value="yes"
			 	/>
		    </div>
		    
		    <!-- recipient name -->
		    <?php 
		    //$tagName = $this->clean($bookingSettings[$i]['tag_name']);
		    $i=0;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient name:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rname">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rname">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rname">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rname">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 

		    <!-- recipient phone - rphone-->
		    <?php 
		    $i=1;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient phone:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rphone">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rphone">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rphone">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rphone">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 
		    
		    
		    <!-- short description - sdesc -->
		    <?php 
		    $i=2;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Short description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_sdesc">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_sdesc">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_sdesc">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_sdesc">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 
		    
		    <!-- description - desc -->
		    <?php 
		    $i=3;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_desc">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_desc">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_desc">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_desc">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    <br></br>
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
		  <?php 
		  }
		  ?>
		  
		</div>
		
		<!-- Booking options -->
		<form role="form" class="form-horizontal" action="sygrrifconfig"
		method="post">
		<div class="col-xs-12">
		<div class="col-xs-10">
			  <input class="form-control" type="hidden" name="editbookingdescriptionquery" value="yes"
			 	/>
		</div>
		
		
		<!-- Calendar suplementary info -->
      <div>
		  <div class="page-header">
			<h2>
				Supplementary informations <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  <div class="col-xs-12">
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setcalsupsquery" value="yes"
			 	/>
		    </div>
		  
		    <div class="col-xs-10">
		      <table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td>Name</td>
						<td>Mandatory</td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($calSups as $calsup){
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td>
									<input class="form-control" type="text" name="name[]" value="<?=$calsup["name"]?>" />
								</td>
								<td>
									<select class="form-control" name="ismandatory[]">
									    <?php 
									        $calsup_mandatory = $this->clean($calsup["mandatory"]);
									    ?>
									    <OPTION value="1" <?php if ($calsup_mandatory == 1){echo "selected=\"selected\"";}?> > yes </OPTION>
									    <OPTION value="0" <?php if ($calsup_mandatory == 0){echo "selected=\"selected\"";}?> > no </OPTION>
									</select>
								</td>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($calSups) < 1){
						?>
						<tr>
						<td><input type="checkbox" name="chk" /></td>
							<td>
								<input class="form-control" type="text" name="name[]" />
							</td>
							<td>
								<select class="form-control" name="ismandatory[]">
								    <OPTION value="1"> yes </OPTION>
								    <OPTION value="0"> no </OPTION>
								</select>
							</td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>		
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Add"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="Delete"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
			</div>
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
		 <form role="form" class="form-horizontal" action="sygrrifconfig" method="post">
        <div>
		  <div class="page-header">
			<h2>
				Edit Booking options <br> <small></small>
			</h2>
		  </div>
		  
		  <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="editbookingdescriptionquery" value="yes"
			 	/>
		    </div>
		  
		  <?php 
		  	$tag_desc = $this->clean($editBookingDescriptionSettings);
		  ?>
		  <div class="col-xs-3"><label class="control-label">Description fields:</label>
		  </div>
		    <div class="col-xs-6"><select class="form-control" name="description_fields">
				<OPTION value="1" <?php if ($tag_desc == 1){echo "selected=\"selected\"";}?>> Both short and full description </OPTION>
				<OPTION value="2" <?php if ($tag_desc == 2){echo "selected=\"selected\"";}?>> Only short description </OPTION>
				<OPTION value="3" <?php if ($tag_desc == 3){echo "selected=\"selected\"";}?>> Only full description </OPTION>
			</select>
		  </div>
		  
		  <div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		  </div>
		  
		  </div>
		  </div>
        </form>  
		
		<!-- Booking mailing -->
		<form role="form" class="form-horizontal" action="sygrrifconfig"
		method="post">
		<div class="col-xs-12">
		<div class="col-xs-10">
			  <input class="form-control" type="hidden" name="editbookingmailingquery" value="yes"
			 	/>
		</div>
		
        <div>
		  <div class="page-header">
			<h2>
				Edit Booking Mailing <br> <small></small>
			</h2>
		  </div>
		  
		  <?php 
		  	$tag_mail = $this->clean($editBookingMailing);
		  ?>
		  <div class="col-xs-3"><label class="control-label">Send emails:</label>
		  </div>
		    <div class="col-xs-6">
		      <select class="form-control" name="email_when">
				<OPTION value="1" <?php if ($tag_mail == 1){echo "selected=\"selected\"";}?>> Never </OPTION>
				<OPTION value="2" <?php if ($tag_mail == 2){echo "selected=\"selected\"";}?>> When manager/admin edit a reservation </OPTION>
			  </select>
		  </div>
		  
		  <div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		  </div>
		  
		  </div>
		  </div>
        </form>
		
		<!-- Series booking -->
		<div class="col-xs-12">
			<div class="page-header">
				<h2>
					Series booking <br> <small></small>
				</h2>
			</div>
		</div>
		
		<form role="form" class="form-horizontal" action="sygrrifconfig"
		method="post">
		
		<div class="col-xs-10">
			  <input class="form-control" type="hidden" name="seriesbookingquery" value="yes"
			 	/>
		</div>
		
		<div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4">Series Booking</label>
				<div class="col-xs-6">
					<select class="form-control" name="seriesBooking">
					<OPTION value="0" <?php if($seriesBooking==0){echo "selected=\"selected\"";} ?> > nobody </OPTION>
					<OPTION value="2" <?php if($seriesBooking==2){echo "selected=\"selected\"";} ?> > users </OPTION>
					<OPTION value="3" <?php if($seriesBooking==3){echo "selected=\"selected\"";} ?> > manager </OPTION>
					<OPTION value="4" <?php if($seriesBooking==4){echo "selected=\"selected\"";} ?> > admin </OPTION>
				</select>
			</div>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="save" />
		</div>
      </form>
      
      
      
      <!-- Series booking -->
	  <div class="col-xs-12">
			<div class="page-header">
				<h2>
					Edit reservation plugin <br> <small></small>
				</h2>
			</div>
		</div>
      <form role="form" class="form-horizontal" action="sygrrifconfig" method="post">
      <div class="col-xs-10">
			<input class="form-control" type="hidden" name="editresapluginquery" value="yes"
				/>
	  </div>
      
      <div class="form-group col-xs-12">
			<label for="inputEmail" class="control-label col-xs-4">edit reservation link</label>
			<div class="col-xs-6">
    	  	<input class="form-control" type="text" name="resalink" id="resalink" value="<?=$sygrrifEditReservation?>">
        </div>
      </div>
      <div class="col-xs-2 col-xs-offset-10" id="button-div">
    	<input class="btn btn-primary" type="submit" value="Save" name="submit">
      </div>
	  </form>
      
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>