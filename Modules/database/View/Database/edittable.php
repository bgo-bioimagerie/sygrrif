<?php $this->title = "SyGRRiF Database"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#table-div {
	border: 1px solid #e1e1e1;
	border-radius: 9px;
}
</style>

<script language="javascript">
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[1].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[1].cells[i].innerHTML;
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
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 2) {
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



<?php include "Modules/database/View/navbar.php"; ?>


<br></br>

<div class="contatiner"></div>
<div class="col-md-2" id="table-div">
	<table class="table table-striped">
		<thead>
			<tr>
				<td>Tables:</td>
			</tr>
		</thead>
		<tbody>
    		<?php
						foreach ( $tablesNames as $tablesName ) :
							$name = $this->clean ( $tablesName ['name'] );
							?>  
      		<tr>
				<td><a href=<?= "database/edittable/" . $name ?>><?= $name ?></a></td>
			</tr>     
    		<?php endforeach; ?>
    	</tbody>
	</table>
</div>

<?php if ($tablename != ""){?>
<div class="col-md-6 col-md-offset-2">
	<form role="form" class="form-horizontal"
		action="database/edittablequery" method="post">

		<div class="page-header">
			<h1>
				Edit table columns <br> <small>Please fill the form below to modify
					the table columns</small>
			</h1>
		</div>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Table name</label>
			<div class="col-xs-10">
				<input class="form-control uneditable-input" id="table_name"
					type="text" name="table_name" placeholder=<?= $tablename ?> />
			</div>
		</div>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Colums</label>
			<div class="col-xs-10">

				<table id="dataTable" class="table table-striped">
					<thead>
						<tr>
							<td>Name</td>
							<td>Type</td>
							<td>Length/Values</td>
						</tr>
					</thead>
					<tbody>
					<?php 
					for ($i = 0 ; $i < count($tableColumns['entry_name']) ; $i++){
						$cname = $tableColumns['entry_name'][$i];
						if ($cname != "id") {
							$type = $tableColumns['entry_type'][$i];
							$typesize = $tableColumns['entry_type_length'][$i];
					?>		
					<tr>
					<td><input type="checkbox" name="chk" /></td>
					<!--  name  -->
					<td><input class="form-control" type="text" name="entry_name[]" value=" <?= $cname ?>  "/></td>
					<!--  type  -->
					<td><select class="form-control" name="entry_type[]" value=" <?= $type ?> ">
						<OPTION value="int">INTEGER</OPTION>
						<OPTION value="varchar">VARCHAR</OPTION>
						<OPTION value="date">DATE</OPTION>
						</select></td>
					<!--  length -->
					<td><input class="form-control" type="text" name="entry_type_length[]" value=" <?=  $typesize ?> "/></td>
					<?php
						}
					}
					?>
    	</tbody>
				</table>
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Add Row"
						onclick="addRow('dataTable')" /> <input type="button"
						class="btn btn-default" value="Delete Row"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
	</div>
	<div class="col-md-1 col-md-offset-10">
			<input type="submit" class="btn btn-primary" value="Modify" />
	</div>
	</form>

</div>
<?php }else{?>
<div class="col-md-6 col-md-offset-2 text-center">
	<p>Click on a table on the left navigation bar to edit a table</p>
</div>
<?php }?>
</div>
<!-- /container -->



<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>