<?php $this->title = "Zoomify" ?>

<?php echo $navBar ?>

<?php
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
    	<div class="col-md-8 col-md-offset-2">
    	
    	<div class="page-header">
			<h1>
				<?php echo  ZoTranslator::Storage_configuration($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				<?php echo  ZoTranslator::Install_Repair_database($lang) ?> <br> <small></small>
			</h2>
		</div>
		
		<form role="form" class="form-horizontal" action="zoomifyconfig"
		method="post">
		
		<?php if (isset($installError)): ?>
        <div class="alert alert-danger" role="alert">
    	<p><?php echo  $installError ?></p>
    	</div>
		<?php endif; ?>
		<?php if (isset($installSuccess)): ?>
        <div class="alert alert-success" role="alert">
    	<p><?php echo  $installSuccess ?></p>
    	</div>
		<?php endif; ?>
		
		<p>
		<?php echo  CoreTranslator::Install_Txt($lang) ?>
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Install($lang) ?>" />
		</div>
      </form>
  
      
      <!-- Storage Menu -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  CoreTranslator::Activate_desactivate_menus($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="zoomifyconfig"
		  method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		    
		    <div class="form-group col-xs-12">
				<label for="inputEmail" class="control-label col-xs-4">Storage</label>
				<div class="col-xs-6">
					<select class="form-control" name="zoomifymenu">
						<OPTION value="0" <?php if($menuStatus["status"]==0){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::disable($lang) ?> </OPTION>
						<OPTION value="1" <?php if($menuStatus["status"]==1){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_visitors($lang) ?> </OPTION>
						<OPTION value="2" <?php if($menuStatus["status"]==2){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_users($lang) ?> </OPTION>
						<OPTION value="3" <?php if($menuStatus["status"]==3){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_manager($lang) ?> </OPTION>
						<OPTION value="4" <?php if($menuStatus["status"]==4){echo "selected=\"selected\"";} ?> > <?php echo  CoreTranslator::enable_for_admin($lang) ?> </OPTION>
					</select>
				</div>
			</div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
		    </div>
		  </form>
      </div>
      
 
      <!-- Storage directories -->
      <div>
		  <div class="page-header">
			<h2>
				<?php echo  ZoTranslator::Directories_names($lang) ?> <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="zoomifyconfig" method="post">
		  
		    <div class="col-xs-12">
			  <input class="form-control" type="hidden" name="setdirectoriesquery" value="yes"
			 	/>
		    </div>
		    
		    <!--  DIRECTORIES  -->
		  <div class="form-group">

			<div class="col-xs-11">
			<div>
				<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td>ID</td>
						<td>Name</td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($directories as $dir){					
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input class="form-control" type="hidden" name="storagedirectoriesids[]" value="<?php echo  $dir["id"] ?>"/></td>
								<td><input class="form-control" type="text" name="storagedirectoriesnames[]" value="<?php echo  $dir["name"] ?>" /></td>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($directories) < 1){
						?>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="hidden" name="storagedirectoriesids[]" value="0"/></td>
							<td><input class="form-control" type="text" name="storagedirectoriesnames[]"/></td>
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