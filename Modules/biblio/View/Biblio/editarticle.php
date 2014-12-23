<?php $this->title = "Anticorps: Edit Anticorp"?>

<?php echo $navBar?>
<?php include "Modules/anticorps/View/navbar.php"; ?>

<head>

	<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	
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


<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	  <form role="form" class="form-horizontal" action="biblio/editarticle" method="post">
		<div class="page-header">
			<h1>
				Add article <br> <small></small>
			</h1>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Title</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="title"
				 />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Authors</label>
			<div class="col-xs-10">
					<table id="dataTable" class="table table-striped">
					<thead>
						<tr>
							<td></td>
							<td>Name</td>
							<td>Firstname</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="text" name="auth_name[]" /></td>
							<td><input class="form-control" type="text" name="auth_firstname[]" /></td>
						</tr>
					</tbody>
				</table>

				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Add Author"
						onclick="addRow('dataTable')" /> <input type="button"
						class="btn btn-default" value="Remove Author"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Journal</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="journal"
				 />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Year</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="number" name="year"
				 />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Month</label>
			<div class="col-xs-10">
				<select class="form-control" name="month">
					<OPTION value="0" >  </OPTION>
					<OPTION value="1" > January </OPTION>
					<OPTION value="2" > February </OPTION>
					<OPTION value="3" > March  </OPTION>
					<OPTION value="4" >  April </OPTION>
					<OPTION value="5" > May </OPTION>
					<OPTION value="6" > June </OPTION>
					<OPTION value="7" > July </OPTION>
					<OPTION value="8" > August  </OPTION>
					<OPTION value="9" > September </OPTION>
					<OPTION value="10" > October </OPTION>
					<OPTION value="11" > November </OPTION>
					<OPTION value="12" > December </OPTION>
				</select>
			</div>
		</div>
	  
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Volume</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="number" name="volume"
				 />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Pages</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="pages"
				 />
			</div>
		</div>

		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='anticorps'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
