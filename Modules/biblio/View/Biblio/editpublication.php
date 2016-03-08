<?php $this->title = "Biblio: Edit publication"?>

<?php echo $navBar?>
<?php include "Modules/biblio/View/navbar.php"; ?>

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

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	  <form role="form" class="form-horizontal" action="biblio/editpublicationquery" method="post"
	        enctype="multipart/form-data">
		
		<input class="form-control" id="nom" type="hidden" name="type_name" value="<?php echo $this->clean($pubicationInfos["type_name"])?>"
				 />
				
		<div class="page-header">
			<h1>
				<?php 
				echo "Edit " .$this->clean($pubicationInfos["type_name"]);
				?>
				<br> <small></small>
			</h1>
		</div>
		
		<!-- ID -->
		<?php 
		if (isset($pubicationInfos["id"])){
			$entry_id = $this->clean($pubicationInfos["id"]);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="id" value="<?php echo $entry_id?>"
				 readonly/>
			</div>
		</div>
		<?php } ?>
		<!-- Title -->
		<?php 
		if (isset($pubicationInfos["title"])){
			$title = $this->clean($pubicationInfos["title"]);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Title</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="title" value="<?php echo $title?>"
				 />
			</div>
		</div>
		<?php } ?>

		<!-- Chapter -->
		<?php 
		if (isset($pubicationInfos["chapter"])){
			$chapter = $this->clean($pubicationInfos["chapter"]);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Chapter</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="chapter" value="<?php echo $chapter?>"
				 />
			</div>
		</div>
		<?php } ?>
		
		<!-- Author -->
		<div class="form-group">
			<label class="control-label col-xs-2">Authors</label>
			<div class="col-xs-10">
					<table id="dataTable" class="table table-striped">
					<thead>
						<tr>
							<td></td>
							<td>Name</td>
							<td>Firstname</td>
							<td>Or</td>
							<td>Select</td>
						</tr>
					</thead>
					<tbody>
						<?php 
						if ( isset($pubicationInfos['authors_id']) ){
							$authors_id = $pubicationInfos['authors_id'];
							foreach ($authors_id as $curentAuthor){
								?>
								<tr>
								<td><input type="checkbox" name="chk" /></td>
								<td><input class="form-control" type="text" name="auth_name[]" /></td>
						    	<td><input class="form-control" type="text" name="auth_firstname[]" /></td>
						    	<td>or</td>
						    	<td>
						    	<select class="form-control" name="auth_id[]">
									<OPTION value="0" >  </OPTION>
									<?php 
									foreach ($authors as $author){
										$Aid = $this->clean($author['id']);
										$Aname = $this->clean($author['name']) . " " . $this->clean($author['firstname']);
										$selected = "";
										if ($curentAuthor['id_author'] == $Aid){
											echo "set selected " . $Aid . "</br>";
											$selected = "selected=\"selected\"";
										}
										?>
										<OPTION value="<?php echo $Aid?>" <?php echo $selected?> > <?php echo $Aname?> </OPTION>
									<?php 	
							    	}?>
								</select>
						   		</td>
								</tr>
								<?php
							}
						}
						else{
						?>
						<tr>
							<td><input type="checkbox" name="chk" /></td>
							<td><input class="form-control" type="text" name="auth_name[]" /></td>
						    <td><input class="form-control" type="text" name="auth_firstname[]" /></td>
						    <td>or</td>
						    <td>
						    <select class="form-control" name="auth_id[]">
								<OPTION value="0" >  </OPTION>
								<?php 
								foreach ($authors as $author){
									$Aid = $this->clean($author['id']);
									$Aname = $this->clean($author['name']) . " " . $this->clean($author['firstname']);
									?>
									<OPTION value="<?php echo $Aid?>"> <?php echo $Aname?> </OPTION>
									<?php 
							    }?>
							</select>
						    </td>
						</tr>
						<?php }?>
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
		
		<!-- Journal -->
		<?php 
		if (isset($pubicationInfos['journal_id'])){
			$journal_id = $this->clean($pubicationInfos['journal_id']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Journal</label>
			<div id="the-basics" class="col-xs-10">
			    <label for="inputEmail" class="control-label col-xs-2">Name</label>
			    <div id="the-basics" class="col-xs-10">
				<input class="form-control typeahead" type="text" name="journal"/>
				</div>
				<label for="inputEmail" class="control-label col-xs-2">Or select</label>
				<div id="the-basics" class="col-xs-10">
				<select class="form-control" name="journal_id">
					<OPTION value="0" >  </OPTION>
					<?php
					foreach ($journals as $journal){
 						$Jid = $this->clean($journal['id']);
 						$Jname = $this->clean($journal['name']);
 						$selected = "";
 						if ($journal_id == $Jid){
 							$selected = "selected=\"selected\"";	
 						}
 						?>
 						<OPTION value="<?php echo $Jid?>" <?php echo $selected?>> <?php echo $Jname?> </OPTION>	
 						<?php 	
					}
					?>			
				</select>
				</div>
			</div>
		</div>
		<?php }?>
		
		
		<!-- Conference -->
		<?php 
		if (isset($pubicationInfos['conference_id'])){
			$conference_id = $this->clean($pubicationInfos['conference_id']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Conference</label>
			<div id="the-basics" class="col-xs-10">
			    <label for="inputEmail" class="control-label col-xs-2">Name</label>
			    <div id="the-basics" class="col-xs-10">
				<input class="form-control typeahead" type="text" name="conference"/>
				</div>
				<label for="inputEmail" class="control-label col-xs-2">Or select</label>
				<div id="the-basics" class="col-xs-10">
				<select class="form-control" name="conference_id">
					<OPTION value="0" >  </OPTION>
					<?php
					foreach ($conferences as $conf){
 						$Cid = $this->clean($conf['id']);
 						$Cname = $this->clean($conf['name']);
 						$selected = "";
 						if ($conference_id == $Cid){
 							$selected = "selected=\"selected\"";
 						}
 						?>
 						<OPTION value="<?php echo $Cid?>" <?php echo $selected?>> <?php echo $Cname?> </OPTION>	
 						<?php 	
					}
					?>			
				</select>
				</div>
			</div>
		</div>
		<?php }?>
		
		<!-- month -->
		<?php 
		if (isset($pubicationInfos['month'])){
			$month = $this->clean($pubicationInfos['month']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Month</label>
			<div class="col-xs-10">
				<select class="form-control" name="month">
					<OPTION value="0" if >  </OPTION>
					<OPTION value="1" <?php if ($month==1){echo "selected=\"seleced\"";}?>> January </OPTION>
					<OPTION value="2" <?php if ($month==2){echo "selected=\"seleced\"";}?>> February </OPTION>
					<OPTION value="3" <?php if ($month==3){echo "selected=\"seleced\"";}?>> March  </OPTION>
					<OPTION value="4" <?php if ($month==4){echo "selected=\"seleced\"";}?>>  April </OPTION>
					<OPTION value="5" <?php if ($month==5){echo "selected=\"seleced\"";}?>> May </OPTION>
					<OPTION value="6" <?php if ($month==6){echo "selected=\"seleced\"";}?>> June </OPTION>
					<OPTION value="7" <?php if ($month==7){echo "selected=\"seleced\"";}?>> July </OPTION>
					<OPTION value="8" <?php if ($month==8){echo "selected=\"seleced\"";}?>> August  </OPTION>
					<OPTION value="9" <?php if ($month==9){echo "selected=\"seleced\"";}?>> September </OPTION>
					<OPTION value="10" <?php if ($month==10){echo "selected=\"seleced\"";}?>> October </OPTION>
					<OPTION value="11" <?php if ($month==11){echo "selected=\"seleced\"";}?>> November </OPTION>
					<OPTION value="12" <?php if ($month==12){echo "selected=\"seleced\"";}?>> December </OPTION>
				</select>
			</div>
		</div>
		<?php }?>
		
		<!-- year -->
		<?php 
		if (isset($pubicationInfos['year'])){
			$year = $this->clean($pubicationInfos['year']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Year</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="number" name="year" value="<?php echo $year?>"
				 />
			</div>
		</div>
		<?php }?>
		
		
		<!-- publisher -->
		<?php 
		if (isset($pubicationInfos['publisher'])){
			$publisher = $this->clean($pubicationInfos['publisher']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Publisher</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="publisher" value="<?php echo $publisher?>"
				 />
			</div>
		</div>
		<?php }?>
		
		<!-- edition -->
		<?php 
		if (isset($pubicationInfos['edition'])){
			$edition = $this->clean($pubicationInfos['edition']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Edition</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="edition" value="<?php echo $edition?>"
				 />
			</div>
		</div>
		<?php }?>
		
		
		<!-- series -->
		<?php 
		if (isset($pubicationInfos['series'])){
			$series = $this->clean($pubicationInfos['series']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Series</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="series" value="<?php echo $series?>"
				 />
			</div>
		</div>
		<?php }?>
		
		<!-- address -->
		<?php 
		if (isset($pubicationInfos['address'])){
			$address = $this->clean($pubicationInfos['address']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Addresss</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="address" value="<?php echo $address?>"
				 />
			</div>
		</div>
		<?php }?>

	  	<!-- volume -->
		<?php 
		if (isset($pubicationInfos['volume'])){
			$volume = $this->clean($pubicationInfos['volume']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Volume</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="volume" value="<?php echo $volume?>"
				 />
			</div>
		</div>
		<?php }?>
		
		<!-- pages -->
		<?php 
		if (isset($pubicationInfos['pages'])){
			$pages = $this->clean($pubicationInfos['pages']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Pages</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="pages" value="<?php echo $pages?>"
				 />
			</div>
		</div>
		<?php }?>
		
		
			
		<!-- isbn -->
		<?php 
		if (isset($pubicationInfos['isbn'])){
			$isbn = $this->clean($pubicationInfos['isbn']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">isbn</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="isbn" value="<?php echo $isbn?>"
				 />
			</div>
		</div>
		<?php }?>		
		
		<!-- howpublished -->
		<?php 
		if (isset($pubicationInfos['howpublished'])){
			$howpublished = $this->clean($pubicationInfos['howpublished']);
		?>
	  	<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">How published</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="howpublished" value="<?php echo $howpublished?>"
				 />
			</div>
		</div>
		<?php }?>
		
		<!-- note -->
		<?php 
		if (isset($pubicationInfos['note'])){
			$note = $this->clean($pubicationInfos['note']);
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Note</label>
			<div class="col-xs-10">
				<textarea class="form-control" id="nom" type="text" name="note" ><?php echo $note?></textarea>
			</div>
		</div>
		<?php }?>

		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">File</label>
			<div class="col-xs-10">
				<input type="file" name="fileToUpload" id="fileToUpload">
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='biblio'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
