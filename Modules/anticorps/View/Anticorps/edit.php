<?php $this->title = "Anticorps: Edit Anticorp"?>

<?php echo $navBar?>
<?php include "Modules/anticorps/View/navbar.php"; ?>


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
									
<br>
<div class="col-lg-12">
	  <form role="form" class="form-horizontal" action="anticorps/editquery" method="post">
		<div class="page-header">
			<h1>
				Edit Anticorps <br> <small></small>
			</h1>
		</div>
		
		<?php if($anticorps['id'] != ""){?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Id</label>
			<div class="col-xs-11">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $anticorps['id'] ?>" readonly
				/>
			</div>
		</div>
		<?php } ?>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Nom</label>
			<div class="col-xs-11">
				<input class="form-control" id="nom" type="text" name="nom" value="<?= $anticorps['nom'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">No H2P2</label>
			<div class="col-xs-11">
				<input class="form-control" id="no_h2p2" type="text" name="no_h2p2" value="<?= $anticorps['no_h2p2'] ?>"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Fournisseur</label>
			<div class="col-xs-11">
				<input class="form-control" id="fournisseur" type="text" name="fournisseur" value="<?= $anticorps['fournisseur'] ?>"
				/>
			</div>
		</div>
		<br/>
		<!-- Source -->
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Source</label>
			<div class="col-xs-11">
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
			<label for="inputEmail" class="control-label col-xs-1">Référence</label>
			<div class="col-xs-11">
				<input class="form-control" id="reference" type="text" name="reference" value="<?= $anticorps['reference'] ?>"
				/>
			</div>
		</div>
				<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Clone</label>
			<div class="col-xs-11">
				<input class="form-control" id="clone" type="text" name="clone" value="<?= $anticorps['clone'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Lot</label>
			<div class="col-xs-11">
				<input class="form-control" id="lot" type="text" name="lot" value="<?= $anticorps['lot'] ?>"
				/>
			</div>
		</div>
		<br/>
		<!-- Isotype -->
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-1">Isotype</label>
			<div class="col-xs-11">
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
			<label for="inputEmail" class="control-label col-xs-1">Stockage</label>
			<div class="col-xs-11">
				<input class="form-control" id="stockage" type="text" name="stockage" value="<?= $anticorps['stockage'] ?>"
				/>
			</div>
		</div>
		
		<!--   TISSUS    -->
		<div class="form-group">
			<label class="control-label col-xs-1">Tissus</label>
			<div class="col-xs-11">
				<table id="dataTable" class="table table-striped">
				<thead>
					<tr>
						<td></td>
						<td style="min-width:10em;">Espece</td>
						<td style="min-width:10em;">Organe</td>
						<td style="min-width:10em;">Validé</td>
						<td style="min-width:10em;">Référence bloc</td>
						<td style="min-width:10em;">Prélèvement</td>
						<td style="min-width:10em;">Dilution</td>
						<!-- <td>Temps d'incubation</td>  -->
						<td style="min-width:10em;">Référence protoole</td>
					</tr>
				</thead>
					<tbody>
						<?php 
						foreach ($anticorps['tissus'] as $tissus){
													
							?>
							<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td>
									<select class="form-control" name="espece[]">
									<?php 
									$espaceid = $this->clean($tissus["espece_id"]);
									foreach ($especes as $espece){
										$ide = $this->clean($espece["id"]);
										$namee = $this->clean($espece["nom"]);
										$selected = "";
										if ($espaceid == $ide){
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?=$ide?>" <?=$selected?>> <?= $namee ?> </OPTION>
										<?php 
									}	
									?>
									</select>
								</td>
								<td>
									<select class="form-control" name="organe[]">
									<?php 
									$organe_id = $this->clean($tissus["organe_id"]);
									
									foreach ($organes as $organe){
										$ide = $this->clean($organe["id"]);
										$namee = $this->clean($organe["nom"]);
										$selected = "";
										if ($organe_id == $ide){
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?=$ide?>" <?=$selected?>> <?= $namee ?> </OPTION>
										<?php 
									}	
									?>
									</select>
								</td>
								<td><select class="form-control" name="status[]" >
								<option value="1" <?php if ($tissus["status"] == "1"){echo "selected=\"selected\"";}?>>Validé</option>
								<option value="2" <?php if ($tissus["status"] == "2"){echo "selected=\"selected\"";}?>>Non validé</option>
								<option value="3" <?php if ($tissus["status"] == "3"){echo "selected=\"selected\"";}?>>Non testé</option>
								</select></td>
								<td><input class="form-control" type="text" name="ref_bloc[]" value="<?= $tissus["ref_bloc"] ?>"/></td>
								<td>
									<select class="form-control" name="prelevement[]">
									<?php 
									$prelev = $this->clean($tissus["prelevement_id"]);
									foreach ($prelevements as $prelevement){
										$id_prelevement = $this->clean($prelevement["id"]);
										$nom_prelevement = $this->clean($prelevement["nom"]);
										$selected = "";
										if ($prelev == $id_prelevement){
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?=$id_prelevement?>" <?=$selected?>> <?= $nom_prelevement ?> </OPTION>
										<?php 
									}	
									?>
									</select>
								</td>
								<td><input class="form-control" type="text" name="dilution[]" value="<?= $tissus["dilution"] ?>"/></td>
								
								<!-- 
								<td><input class="form-control" type="text" name="temps_incubation[]" value="<?= $tissus["temps_incubation"] ?>"/></td>
								 -->
								
								<td>
									<select class="form-control" name="ref_protocol[]">
									<?php 
									$ref_proto = $this->clean($tissus["ref_protocol"]);
									foreach ($protocols as $protocol){
										$id_proto = $this->clean($protocol["id"]);
										$no_proto = $this->clean($protocol["no_proto"]);
										$selected = "";
										if ($ref_proto == $no_proto){
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?=$no_proto?>" <?=$selected?>> <?= $no_proto ?> </OPTION>
										<?php 
									}	
									?>
									</select>
								</td>
							</tr>
							<?php
						}
						?>
						<?php 
						if (count($anticorps['tissus']) < 1){
						?>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td>
								<select class="form-control" name="espece[]">
									<?php
									foreach ($especes as $espece){
										$ide = $this->clean($espece["id"]);
										$namee = $this->clean($espece["nom"]);
										?>
										<OPTION value="<?=$ide?>"> <?= $namee ?> </OPTION>
										<?php 
									}	
									?>
									</select>	
							</td>
							<td>
								<select class="form-control" name="organe[]">
									<?php 
									foreach ($organes as $organe){
										$ide = $this->clean($organe["id"]);
										$namee = $this->clean($organe["nom"]);
										?>
										<OPTION value="<?=$ide?>" > <?= $namee ?> </OPTION>
										<?php 
									}	
									?>
									</select>
							</td>
							<td><select class="form-control" name="status">
							<option value="1" >Validé</option>
							<option value="2" >Non validé</option>
							<option value="3" selected="selected">Non testé</option>
							
							</select></td>
							<td><input class="form-control" type="text" name="ref_bloc[]" /></td>
							<td>
								<select class="form-control" name="prelevement[]">
								<?php 
								foreach ($prelevements as $prelevement){
									$id_prelevement = $this->clean($prelevement["id"]);
									$nom_prelevement = $this->clean($prelevement["nom"]);
									?>
									<OPTION value="<?=$id_prelevement?>"> <?= $nom_prelevement ?> </OPTION>
									<?php 
								}	
								?>
								</select>
							</td>
							<td><input class="form-control" type="text" name="dilution[]" /></td>
							<!-- 
							<td><input class="form-control" type="text" name="temps_incubation[]" /></td>
							 -->
							<td>
								<select class="form-control" name="ref_protocol[]">
									<?php 
									foreach ($protocols as $protocol){
										$no_proto = $this->clean($protocol["no_proto"]);
										$idproto = $this->clean($protocol["id"]);
										?>
										<OPTION value="<?=$no_proto?>"> <?= $no_proto ?> </OPTION>
										<?php 
									}	
									?>
								</select>
							</td>
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
			
		<!-- ADD HERE PROPRIO ADD  -->
		<div class="form-group">
			<label class="control-label col-xs-1">Propriétaire</label>
			<div class="col-xs-11">
				<table id="proprioTable" class="table table-striped">
					<thead>
						<tr>
							<td></td>
							<td>Propriétaire</td>
							<td>Disponibilité</td>
							<td>Date réception</td>
							<td>No Dossier</td>
						</tr>
					</thead>
					<tbody>
						
							<?php 
							foreach ($anticorps['proprietaire'] as $proprio){
								
								//print_r($proprio);
								?>
								<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td>
									<select class="form-control" name="id_proprietaire[]">
									<?php 
									
									$pid = $this->clean($proprio["id_user"]);
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
								<td>
									<select class="form-control" name="disponible[]">
										<OPTION value="1" <?php if ($proprio["disponible"] == 1){echo "selected=\"selected\"";}?>> disponible </OPTION>
										<OPTION value="2" <?php if ($proprio["disponible"] == 2){echo "selected=\"selected\"";}?>> épuisé </OPTION>
										<OPTION value="3" <?php if ($proprio["disponible"] == 3){echo "selected=\"selected\"";}?>> récupéré par équipe </OPTION>
									</select>	
								</td>
								<td>
									<input class="form-control" type="text" name="date_recept[]" value="<?= CoreTranslator::dateFromEn($proprio["date_recept"], $lang) ?>"/>	
								</td>
								<td>
									<input class="form-control" type="text" name="no_dossier[]" value="<?= CoreTranslator::dateFromEn($proprio["no_dossier"], $lang) ?>"/>	
								</td>
								<tr />
							<?php
							} 
							?>	
							<?php 
							if(count($anticorps['proprietaire']) < 1){
							?>
								<tr>
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
								<td>
									<select class="form-control" name="disponible[]">
										<OPTION value="1"> disponible </OPTION>
										<OPTION value="2"> épuisé </OPTION>
										<OPTION value="3"> récupéré par équipe </OPTION>
									</select>	
								</td>
								<td>
									<input class="form-control" type="text" name="date_recept[]" />
								</td>
								<td>
									<input class="form-control" type="text" name="no_dossier[]"/>	
								</td>
								<tr />
							<?php	
							}
							?>
				
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
		
		<!-- Date Reception 
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2">Date Reception</label>
			<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="date_recept" value="<?= CoreTranslator::dateFromEn($anticorps['date_recept'], $lang) ?>"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		        <script src="externals/datepicker/js/moments.js"></script>
				<script src="externals/jquery-1.11.1.js"></script>
				<script src="externals/datepicker/js/bootstrap-datetimepicker.min.js"></script>
	      		<script type="text/javascript">
				$(function () {
					$('#datetimepicker5').datetimepicker({
						pickTime: false
					});
				});
			    </script>
		    </div>
		</div>
		-->
		
		<!-- Buttons -->
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Edit" />
		        <?php if($anticorps['id'] != ""){ ?>
		        	<button type="button" onclick="location.href='<?="anticorps/delete/".$anticorps['id'] ?>'" class="btn btn-danger">Supprimer</button>
				<?php }?>
				<button type="button" onclick="location.href='anticorps'" class="btn btn-default">Annuler</button>
		</div>
      </form>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
