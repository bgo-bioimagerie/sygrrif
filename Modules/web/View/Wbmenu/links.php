<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>

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

    <style type="text/css">
        .box{
            display: none;
        }
    </style>

</head>
<?php include "Modules/web/View/webnavbar.php" ?>

<div class="col-xs-12">
    <!--   LINKS    -->
    <form role="form" class="form-horizontal" action="wbmenu/linksquery" method="post">
        <div class="page-header">
	<h1>
            <?php echo  WbTranslator::Links($lang) ?>
            <br> <small></small>
	</h1>
	</div>
    
    <div class="form-group">
        
        <div class="col-xs-12">
            <table id="dataTable" class="table table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td><?php echo WbTranslator::Name($lang) ?></td>
                        <td><?php echo WbTranslator::Url($lang) ?></td>
                        <td><?php echo WbTranslator::Display_order($lang) ?></td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($menuItems as $menuItem) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="chk" /></td>
                            <td><input class="form-control" type="text" name="name[]" value="<?php echo $menuItem["name"]?>" /></td>
                            <td><input class="form-control" type="text" name="url[]" value="<?php echo $menuItem["url"]?>" /></td>  
                            <td><input class="form-control" type="number" name="display_order[]" value="<?php echo $menuItem["display_order"]?>" /></td>  
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    if (count($menuItems) < 1) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="chk" /></td>
                            <td><input class="form-control" type="text" name="name[]" value="" /></td>
                            <td><input class="form-control" type="text" name="url[]" value="" /></td>  
                            <td><input class="form-control" type="number" name="display_order[]" value="1" /></td>  
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
    </div>
        
    <div class="col-xs-4 col-xs-offset-8" id="button-div">
        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang)?>" />
    </div>
        
</div>

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
    <?php
 endif;
