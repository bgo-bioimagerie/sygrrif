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
    <form role="form" class="form-horizontal" action="wbarticleslistadmin/editquery" method="post">
        <div class="page-header">
	<h1>
            <?php echo  WbTranslator::EditArticlesList($lang) ?>
            <br> <small></small>
	</h1>
	</div>
        
        <input type="hidden" name="id" value="<?php echo $articleListInfo["id"] ?>" >
        <div class="form-group">
            <label class="control-label col-xs-2"><?php echo  WbTranslator::Title($lang) ?></label>
            <div class="col-xs-10">
                <input class="form-control" id="firstname" type="text" name="title" required
                       value="<?php echo $articleListInfo["title"] ?>"/>
            </div>
        </div>
	<br/>
        <div class="form-group">
            <label class="control-label col-xs-2"><?php echo  WbTranslator::parent_menu($lang) ?></label>
            <div class="col-xs-10">
                <select class="form-control" name="id_parent_menu">
                    <OPTION value="0" > -- </OPTION>
                               
		<?php foreach ($menus as $menu):?>
                    <?php $unitname = $this->clean( $menu['title'] );
                          $unitId = $this->clean( $menu['id'] );
                          $selected = "";
                          if ($articleListInfo["id_parent_menu"] == $unitId){
                              $selected = "selected=\"selected\"";
                          }
                    ?>
                    <OPTION value="<?php echo $unitId ?>" <?php echo $selected ?> > <?php echo  $unitname ?> </OPTION>
		<?php endforeach; ?>
		</select>
            </div>
	</div>
	<br/>
        <div class="form-group">
            <label class="control-label col-xs-2"><?php echo  WbTranslator::is_published($lang) ?></label>
            <div class="col-xs-10">
                <select class="form-control" name="is_published">
                    <OPTION value="0" <?php if ($articleListInfo["id_parent_menu"] == 0){echo "selected=\"selected\""; } ?> > <?php echo CoreTranslator::no($lang) ?> </OPTION>
                    <OPTION value="1" <?php if ($articleListInfo["id_parent_menu"] == 1){echo "selected=\"selected\""; } ?> > <?php echo CoreTranslator::yes($lang) ?> </OPTION>
		</select>
            </div>
	</div>        
              
    
    <div class="form-group">
        <label class="control-label col-xs-2"><?php echo  WbTranslator::Link($lang) ?></label>
            
        <div class="col-xs-10">
            <table id="dataTable" class="table table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td><?php echo WbTranslator::Articles($lang) ?></td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articleList as $articleL) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="chk" /></td>
                            <td>
                                <select class="form-control" name="articles_ids[]">
                                <?php foreach ($articles as $article):?>
                                    <?php $unitname = $this->clean( $article['title'] );
                                          $unitId = $this->clean( $article['id'] );
                                          $selected = "";
                                          if ($articleL["id"] == $unitId){
                                              $selected = "selected=\"selected\"";
                                          }
                                    ?>
                                    <OPTION value="<?php echo $unitId ?>" <?php echo $selected ?> > <?php echo  $unitname ?> </OPTION>
                                <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    if (count($articleList) < 1) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="chk" /></td>
                            <td>
                                <select class="form-control" name="articles_ids[]">
                                <?php foreach ($articles as $article):?>
                                    <?php $unitname = $this->clean( $article['title'] );
                                          $unitId = $this->clean( $article['id'] );
                                    ?>
                                    <OPTION value="<?php echo $unitId ?>"> <?php echo  $unitname ?> </OPTION>
                                <?php endforeach; ?>
                                </select>
                                
                            </td> 
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
