<?php $this->title = "Platform-Manager" ?>

<?php echo $navBar ?>
<?php include "Modules/petshop/View/petshopnavbar.php"; ?>

<head>
    <script src="externals/jquery-1.11.1.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet">
    <script>
        function addRow(tableID) {

            var idx = 1;
            if (tableID == "dataTable") {
                idx = 1;
            }
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            //document.write(rowCount);
            var row = table.insertRow(rowCount);
            //document.write(row);
            var colCount = table.rows[idx].cells.length;
            //document.write(colCount);

            for (var i = 0; i < colCount; i++) {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[idx].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch (newcell.childNodes[0].type) {
                    case "date":
                        newcell.childNodes[0].value = "";
                        break;
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
                if (tableID == "dataTable") {
                    idx = 2;
                }
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;

                for (var i = 0; i < rowCount; i++) {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    if (null != chkbox && true == chkbox.checked) {
                        if (rowCount <= idx) {
                            alert("Cannot delete all the rows.");
                            break;
                        }
                        table.deleteRow(i);
                        rowCount--;
                        i--;
                    }
                }
            } catch (e) {
                alert(e);
            }
        }

    </script>
    
    <style>
        select {
-moz-appearance: none;
background: rgba(0, 0, 0, 0) url("Themes/dropdown.png") no-repeat scroll 100% center / 20px 13px !important;
border: 1px solid #ccc;
overflow: hidden;
padding: 6px 20px 6px 6px !important;
width: auto;
}
    </style>
</head>


<br>
<div class="container">
    <div class="col-lg-12">
        
        <div class="col-lg-10 col-lg-offset-1">
            <?php if ($message != ""): 
                ?>
                    <div class="alert alert-success text-center">	
                <?php 
            ?>
            <p><?php echo  $message ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
	<div class="col-md-12">
	<form role="form" class="form-horizontal" action="psanimals/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo PsTranslator::InformationsAnimal($lang) ?>
				<br> <small></small>
			</h1>
		</div>

	<div class="form-group">
	    <label for="inputEmail" class="control-label col-xs-2">ID</label>
	    <div class="col-xs-10">
	        <input type="text" class="form-control" id="address" name="id"
	               value="<?= $animal['id'] ?>" readonly>
	    </div>
	</div>

	<div class="form-group">
            <label for="inputEmail" class="control-label col-xs-2"><?php echo PsTranslator::NoAnimal($lang) ?></label>
	    <div class="col-xs-10">
	        <input type="text" class="form-control" id="address" name="no_animal"
	               value="<?= $animal['no_animal'] ?>">
	    </div>
	</div>
	
	<div class="form-group">
            <label class="control-label col-xs-2"><?php echo PsTranslator::Sector($lang) ?></label>
    	<div class="col-xs-10">
        <table id="dataTable" class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th style="min-width:10em;"><?php echo PsTranslator::Sector($lang) ?></th>
                <th style="min-width:10em;"><?php echo PsTranslator::DateEntry($lang) ?></th>
                <th style="min-width:10em;"><?php echo PsTranslator::ExitDate($lang) ?></th>
                <th style="min-width:10em;"><?php echo CoreTranslator::Unit($lang) ?></th>
                <th style="min-width:10em;"><?php echo PsTranslator::NoRoom($lang) ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (count($animal['hist']) >= 1){
            	foreach($animal['hist'] as $hist){
                ?>
                <tr>
                    <td><input type="checkbox" name="chk"/></td>
                    <td>
                        <select class="form-control" name="sector[]">
                            <?php
                            $sectorid = $this->clean($hist["id_sector"]);
                            foreach ($sectors as $secteur) {
                                $ide = $this->clean($secteur["id"]);
                                $namee = $this->clean($secteur["name"]);
                                $selected = "";
                                if ($sectorid == $ide) {
                                    $selected = "selected=\"selected\"";
                                }
                                ?>
                                <OPTION value="<?= $ide ?>" <?= $selected ?>> <?= $namee ?> </OPTION>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td><input class="form-control" type="date" name="date_entry_sect[]" value="<?= $hist['date_entry'] ?>"></td>
                    <td><input class="form-control" type="date" name="date_exit_sect[]" value="<?= $hist['date_exit'] ?>"></td>
                    <td>
                    	<select class="form-control" name="unit_hist[]">
                            <?php
                            $secteurid = $this->clean($hist["id_unit"]);
                            foreach ($units as $eq) {
                                $ide = $this->clean($eq["id"]);
                                $namee = $this->clean($eq["name"]);
                                $selected = "";
                                if ($secteurid == $ide) {
                                    $selected = "selected=\"selected\"";
                                }
                                ?>
                                <OPTION value="<?= $ide ?>" <?= $selected ?>> <?= $namee ?> </OPTION>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td><input class="form-control" type="date" name="no_room[]" value="<?= $hist['no_room'] ?>"></td>
                    
                </tr>
            <?php
            	}
            }
            ?>
            </tbody>
        </table>
        <div class="col-md-6">
            <input type="button" class="btn btn-default" value="<?php echo PsTranslator::AddSector($lang) ?>"
                   onclick="addRow('dataTable')"/>
            <input type="button" class="btn btn-default" value="<?php echo PsTranslator::RemoveSector($lang) ?>"
                   onclick="deleteRow('dataTable')"/> <br>
        </div>
    </div>
    
    <div class="form-group">
    <p></p>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2"><?php echo PsTranslator::Project($lang) ?></label>
	    <div class="col-xs-10">
	    	<select class="form-control" name="id_project">
                        <?php
                        $projetID = $this->clean($animal["id_project"]);
                        foreach ($projects as $projet) {
                            $ide = $this->clean($projet["id"]);
                            $namee = $this->clean($projet["name"]);
                            $selected = "";
                            if ($projetID == $ide) {
                                $selected = "selected=\"selected\"";
                            }
                            ?>
                            <OPTION value="<?= $ide ?>" <?= $selected ?>> <?= $namee ?> </OPTION>
                        <?php
                        }
                        ?>
             </select>
	    </div>
	</div>
 
        <div class="form-group">
        <label class="control-label col-xs-2"><?php echo PsTranslator::DateEntry($lang) ?></label>
    	<div class="col-xs-10">
        <div class="col-xs-12 input-group date form_date_<?php echo $lang ?>">
        <input id="date-daily" type='text' class="form-control" name="date_entry" value="<?php echo $animal['date_entry'] ?>"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        </div>
        </div>    
            

	<div class="form-group">
            <label for="inputEmail" class="control-label col-xs-2"><?php echo PsTranslator::EntryReason($lang) ?></label>
	    <div class="col-xs-10">
	        <select class="form-control" name="entry_reason">
                        <?php
                        $entryReasonId = $this->clean($animal["entry_reason"]);
                        foreach ($entryReasons as $entryReason) {
                            $ide = $this->clean($entryReason["id"]);
                            $namee = $this->clean($entryReason["name"]);
                            $selected = "";
                            if ($entryReasonId == $ide) {
                                $selected = "selected=\"selected\"";
                            }
                            ?>
                            <OPTION value="<?= $ide ?>" <?= $selected ?>> <?= $namee ?> </OPTION>
                        <?php
                        }
                        ?>
             </select>
	    </div>
	</div>

	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Lineage($lang) ?></label>
	    <div class="col-xs-10">
	        <input type="text" class="form-control" id="date_arrive" name="lineage"
	               value="<?= $animal['lineage'] ?>">
	    </div>
	</div>
	
        <div class="form-group">
            <label class="control-label col-xs-2"><?php echo PsTranslator::BirthDate($lang) ?></label>
    	<div class="col-xs-10">
        <div class="col-xs-12 input-group date form_date_<?php echo $lang ?>">
        <input id="date-daily" type='text' class="form-control" name="birth_date" value="<?php echo $animal['birth_date'] ?>"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        </div>
        </div> 
	
	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Father($lang) ?></label>
	    <div class="col-xs-10">
	        <input type="text" class="form-control" id="date_arrive" name="father"
	               value="<?= $animal['father'] ?>">
	    </div>
	</div>

	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Mother($lang) ?></label>
            <div class="col-xs-10">
                    <input type="text" class="form-control" id="date_arrive" name="mother"
                       value="<?= $animal['mother'] ?>">
            </div>
	</div>
	
	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Sexe($lang) ?></label>
	    <div class="col-xs-10">
	    <select class="form-control" name="sexe">
        	<OPTION value="1" <?php if ($animal['sexe'] == "M"){echo "selected=\"selected\"";}?>> M </OPTION>
        	<OPTION value="2" <?php if ($animal['sexe'] == "F"){echo "selected=\"selected\"";}?>> F </OPTION>
        </select>
        </div>
    </div>

	<div class="form-group">
            <label class="control-label col-xs-2"><?php echo PsTranslator::Genotype($lang) ?></label>
    	<div class="col-xs-10">
        	<input type="text" class="form-control" id="date_arrive" name="genotypage"
            	   value="<?= $animal['genotypage'] ?>">
    	</div>
	</div>

	<div class="form-group">
            <label class="control-label col-xs-2"><?php echo PsTranslator::Supplier($lang) ?></label>
    	<div class="col-xs-10">
        	<select class="form-control" name="supplier">
            	<?php foreach ($suppliers as $fournisseur){ ?>
                	<?php 
                		$fournisseurname = $this->clean($fournisseur['name']);
                		$fournisseurid = $this->clean($fournisseur['id']);
                		$selected = "";
                		if ($animal["supplier"] == $fournisseurid){
                			$selected = "selected=\"selected\"";
                		}
                	?>
                <OPTION value="<?= $fournisseurid ?>" <?= $selected?> > <?= $fournisseurname ?> </OPTION>
            	<?php } ?>
        	</select>
    	</div>
	</div>
	
        <div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Collaboration($lang) ?></label>
            <div class="col-xs-10">
                <input type="texte" class="form-control" id="collaboration" name="collaboration"
                 value="<?= $animal['collaboration'] ?>">
            </div>
        </div>
			
	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Num_bon($lang) ?></label>
    	<div class="col-xs-10">
        	<input type="texte" class="form-control" id="address" name="num_bon"
            	   value="<?= $animal['num_bon'] ?>">
    	</div>
	</div>

	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo CoreTranslator::User($lang) ?> 1</label>
   	 	<div class="col-xs-10">
   	 		<select class="form-control" name="user1">
                            <?php foreach ($users as $user){?>
                                <?php 
								$username = $this->clean( $user['name'] . " " . $user["firstname"] );
								$userid = $this->clean( $user['id'] );
								$selected = "";
								if ($animal["user1"] == $userid){
									$selected = "selected=\"selected\"";
								}
                                ?>
                                <OPTION value="<?= $userid ?>" <?= $selected ?>> <?= $username ?> </OPTION>
                            <?php } ?>
            	</select>
    	</div>
	</div>
	
        <div class="form-group">
	    <label for="text" class="control-label col-xs-2"><?php echo CoreTranslator::User($lang) ?> 2</label>
   	 	<div class="col-xs-10">
   	 		<select class="form-control" name="user2">
                            <?php foreach ($users as $user){?>
                                <?php 
								$username = $this->clean( $user['name'] . " " . $user["firstname"] );
								$userid = $this->clean( $user['id'] );
								$selected = "";
								if ($animal["user2"] == $userid){
									$selected = "selected=\"selected\"";
								}
                                ?>
                                <OPTION value="<?= $userid ?>" <?= $selected ?>> <?= $username ?> </OPTION>
                            <?php } ?>
            	</select>
    	</div>
	</div>

        <div class="form-group">
            <label class="control-label col-xs-2"><?php echo PsTranslator::ExitDate($lang) ?></label>
    	<div class="col-xs-10">
        <div class="col-xs-12 input-group date form_date_<?php echo $lang ?>">
        <input id="date-daily" type='text' class="form-control" name="date_exit" value="<?php echo $animal['date_exit'] ?>"/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        </div>
        </div>
        
	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::ExitReason($lang) ?> </label>
    	<div class="col-xs-10">
        	<input type="text" class="form-control" id="date_arrive" name="exit_reason"
       	    	    value="<?= $animal['exit_reason'] ?>">
  		 </div>
	</div>

	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Observation($lang) ?></label>
    	<div class="col-xs-10">
        	<textarea type="texte" class="form-control" id="date_arrive" name="observation"
            	      ><?= $animal['observation'] ?></textarea>
    	</div>
	</div>
	
	<div class="form-group">
            <label for="text" class="control-label col-xs-2"><?php echo PsTranslator::Avertissement($lang) ?></label>
    	<div class="col-xs-10">
        	<textarea type="text" class="form-control" id="date_arrive" name="avertissement"
            	      ><?= $animal['avertissement'] ?></textarea>
    	</div>
	</div>

	<div class="col-xs-2 col-xs-offset-10" id="button-div">
            <input type="submit" class="btn btn-primary" value="<?php echo CoreTranslator::Save($lang) ?>"/>
	</div>    

</form>
</div> <!-- col 6 -->
</div> <!-- container -->

<?php include "Framework/timepicker_script.php"; ?>

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
