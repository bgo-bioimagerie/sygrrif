<?php $this->title = "SyGRRiF Database"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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


<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="database/createtablequery"
		method="post">

		<div class="page-header">
			<h1>
				Add table <br> <small>Please fill the form below to create a new
					table</small>
			</h1>
		</div>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Table name</label>
			<div class="col-xs-10">
				<input class="form-control" id="table_name" type="text"
					name="table_name" placeholder="table_name" />
			</div>
		</div>

		<br>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Colums</label>
			<div class="col-xs-10">
				<table id="dataTable" class="table table-striped">
					<thead>
						<tr>
							<td></td>
							<td>Name</td>
							<td>Type</td>
							<td>Length/Values</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="text" name="entry_name[]" /></td>
							<td><select class="form-control" name="entry_type[]">
									<OPTION value="int">INTEGER</OPTION>
									<OPTION value="varchar">VARCHAR</OPTION>
									<OPTION value="date">DATE</OPTION>
							</select></td>
							<td><input class="form-control" type="text" name="entry_type_length[]" /></td>
						</tr>
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
			<input type="submit" class="btn btn-primary" value="Create" />
		</div>
	</form>
</div>


<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>