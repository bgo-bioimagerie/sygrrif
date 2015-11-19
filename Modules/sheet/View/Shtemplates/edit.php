<?php $this->title = "Storage" ?>

<?php echo $navBar ?>

<?php
require_once 'Modules/sheet/Model/ShTranslator.php';
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

<?php include "Modules/sheet/View/navbar.php"; ?>

<div class="col-xs-10">
    	<div class="page-header">
			<h1>
				<?php echo  ShTranslator::Edit_template($lang) ?> <br> <small></small>
			</h1>
		</div>
 
      <!-- Storage directories -->
      <div>
	
		  <form role="form" class="form-horizontal" action="shtemplates/editquery" method="post">
		  
		  
		    <div class="col-xs-12">
		    
		      <?php if(isset($id)){ ?>
		      <input class="form-control" type="hidden" name="id" value="<?php echo  $id ?>"
			 	/>	
			  <?php } ?>
		      <div class="form-group">
				  <label for="inputEmail" class="control-label col-xs-1">Name</label>
				  <div class="col-xs-11">
			  	  	<input class="form-control" type="text" name="name" value="<?php echo  $name ?>" />
			  	  </div>
		    </div>
		    </div>	
		    
			<div class="col-xs-12">
		
				<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td></td>
						<td>Type</td>
						<td>Caption</td>
						<td>Default value</td>
						<td>Display order</td>
						<td>Mandatory field</td>
						<td>Who can modify</td>
						<td>Who can book</td>
						<td>Add to summary</td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($items as $item){					
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input class="form-control" type="hidden" name="id_element[]" value="<?php echo  $item["id"] ?>" /></td>
								<td>
								<select class="form-control" name="id_element_type[]">
								<?php 
								for($t = 0 ; $t < count($itemstypes) ; $t++){
									?>
									<OPTION value="<?php echo $itemstypes[$t]["id"]?>" <?php if($item["id_element_type"]==$itemstypes[$t]["id"]){echo "selected=\"selected\"";} ?> > <?php echo  $itemstypes[$t]["name"]?> </OPTION>
									<?php							
								}							    
								?>
								</select>
								</td>
								<td><input class="form-control" type="text" name="caption[]" value="<?php echo  $item["caption"] ?>" /></td>
								<td><input class="form-control" type="text" name="default_values[]" value="<?php echo  $item["default_values"] ?>" /></td>
								<td><input class="form-control" type="number" name="display_order[]" value="<?php echo  $item["display_order"] ?>" /></td>
								<td>
								<select class="form-control" name="mandatory[]">
									<OPTION value="0" <?php if($item["mandatory"]==0){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::No($lang)?> </OPTION>
									<OPTION value="1" <?php if($item["mandatory"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::yes($lang)?> </OPTION>
								</select>
								</td>
								<td>
								<select class="form-control" name="who_can_modify[]">
									<OPTION value="1" <?php if($item["who_can_modify"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
									<OPTION value="2" <?php if($item["who_can_modify"]==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
									<OPTION value="3" <?php if($item["who_can_modify"]==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
									<OPTION value="4" <?php if($item["who_can_modify"]==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
								</select>
								</td>
								<td>
								<select class="form-control" name="who_can_see[]">
									<OPTION value="1" <?php if($item["who_can_see"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
									<OPTION value="2" <?php if($item["who_can_see"]==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
									<OPTION value="3" <?php if($item["who_can_see"]==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
									<OPTION value="4" <?php if($item["who_can_see"]==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
								</select>
								</td>
								<td>
								<select class="form-control" name="add_to_summary[]">
									<OPTION value="0" <?php if($item["add_to_summary"]==0){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::No($lang)?> </OPTION>
									<OPTION value="1" <?php if($item["add_to_summary"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::yes($lang)?> </OPTION>
								</select>
								</td>
							</tr>
							<?php							
						}
						?>
						<?php 
						if (count($items) < 1){
						?>
						<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td>
								<select class="form-control" name="id_element_type[]">
								    <?php 
								    foreach($itemstypes as $type){
								    	?>
								    	<OPTION value="<?php echo $type["id"]?>"> <?php echo  $type["name"] ?></OPTION>
								    <?php 
								    }								    
								    ?>	
								</select>
								</td>
								<td><input class="form-control" type="text" name="caption[]" /></td>
								<td><input class="form-control" type="text" name="default_values[]" /></td>
								<td><input class="form-control" type="number" name="display_order[]" /></td>
								<td>
								<select class="form-control" name="mandatory[]">
									<OPTION value="0" > <?php echo  CoreTranslator::No($lang)?></OPTION>
									<OPTION value="1" > <?php echo  CoreTranslator::yes($lang)?> </OPTION>
								</select>
								</td>
								<td>
								<select class="form-control" name="who_can_modify[]">
									<OPTION value="1" > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
									<OPTION value="2" > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
									<OPTION value="3" > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
									<OPTION value="4" > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
								</select>
								</td>
								<td>
								<select class="form-control" name="who_can_see[]">
									<OPTION value="1" > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
									<OPTION value="2" > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
									<OPTION value="3" > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
									<OPTION value="4" > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
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
					<input type="button" class="btn btn-default" value="Remove"
						onclick="deleteRow('dataTable')" /> <br> 
				</div>
			</div>	
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
       
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif; ?>