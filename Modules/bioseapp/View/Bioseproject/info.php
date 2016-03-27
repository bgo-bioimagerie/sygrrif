<?php $this->title = "sprojects" ?>

<?php echo $navBar ?>
<?php include "Modules/bioseapp/View/Bioseproject/tabs.php"; ?>

<head>

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
                    case "text":
                        newcell.childNodes[0].value = "";
                        break;
                    case "date":
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



<div class="col-md-12">
    <form role="form" class="form-horizontal" action="bioseproject/infoquery"
          method="post">

        <div class="page-header col-md-12">
            <div class="col-xs-10">
                <h1>
                    <?php
                    echo BiTranslator::ProjectInfo($lang);
                    $projectID = 0;
                    if ($this->clean($project["id"]) == "") {
                        $buttonName = BiTranslator::Next($lang);
                        
                    } else {
                        $buttonName = CoreTranslator::Save($lang);
                        $projectID = $this->clean($project["id"]);
                    }
                    ?>	
                </h1>
            </div>
        </div>

        <div class="col-xs-10 col-xs-offset-2">
            <div class="page-header">
                <h3>
                    <?php echo BiTranslator::Description($lang) ?>
                    <br> <small></small>
                </h3>
            </div>
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
                    <label class="control-label col-xs-4"><?php echo CoreTranslator::Name($lang) ?></label>
                    <div class="col-xs-8">
                        <input class="form-control" id="id" type="text"  name="name" value="<?php echo $this->clean($project["name"]) ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-4"><?php echo CoreTranslator::Description($lang) ?></label>
                    <div class="col-xs-8">
                        <textarea class="form-control" name="description"><?php echo $this->clean($project["desc"]) ?></textarea>
                    </div>
                </div>
                <!--
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
                -->
                
            </div>
        </div>

         <div class="col-xs-10 col-xs-offset-2">
        <div class="page-header">
            <h3>
                    <?php echo BiTranslator::Indexation($lang) ?>
                <br> <small></small>
            </h3>
        </div>
        </div>

        <div class="col-xs-8 col-xs-offset-2">
        <!--  add here the order list -->
        <table id="dataTable" class="table table-striped">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo BiTranslator::key($lang) ?></td>
                    <td><?php echo BiTranslator::values($lang) ?></td>
                </tr>
            </thead>
            <tbody>
                    <?php
                    foreach ($tags as $tag) {
                        ?>
                    <tr>
                        <td style="width:7px;"><input type="checkbox" name="chk" /></td>
                        <td style="width:1px;"><input style="width:0px; margin-left:-50px;" type="hidden" name="tag_id[]" value="<?php echo $tag["id"] ?>"/>
                        </td>					
                        <td><input  class="form-control" type="text" name="item_name[]" value="<?php echo $tag['name'] ?>" required/></td>
                        <td><input  class="form-control" type="text" name="item_content[]" value="<?php echo $tag['content'] ?>" required/></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (count($tags) < 1) {
                    ?>
                     <tr>
                        <td style="width:7px;"><input type="checkbox" name="chk" /></td>
                        <td style="width:1px;"><input style="width:0px; margin-left:-50px;" type="hidden" name="tag_id[]" value=""/>
                        </td>					
                        <td><input class="form-control" type="text" name="item_name[]" value="" required/></td>
                        <td><input class="form-control" type="text" name="item_content[]" value="" required/></td>
                    </tr>
    <?php
}
?>
            </tbody>
        </table>
     
        <div class="col-md-6">
            <input type="button" class="btn btn-default" value="<?php echo CoreTranslator::Add($lang) ?>"
                   onclick="addRow('dataTable')" /> 
            <input type="button" class="btn btn-default" value="<?php echo CoreTranslator::Delete($lang) ?>"
                   onclick="deleteRow('dataTable')" /> <br>
        </div>
   </div>
        <div class="col-xs-3 col-xs-offset-9" id="button-div">
            <input type="submit" class="btn btn-primary" value="<?php echo $buttonName ?>" />
            <button type="button" onclick="location.href = 'bioseproject'" class="btn btn-default"><?php echo CoreTranslator::Cancel($lang) ?></button>
        </div>
    </form>
</div>


<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
<?php endif;
