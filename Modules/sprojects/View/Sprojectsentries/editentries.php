<?php $this->title = "sprojects" ?>

<?php echo $navBar ?>

<head>
    <style>
        #button-div{
            padding-top: 20px;
        }

    </style>

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
                
                switch (newcell.childNodes[0].type) {
                    case "text":
                        newcell.childNodes[0].value = '';
                        break;
                    case "date":
                        newcell.childNodes[0].value = '';
                        break;
                    case "hidden":
                        newcell.childNodes[0].value = '';
                        break;
                    case "checkbox":
                        newcell.childNodes[0].checked = false;
                        break;
                    case "select-one":
                        newcell.childNodes[0].selectedIndex = 1;
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

</head>

<?php include "Modules/sprojects/View/navbar.php"; ?>

<div class="col-md-12" style="margin-top: -50px">
    <form role="form" class="form-horizontal" action="sprojectsentries/editquery"
          method="post">

        <div class="page-header col-xs-12">
            <div class="col-xs-10">
                <h1>
                    <?php
                    $projectID = 0;
                    if ($this->clean($project["id"]) == "") {
                        $buttonName = CoreTranslator::Save($lang);

                        echo SpTranslator::Add_Order($lang);
                    } else {
                        $buttonName = CoreTranslator::Save($lang);
                        $projectID = $this->clean($project["id"]);
                        echo SpTranslator::Edit_Order($lang);
                    }
                    ?>	
                </h1>
            </div>
            <!--
            <div class="col-xs-2">

                <button type="button" onclick="location.href = 'sprojectsbill/<?php echo $projectID ?>'" class="btn btn-primary"><?php echo SpTranslator::Billit($lang) ?></button>
            </div>
            -->
        </div>

        <div class="page-header">
            <h3>
                <?php echo SpTranslator::Description($lang) ?>
                <br> <small></small>
            </h3>
        </div>

        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <?php if ($this->clean($project["id"]) != "") {
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
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo CoreTranslator::Responsible($lang) ?></label>
                    <div class="col-xs-8">
                        <select class="form-control" name="id_resp">
                            <?php
                            foreach ($responsibles as $user) {
                                $userid = $this->clean($user["id"]);
                                $userName = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]);
                                $selected = "";
                                if ($userid == $this->clean($project["id_resp"])) {
                                    $selected = "selected=\"selected\"";
                                }
                                ?>
                                <option value="<?php echo $userid ?>" <?php echo $selected ?>> <?php echo $userName ?> </option>
<?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::No_Projet($lang) ?></label>
                    <div class="col-xs-8">
                        <input class="form-control" id="id" type="text"  name="name" value="<?php echo $this->clean($project["name"]) ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo CoreTranslator::User($lang) ?></label>
                    <div class="col-xs-8">
                        <select class="form-control" name="id_user">
                            <?php
                            foreach ($users as $user) {
                                $userid = $this->clean($user["id"]);
                                $userName = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]);
                                $selected = "";
                                if ($userid == $this->clean($project["id_user"])) {
                                    $selected = "selected=\"selected\"";
                                }
                                ?>
                                <option value="<?php echo $userid ?>" <?php echo $selected ?>> <?php echo $userName ?> </option>
<?php } ?>
                        </select>
                    </div>
                </div>

                
                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::New_team($lang) ?></label>
                    <div class="col-xs-8">
                        <select class="form-control" name="new_team">
<?php
$selected = "selected=\"selected\"";
$newTeam = $this->clean($project["new_team"]);
?>
                            <option value="1" <?php if ($newTeam == 1) {
    echo $selected;
} ?>> <?php echo CoreTranslator::no($lang) ?>  </option>
                            <option value="2" <?php if ($newTeam == 2) {
    echo $selected;
} ?>> <?php echo SpTranslator::Academique($lang) ?> </option>
                            <option value="3" <?php if ($newTeam == 3) {
                                echo $selected;
                            } ?>> <?php echo SpTranslator::Industry($lang) ?> </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::New_project($lang) ?></label>
                    <div class="col-xs-8">
                        <select class="form-control" name="new_project">
