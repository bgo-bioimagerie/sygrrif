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
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="anticorps/addquery" method="post">
		<div class="page-header">
			<h1>
				Ajouter Anticorps <br> <small></small>
			</h1>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Nom</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="nom"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No H2P2</label>
			<div class="col-xs-10">
				<input class="form-control" id="no_h2p2" type="text" name="no_h2p2" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Propriétaire</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_proprietaire">
					<?php foreach ($users as $user):?>
					    <?php $username = $this->clean( $user['firstname'] . " " . $user['name'] );
					          $userId = $this->clean( $user['id'] );
					    ?>
						<OPTION value="<?= $userId ?>" > <?= $username ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group ">
		
				<label for="inputEmail" class="control-label col-xs-2">Date Reception</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date_recept"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
	        <script src="bootstrap/datepicker/js/moments.js"></script>
			<script src="bootstrap/jquery-1.11.1.js"></script>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
			$(function () {
				$('#datetimepicker5').datetimepicker({
					pickTime: false
				});
			});
		    </script>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Référence</label>
			<div class="col-xs-10">
				<input class="form-control" id="reference" type="text" name="reference" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Clone</label>
			<div class="col-xs-10">
				<input class="form-control" id="clone" type="text" name="clone" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Fournisseur</label>
			<div class="col-xs-10">
				<input class="form-control" id="fournisseur" type="text" name="fournisseur" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Lot</label>
			<div class="col-xs-10">
				<input class="form-control" id="lot" type="text" name="lot" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Isotype</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_isotype">
					<?php foreach ($isotypesList as $isotype):?>
					    <?php $isotypename = $this->clean( $isotype['nom'] );
					          $isotypeId = $this->clean( $isotype['id'] );
					    ?>
						<OPTION value="<?= $isotypeId ?>" > <?= $isotypename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Source</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_source">
					<?php foreach ($sourcesList as $source):?>
					    <?php $sourcename = $this->clean( $source['nom'] );
					          $sourceId = $this->clean( $source['id'] );
					    ?>
						<OPTION value="<?= $sourceId ?>" > <?= $sourcename ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Stockage</label>
			<div class="col-xs-10">
				<input class="form-control" id="stockage" type="text" name="stockage" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No Protocole</label>
			<div class="col-xs-10">
				<input class="form-control" id="No_Proto" type="text" name="No_Proto" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Disponible</label>
			<div class="col-xs-10">
				<select class="form-control" name="disponible">
					<OPTION value="oui" > oui </OPTION>
					<OPTION value="non" > non </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Tissus</label>
			<div class="col-xs-10">
					<table id="dataTable" class="table table-striped">
					<thead>
						<tr>
							<td></td>
							<td>Espece</td>
							<td>Organe</td>
							<td>Validé</td>
							<td>Référence bloc</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="text" name="espece[]" /></td>
							<td><input class="form-control" type="text" name="organe[]" /></td>
							<td><select class="form-control" name="valide[]">
									<option value="oui">oui</option>
									<option value="non">non</option>
							</select></td>
							<td><input class="form-control" type="text" name="ref_bloc[]" /></td>
						</tr>
					</tbody>
				</table>

				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Ajouter Tissus"
						onclick="addRow('dataTable')" /> <input type="button"
						class="btn btn-default" value="Enlever Tissus"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
				
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
