<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

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

<div class="col-xs-12">
    <form role="form" class="form-horizontal" action="ntgroups/editusersquery" method="post">
        <div class="page-header">
            <h1>
            <?php echo NtTranslator::Goup_users($lang) ?> <br> <small></small>
            </h1>
	</div>
        
        <input type="hidden" name="id_group" value="<?php echo  $anticorps['id'] ?>" />
        
        <!--   TISSUS    -->
	<div class="form-group">
            <div class="col-xs-12">
                <table id="dataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <td></td>
                            <td><?php echo CoreTranslator::User($lang) ?></td>
                            <td><?php echo NtTranslator::Role($lang) ?></td>
                        </tr>
                    </thead>
			<tbody>
			<?php 
			foreach ($groupUsers as $groupUser){
			?>
                            <tr>
				<td><input type="checkbox" name="chk" /></td>
				<td>
                                    <select class="form-control" name="id_user[]">
                                    <?php 
                                    $id_user = $this->clean($groupUser["id_user"]);
                                    foreach ($users as $user){
                                        $id_proto = $this->clean($user["id"]);
					$no_proto = $this->clean($user["name"] . " " . $user["firstname"]);
					$selected = "";
					if ($id_user == $id_proto){
                                            $selected = "selected=\"selected\"";
					}
                                        ?>
                                            <OPTION value="<?php echo $no_proto?>" <?php echo $selected?>> <?php echo  $no_proto ?> </OPTION>
                                    <?php 
                                    }	
                                    ?>
                                    </select>
				</td>
                                <td>
                                    <select class="form-control" name="id_role[]">
                                    <?php 
                                    $id_role = $this->clean($groupUser["id_role"]);
                                    foreach ($roles as $role){
                                        $id_proto = $this->clean($role["id"]);
					$no_proto = $this->clean($role["name"]);
					$selected = "";
					if ($id_role == $no_proto){
                                            $selected = "selected=\"selected\"";
					}
                                        ?>
                                            <OPTION value="<?php echo $no_proto?>" <?php echo $selected?>> <?php echo  $no_proto ?> </OPTION>
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
                                    <select class="form-control" name="id_user[]">
                                    <?php 
                                    foreach ($users as $user){
                                        $id_proto = $this->clean($user["id"]);
					$no_proto = $this->clean($user["name"] . " " . $user["firstname"]);
                                    ?>
                                        <OPTION value="<?php echo $no_proto?>" <?php echo $selected?>> <?php echo  $no_proto ?> </OPTION>
                                    <?php 
                                    }	
                                    ?>
                                    </select>
				</td>
                                <td>
                                    <select class="form-control" name="id_role[]">
                                    <?php 
                                    $id_role = $this->clean($groupUser["id_role"]);
                                    foreach ($roles as $role){
                                        $id_proto = $this->clean($role["id"]);
					$no_proto = $this->clean($role["name"]);
                                        ?>
                                        <OPTION value="<?php echo $no_proto?>" <?php echo $selected?>> <?php echo  $no_proto ?> </OPTION>
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
        
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
