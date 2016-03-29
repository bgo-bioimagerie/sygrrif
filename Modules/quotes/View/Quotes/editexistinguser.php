<?php $this->title = "Platform-Manager"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>
</head>

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

<?php include "Modules/quotes/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="quotes/editquery"
		method="post">
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($entry["id"]) == ""){
				$buttonName = QoTranslator::Ok($lang);
				echo QoTranslator::NewQuote($lang);
			}
			else{
				$buttonName = CoreTranslator::Ok($lang);;
				echo QoTranslator::EditQuote($lang);
			}
				?>	
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			<?php echo  QoTranslator::Description($lang) ?>
				<br> <small></small>
			</h3>
		</div>
	
		<?php if ($this->clean($entry["id"]) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?php echo $this->clean($entry["id"]) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
                else{
                    ?>
                    <input class="form-control" type="hidden"  name="id" value="<?php echo $this->clean($entry["id"]) ?>"/>
			<?php	
                }
		?>
            
		<div class="form-group">
			<label class="control-label col-xs-4"><?php echo  CoreTranslator::User($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_user">
				<?php foreach($users as $user){ 
					$userid = $this->clean($user["id"]);
					$userName = $this->clean($user["name"] . " " . $user["firstname"]); 
					$selected = "";
					if ($userid == $this->clean($entry["id_user"])){
						$selected = "selected=\"selected\"";
					}
					?>
					<option value="<?php echo $userid ?>" <?php echo $selected ?>> <?php echo $userName ?> </option>
				<?php } ?>
				</select>
			</div>
		</div>
		
                
                <!--   CONTENT    -->
                
                <div class="page-header">
			<h3>
			<?php echo  QoTranslator::Presta($lang) ?>
				<br> <small></small>
			</h3>
		</div>
                
		
                <div class="form-group">
                    <div class="col-xs-12">
                        <table id="dataTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Prestation</td>
                                    <td>Quantité</td>
				</tr>
                            </thead>
                            <tbody>
                            <?php 
                            if (count($content) > 0){
                                foreach ($content as $key => $value){									
				?>
                                    <tr>
                                        <td><input type="checkbox" name="chk" /></td>
                                        <td>
                                        <select class="form-control" name="cid[]">   
                                            <?php foreach ($entryList as $entryK => $entryN):?>
                                            <?php   $respId = $this->clean( $entryK );
                                            $respSummary = $this->clean( $entryN );
						$selected = "";
                                                if ($respId == $key){
                                                            $selected = "selected=\"selected\"";
                                                    }    	
							?>
							<OPTION value="<?php echo  $respId ?>" <?php echo $selected ?> > <?php echo $respSummary ?> </OPTION>
							<?php endforeach; ?>
							</select>
                                        </td>
                                    <td>
                                            <input class="form-control" type="text" name="cvalue[]" value="<?php echo $value ?>">
					</td> 
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
                                        <select class="form-control" name="cid[]">   
					<?php foreach ($entryList as $key => $value):?>
                                            <?php   $respId = $this->clean( $key );
                                            $respSummary = $this->clean( $value );
						    	
							?>
							<OPTION value="<?php echo  $respId ?>"> <?php echo $respSummary ?> </OPTION>
							<?php endforeach; ?>
							</select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="cvalue[]"/>
                                    </td> 
				</tr>
				<?php 
				}
                                ?>
                            </tbody>
			</table>
		
				
				<div class="col-md-6">
					<input type="button" class="btn btn-default" value="<?php echo QoTranslator::Add($lang)?>"
						onclick="addRow('dataTable')" /> 
					<input type="button" class="btn btn-default" value="<?php echo QoTranslator::Remove($lang)?>"
						onclick="deleteRow('dataTable')" /> <br>
				</div>
			</div>
		</div>
                
   
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  $buttonName ?>" />
			<button type="button" onclick="location.href='quotes'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;

