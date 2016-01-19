<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

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

<style type="text/css">
    .box{
        display: none;
    }
</style>

</head>


<?php include "Modules/core/View/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="coreusers/editquery" method="post" enctype="multipart/form-data">
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
		
		<!--   TISSUS    -->
		<div class="form-group">
			<label class="control-label col-xs-1"><?php echo CoreTranslator::Responsible($lang)?></label>
			<div class="col-xs-11">
				<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td style="min-width:10em;"><?php echo CoreTranslator::Name($lang)?></td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($userResponsibles as $idResp){
													
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td>
								<select class="form-control" name="id_responsible[]">   
									<?php foreach ($respsList as $resp):?>
					    			<?php   $respId = $this->clean( $resp['id'] );
						    		if ($resp['id'] > 1){
								    	$respSummary = $this->clean( $resp['name'] ) . " " . $this->clean( $resp['firstname'] );
						    		}
						    		else{
						    			$respSummary = "--";
						    		}
						    		$active = "";
						    		if ( $idResp[0] == $respId  ){
						    			$active = "selected=\"selected\"";
						    		}
								?>
								<OPTION value="<?php echo  $respId ?>" <?php echo  $active ?>> <?php echo  $respSummary ?> </OPTION>
								<?php endforeach; ?>
								</select>
								</td>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($userResponsibles) < 1){
						?>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td>
							<select class="form-control" name="id_responsible[]">   
								<?php foreach ($respsList as $resp):?>
					    		<?php   $respId = $this->clean( $resp['id'] );
						    	if ($resp['id'] > 1){
							    	$respSummary = $this->clean( $resp['name'] ) . " " . $this->clean( $resp['firstname'] );
						    	}
						    	else{
						    		$respSummary = "--";
						    	}
							?>
							<OPTION value="<?php echo  $respId ?>"> <?php echo $respSummary ?> </OPTION>
							<?php endforeach; ?>
							</select>
							</td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="<?php echo CoreTranslator::Add($lang)?>"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="<?php echo CoreTranslator::Delete($lang)?>"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
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
			      
			      <input type="checkbox" name="is_responsible" <?php echo $checked ?>> <?php echo  CoreTranslator::is_responsible($lang)?>
			      
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

		<input class="form-control" id="convention" type="hidden" name="convention" value = "<?php echo  $user['convention'] ?>">
		<br>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_convention($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?php echo  CoreTranslator::dateFromEn($user['date_convention'], $lang) ?>" name="date_convention">
		    </div>
		</div>
		<br/>
		<div class="form-group">
         	<label class="control-label col-xs-2"><?php echo  CoreTranslator::Convention($lang) ?></label>
			<div class="col-xs-10">
            	<input type="file" name="file_convention" id="file_convention">
        	</div>
      	</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_end_contract($lang)?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" value = "<?php echo  CoreTranslator::dateFromEn($user['date_end_contract'], $lang) ?>" name="date_end_contract">
		    </div>
		</div>
		
		<div class="form-group">
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
				<button type="button" onclick="location.href='coreusers'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang)?></button>
		</div>
		
      </form>
      
      
      <?php if (file_exists ( "data/core/" . $user["login"] . ".pdf" )){?>
      <div class="page-header">
		 <h1>
			<?php echo  CoreTranslator::Convention($lang) ?>
			<br> <small></small>
			</h1>
	   </div>
	   
	  	<div class="col-xs-2">
        	<form method="get" action="data/core/<?php echo $user["login"] ?>.pdf">
        		<button type="submit" class="btn btn-lg btn-default" aria-label="Left Align">
  					<span class="glyphicon glyphicon glyphicon-open-file" aria-hidden="true"></span>
				</button>
			</form>
		</div>
	   <?php }?>
              	

			
      <br>
      <div>
      	<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Change_password($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-4" id="button-div">
				<button type="button" onclick="location.href='coreusers/changepwd/<?php echo $user['id']?>'" class="btn btn-default"><?php echo  CoreTranslator::Change_password($lang) ?></button>
			</div>
		</div>
	  </div>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
