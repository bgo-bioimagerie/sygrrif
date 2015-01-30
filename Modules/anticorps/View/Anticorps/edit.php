<?php $this->title = "Anticorps: Edit Anticorp"?>

<?php echo $navBar?>
<?php include "Modules/anticorps/View/navbar.php"; ?>


<head>

<script>
        function addRow(tableID) {

        	var idx = 0;
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

            var idx = 1;
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

<br>
<div class="col-lg-10 col-lg-offset-1">
	  <form role="form" class="form-horizontal" action="anticorps/editquery" method="post">
		<div class="page-header">
			<h1>
				Edit Anticorps <br> <small></small>
			</h1>
		</div>
		
		<?php if($anticorps['id'] != ""){?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Id</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $anticorps['id'] ?>" readonly
				/>
			</div>
		</div>
		<?php } ?>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Nom</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="nom" value="<?= $anticorps['nom'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No H2P2</label>
			<div class="col-xs-10">
				<input class="form-control" id="no_h2p2" type="text" name="no_h2p2" value="<?= $anticorps['no_h2p2'] ?>"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Fournisseur</label>
			<div class="col-xs-10">
				<input class="form-control" id="fournisseur" type="text" name="fournisseur" value="<?= $anticorps['fournisseur'] ?>"
				/>
			</div>
		</div>
		<br/>
		<!-- Source -->
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Source</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_source">
					<?php foreach($sourcesList as $source){
						$sourceID = $this->clean($source["id"]);
						$sourceName = $this->clean($source["nom"]);
						$selected = "";
						if ($anticorps["id_source"] == $sourceID){
							$selected = "selected=\"selected\"";
						}
						?>
						<OPTION value="<?= $sourceID ?>" <?= $selected ?>> <?= $sourceName ?> </OPTION>
						<?php 
					}?>
  				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Référence</label>
			<div class="col-xs-10">
				<input class="form-control" id="reference" type="text" name="reference" value="<?= $anticorps['reference'] ?>"
				/>
			</div>
		</div>
				<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Clone</label>
			<div class="col-xs-10">
				<input class="form-control" id="clone" type="text" name="clone" value="<?= $anticorps['clone'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Lot</label>
			<div class="col-xs-10">
				<input class="form-control" id="lot" type="text" name="lot" value="<?= $anticorps['lot'] ?>"
				/>
			</div>
		</div>
		<br/>
		<!-- Isotype -->
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Isotype</label>
			<div class="col-xs-10">
				<select class="form-control" name="id_isotype">
					<?php foreach($isotypesList as $isotype){
						$isotypeID = $this->clean($isotype["id"]);
						$isotypeName = $this->clean($isotype["nom"]);
						$selected = "";
						if ($anticorps["id_isotype"] == $isotypeID){
							$selected = "selected=\"selected\"";
						}
						?>
						<OPTION value="<?= $isotypeID ?>" <?= $selected ?>> <?= $isotypeName ?> </OPTION>
						<?php 
					}?>
  				</select>
			</div>
		</div>
		<br>
		<!-- Stockage -->
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Stockage</label>
			<div class="col-xs-10">
				<input class="form-control" id="stockage" type="text" name="stockage" value="<?= $anticorps['stockage'] ?>"
				/>
			</div>
		</div>
		
		<!--   TISSUS    -->
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
						<td>Dilution</td>
						<td>Temps d'incubation</td>
						<td>Référence protoole</td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($anticorps['tissus'] as $tissus){
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input class="form-control" type="text" name="espece[]" value="<?= $tissus["espece"] ?>"/></td>
								<td><input class="form-control" type="text" name="organe[]" value="<?= $tissus["organe"] ?>"/></td>
								<td><select class="form-control" name="valide[]" >
								<option value="oui" <?php if ($tissus["valide"] == "oui"){echo "selected=\"selected\"";}?>>oui</option>
								<option value="non" <?php if ($tissus["valide"] == "non"){echo "selected=\"selected\"";}?>>non</option>
								</select></td>
								<td><input class="form-control" type="text" name="ref_bloc[]" value="<?= $tissus["ref_bloc"] ?>"/></td>
								<td><input class="form-control" type="text" name="dilution[]" value="<?= $tissus["dilution"] ?>"/></td>
								<td><input class="form-control" type="text" name="temps_incubation[]" value="<?= $tissus["temps_incubation"] ?>"/></td>
								<td><input class="form-control" type="text" name="ref_protocol[]" value="<?= $tissus["ref_protocol"] ?>"/></td>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($anticorps['tissus']) < 1){
						?>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="text" name="espece[]" /></td>
							<td><input class="form-control" type="text" name="organe[]" /></td>
							<td><select class="form-control" name="valide[]">
							<option value="oui">oui</option>
							<option value="non">non</option>
							</select></td>
							<td><input class="form-control" type="text" name="ref_bloc[]" /></td>
							<td><input class="form-control" type="text" name="dilution[]" /></td>
							<td><input class="form-control" type="text" name="temps_incubation[]" /></td>
							<td><input class="form-control" type="text" name="ref_protocol[]" /></td>
						</tr>
						<?php 
						}
						?>
					</tbody>
				</table>
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Ajouter Tissus"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="Enlever Tissus"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
		</div>
		
		<!-- Disponible -->		
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Disponible</label>
			<div class="col-xs-10">
				<select class="form-control" name="disponible">
					<OPTION value="oui" <?php if($anticorps['disponible'] == "oui"){echo "selected=\"selected\"";}?>> oui </OPTION>
					<OPTION value="non" <?php if($anticorps['disponible'] == "non"){echo "selected=\"selected\"";}?>> non </OPTION>
				</select>
			</div>
		</div>
		
		<!-- ADD HERE PROPRIO ADD  -->
		<div class="form-group">
			<label class="control-label col-xs-2">Propriétaire</label>
			<div class="col-xs-10">
				<table id="proprioTable" class="table table-striped">
					<tbody>
						<tr>
							<?php 
							foreach ($anticorps['proprietaire'] as $proprio){
								?>
								<td><input type="checkbox" name="chk" /></td>
								<td>
									<select class="form-control" name="id_proprietaire[]">
									<?php 
								
									$pid = $this->clean($proprio["id"]);
									foreach ($users as $user){
										$uid = $this->clean($user["id"]);	
										$uname = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]) ;
										$selected = "";
										if ($pid == $uid){
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?=$uid?>" <?=$selected?>> <?= $uname ?> </OPTION>
										<?php 
									}	
									?>
									</select>	
								</td>
							<?php
							} 
							?>	
							<?php 
							if(count($anticorps['proprietaire']) < 1){
							?>
							    <td><input type="checkbox" name="chk" /></td>
								<td>
									<select class="form-control" name="id_proprietaire[]">
									<?php
									foreach ($users as $user){
										$uid = $this->clean($user["id"]);
										$uname = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]) ;
										?>
										<OPTION value="<?=$uid?>"> <?= $uname ?> </OPTION>
									<?php 
									}	
									?>
									</select>	
								</td>
							<?php	
							}
							?>
						</tr>	
					</tbody>
				</table>
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="Ajouter Propriétaire"
						onclick="addRow('proprioTable')" /> 
					<input type="button" class="btn btn-default" value="Enlever Propriétaire"
						onclick="deleteRow('proprioTable')" /> <br> 
				</div>
			</div>
		</div>
		
		<br>
		<!-- Date Reception -->
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2">Date Reception</label>
			<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date_recept" value="<?= $anticorps['date_recept'] ?>"/>
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
		
		<!-- Buttons -->
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='anticorps'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