<?php
$selected = "selected=\"selected\"";
$newTeam = $this->clean($project["new_project"]);
?>
                            <option value="1" <?php if ($newTeam == 1) {
    echo $selected;
} ?>> <?php echo CoreTranslator::no($lang) ?>  </option>
                            <option value="2" <?php if ($newTeam == 2) {
    echo $selected;
} ?>> <?php echo SpTranslator::Academique($lang) ?> </option>
                            <option value="3" <?php if ($newTeam == 3) {
    echo $selected;
} ?>> <?php echo SpTranslator::Industry($lang) ?> </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::Time_limite($lang) ?></label>
                    <div class="col-xs-8">
                        <input class="form-control" type="date"  name="time_limit" value="<?php echo $this->clean($project["time_limit"]) ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::Opened_date($lang) ?></label>
                    <div class="col-xs-8">
                        <input class="form-control" id="id" type="date"  name="date_open" value="<?php echo $this->clean($project["date_open"]) ?>" />
                    </div>
                </div>
                
                <?php if ($this->clean($project["id"]) != "") {
                    ?>
                <div class="form-group">
                    <label for="inputEmail" class="control-label col-xs-4"><?php echo SpTranslator::Closed_date($lang) ?></label>
                    <div class="col-xs-6">
                        <input class="form-control" id="id" type="date"  name="date_close" value="<?php echo $this->clean($project["date_close"]) ?>" />
                    </div>
                    <div class="col-xs-2">
                        <input type="submit" class="btn btn-primary" formaction="sprojectsentries/saveandbill" value="<?php echo SpTranslator::Billit($lang) ?>" />
                    </div>
                    
                </div>
                <?php }
                    ?>
            </div>
        </div>


     <?php if ($this->clean($project["id"]) != "") {
                    ?>   
        
        <div class="page-header">
            <h3>
                    <?php echo SpTranslator::Order($lang) ?>
                <br> <small></small>
            </h3>
        </div>
        <div class="col-md-2 col-md-offset-10">
            <button type="button" onclick="location.href = 'sprojectsentries/expoertxls/<?php echo $projectID ?>'" class="btn btn-primary"><?php echo SpTranslator::Export_csv($lang) ?></button>
        </div>

        <!--  add here the order list -->
        <div class="form-group">
                    <div class="col-xs-12">
                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><?php echo SpTranslator::Date($lang); ?> </td>
                                    <td><?php echo SpTranslator::Comment($lang); ?></td>
                                    <td><?php echo SpTranslator::Prestation($lang); ?></td>
                                    <td><?php echo SpTranslator::Quantity($lang); ?></td>
                                    <td><?php echo SpTranslator::invoiced($lang); ?></td>
				</tr>
                            </thead>
                            <tbody>
                            <?php 
                            if (count($projectEntries) > 0){
                                
                                foreach ($projectEntries as $projEntry){									
				?>
                                    <tr>
                                        <td><input type="checkbox" name="chk" /></td>
                                        <td><input type="date" class="form-control" name="cdate[]" value="<?php echo $projEntry['date'] ?>" ></td> 
                                        <td><input type="text" class="form-control" name="ccomment[]" value="<?php echo $projEntry["comment"] ?>" ></td>
					<td><select class="form-control" name="ciditem[]">   
                                            <?php foreach ($items as $item):?>
                                            <?php   $respId = $this->clean( $item['id'] );
                                            $respSummary = $this->clean( $item['name'] );
						$selected = "";
                                                if ($respId == $projEntry["id_item"]){
                                                            $selected = "selected=\"selected\"";
                                                    }    	
							?>
							<OPTION value="<?php echo  $respId ?>" <?php echo $selected ?> > <?php echo $respSummary ?> </OPTION>
							<?php endforeach; ?>
					</select></td>
                                        <td><input class="form-control" type="text" name="cquantity[]" value="<?php echo $projEntry["quantity"] ?>"></td>
					<td><select class="form-control" name="cinvoiceid[]">   
                                            <?php
                                            if ($projEntry["invoice_id"] > 0){
                                                ?>
                                                <OPTION value="<?php echo  $projEntry["invoice_id"] ?>" selected="selected" > <?php echo $projEntry["invoice"] ?> </OPTION>
                                                <OPTION value="0"> <?php echo SpTranslator::RemoveInvoice($lang) ?> </OPTION>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <OPTION value="0"> <?php echo SpTranslator::NotInvoiced($lang) ?> </OPTION>
                                                <?php
                                            }
                                            
                                            ?>
					</select></td>    
                                    </tr>  
                                <?php 
                                } 
                            }
                            else
                                {
				?>
                                <tr>
                                    <td><input type="checkbox" name="chk" /></td>
                                    <td>
                                        <input class="form-control" type="date" name="cdate[]"/>
                                    </td> 
                                     <td>
                                        <input class="form-control" type="text" name="ccomment[]" >
                                    </td>
                                    <td>
                                        <select class="form-control" name="ciditem[]">   
					<?php foreach ($items as $item):?>
                                            <?php   $respId = $this->clean( $item["id"] );
                                            $respSummary = $this->clean( $item["name"] );
						    	
                                            ?>
                                            <OPTION value="<?php echo  $respId ?>"> <?php echo $respSummary ?> </OPTION>
                                            <?php endforeach; ?>
					</select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="cquantity[]"/>
                                    </td> 
                                    <td>
                                        <input class="form-control" type="hidden" name="cinvoiceid[]" value=""/>
                                    <td/>    
				</tr>
				<?php 
				}
                                ?>
                            </tbody>
			</table>
		
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="<?php echo SpTranslator::Add($lang)?>"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="<?php echo SpTranslator::Remove($lang)?>"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
		</div>

        <?php
     }
        ?>
        <div class="col-xs-3 col-xs-offset-9" id="button-div">
            <input type="submit" class="btn btn-primary" value="<?php echo $buttonName ?>" />
            <button type="button" onclick="location.href = 'sprojectsentries'" class="btn btn-default"><?php echo CoreTranslator::Cancel($lang) ?></button>
        </div>
    </form>
</div>


<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
<?php endif;
