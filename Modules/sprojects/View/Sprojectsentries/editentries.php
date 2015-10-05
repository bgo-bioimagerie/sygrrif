<?php $this->title = "sprojects"?>

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

<?php include "Modules/sprojects/View/navbar.php"; ?>

<div class="col-md-12" style="margin-top: -50px">
	<form role="form" class="form-horizontal" action="sprojectsentries/editquery"
		method="post">
	
		<div class="page-header col-md-12">
			<div class="col-xs-10">
			<h1>
			<?php 
			$projectID = 0;
			if ($this->clean($project["id"]) == ""){
				$buttonName = CoreTranslator::Save($lang);
				
				echo SpTranslator::Add_Order($lang);
			}
			else{
				$buttonName = CoreTranslator::Save($lang);;
				$projectID = $this->clean($project["id"]);
				echo SpTranslator::Edit_Order($lang);
			}
				?>	
			</h1>
			</div>
			<div class="col-xs-2">
			
			<button type="button" onclick="location.href='sprojectsbill/<?php echo $projectID?>'" class="btn btn-primary"><?php echo  SpTranslator::Billit($lang) ?></button>
			</div>
		</div>

		<div class="page-header">
			<h3>
			<?php echo  SpTranslator::Description($lang) ?>
				<br> <small></small>
			</h3>
		</div>
	
	    <div class="col-md-12">
		<div class="col-md-8 col-md-offset-2">
		<?php if ($this->clean($project["id"]) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?php echo $this->clean($project["id"]) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::Responsible($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_resp">
				<?php foreach($responsibles as $user){ 
					$userid = $this->clean($user["id"]);
					$userName = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]); 
					$selected = "";
					if ($userid == $this->clean($project["id_resp"])){
						$selected = "selected=\"selected\"";
					}
					?>
					<option value="<?php echo  $userid ?>" <?php echo  $selected ?>> <?php echo  $userName ?> </option>
				<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">No Projet</label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="name" value="<?php echo $this->clean($project["name"]) ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::User($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_user">
				<?php foreach($users as $user){ 
					$userid = $this->clean($user["id"]);
					$userName = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]); 
					$selected = "";
					if ($userid == $this->clean($project["id_user"])){
						$selected = "selected=\"selected\"";
					}
					?>
					<option value="<?php echo  $userid ?>" <?php echo  $selected ?>> <?php echo  $userName ?> </option>
				<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::Status($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_status">
				<?php
					$selected = "selected=\"selected\"";
					$status = $this->clean($project["id_status"]);
					?>
					<option value="1" <?php if ($status==1){echo $selected;}?>> <?php echo  CoreTranslator::Open($lang) ?>  </option>
					<option value="0" <?php if ($status==0){echo $selected;}?>> <?php echo  CoreTranslator::Close($lang) ?> </option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Opened_date($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="date_open" value="<?php echo  CoreTranslator::dateFromEn($this->clean($project["date_open"]), $lang) ?>" readonly/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Closed_date($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="date_close" value="<?php echo  CoreTranslator::dateFromEn($this->clean($project["date_close"]), $lang) ?>" readonly/>
			</div>
		</div>
		</div>
		</div>
		<div class="page-header">
			<h3>
			<?php echo  SpTranslator::Order($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<!--  add here the order list -->
		<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td></td>
						<td style="min-width:120px;">Date</td>
						<?php 
						foreach($items as $item){
						?>
						<td style="min-width:1px;"><?php echo $item["name"]?></td>
						<?php 
						}
						?>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($projectEntries as $order){
 
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input type="hidden" name="item_id[]" value="<?php echo $order["id"]?>"/>
								</td>
								
								<td><input class="form-control" type="text" name="item_date[]" value="<?php echo CoreTranslator::dateFromEn($order["date"], $lang)?>" required/></td>
								<?php 
								foreach($items as $item){
									
									$quantity = "";
									if (isset($order["content"]["item_".$item["id"]])){
										$quantity = $order["content"]["item_".$item["id"]];
									}
								?>
									<td><input class="form-control" type="text" name="item_<?php echo $item["id"]?>[]" value="<?php echo $quantity ?>" /></td>
								<?php
								}
								?>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($projectEntries) < 1){
						?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input type="hidden" name="item_id[]" /></td>
								<td><input class="form-control" type="text" name="item_date[]" required/></td>
								<?php 
								foreach($items as $item){

								?>
									<td><input class="form-control" type="text" name="item_<?php echo $item["id"]?>[]" /></td>
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
					<input type="button" class="btn btn-default" value="<?php echo  CoreTranslator::Add($lang) ?>"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="<?php echo  CoreTranslator::Delete($lang) ?>"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
		
		
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  $buttonName ?>" />
				<button type="button" onclick="location.href='sprojectsentries'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
</div>


<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
