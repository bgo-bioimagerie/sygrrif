<?php $this->title = "SyGRRiF Statistics"?>

<?php echo $navBar?>

<head>
	<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="bootstrap/datepicker/js/moments.js"></script>
	<script src="bootstrap/jquery-1.11.1.js"></script>

<style>
#button-div{
	padding-top: 20px;
}

#camembert{
	border: 1px dashed #000;
}
</style>

</head>
	
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrif/statauthorizations"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h2>
				Statistics authorizations <br> <small></small>
			</h2>
		</div>
		
		<?php
		if ($errorMessage != ''){
			?>
			<div class="alert alert-danger">
				<p><?= $errorMessage ?></p>
			</div>
		<?php } ?>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2">Date Start</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_start" id="searchDate_start"
					       value="<?=$searchDate_start?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
			$(function () {
				$('#datetimepicker5').datetimepicker({
					pickTime: true
				});
			});
		    </script>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2">Date End</label>
				<div class="col-xs-10">
				<div class='input-group date' id='datetimepicker6'>
					<input id="test32" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_end" 
					       value="<?= $searchDate_end ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
      		<script type="text/javascript">
  			$(function () {
				$('#datetimepicker6').datetimepicker({
					pickTime: false
				});
			});
			</script>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">User</label>
			<div class="col-xs-10">
					<select class="form-control" name="user">
					<?php 
					foreach ($usersList as $user){
						$userId = $this->clean( $user['id'] );	
						$userName = $this->clean( $user['name'] . " " . $user['firstname']);
						$checked = "";
						if ($user_id == $userId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $userId?>" <?= $checked ?>> <?=$userName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Curent unit</label>
			<div class="col-xs-10">
					<select class="form-control" name="curentunit">
					<?php 
					foreach ($unitsList as $unit){
						$unitId = $this->clean( $unit['id'] );	
						$unitName = $this->clean( $unit['name'] );
						$checked = "";
						if ($curentunit_id == $unitId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $unitId?>" <?= $checked ?>> <?=$unitName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit at training time</label>
			<div class="col-xs-10">
					<select class="form-control" name="trainingunit">
					<?php 
					foreach ($unitsList as $unit){
						$unitId = $this->clean( $unit['id'] );	
						$unitName = $this->clean( $unit['name'] );
						$checked = "";
						if ($trainingunit_id == $unitId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $unitId?>" <?= $checked ?>> <?=$unitName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Visa</label>
			<div class="col-xs-10">
					<select class="form-control" name="visa">
					<?php 
					foreach ($visasList as $visa){
						$visaId = $this->clean( $visa['id'] );	
						$visaName = $this->clean( $visa['name'] );
						$checked = "";
						if ($visa_id == $visaId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $visaId ?>" <?= $checked ?>> <?= $visaName ?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Resource</label>
			<div class="col-xs-10">
					<select class="form-control" name="resource">
					<OPTION value="0"> -- </OPTION>
					<?php 
					foreach ($resourcesList as $resource){
						$resourceId = $this->clean( $resource['id'] );	
						$resourceName = $this->clean( $resource['name'] );
						$checked = "";
						if ($resource_id == $resourceId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $resourceId ?>" <?= $checked ?>> <?= $resourceName ?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Outputs</label>
			<div class="col-xs-10">
				<div class="checkbox">
			    	<label>
			    	<?php 
			    	$checked = "";
			    	if ($view_pie_chart != ""){
			    		$checked = "checked";
			    	} 
			    		?>
			      	<input type="checkbox" name="view_pie_chart" <?= $checked ?>> view resources pie chart 
			    	</label>
               </div>
               <div class="checkbox">
			    	<label>
			    	<?php 
			    	$checked = "";
			    	if ($view_counting != ""){
			    		$checked = "checked";
			    	} 
			    		?>
			      	<input type="checkbox" name="view_counting" <?= $checked ?>> view counting 
			    	</label>
               </div>
               
               <div class="checkbox">
			    	<label>
			    	<?php 
			    	$checked = "";
			    	if ($view_details != ""){
			    		$checked = "checked";
			    	} 
			    		?>
			      	<input type="checkbox" name="view_details" <?= $checked ?>> view details 
			    	</label>
               </div>
  
			</div>
		</div>	
			
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Calculate" />
		</div>
      </form>
	</div>
</div>

<?php
$stylehidden = ""; 
if (!$resultsVisible){
	$stylehidden = "style=\"visibility: hidden\""; 
}
?>

<div <?= $stylehidden ?>>
  <div class="container">
	<div class="col-md-8 col-md-offset-2">
	  <div class="page-header">
		<h2>
			Results <br> <small></small>
		</h2>
	  </div>
	
	
	
		   <!-- /////////////////////////////////// //
	  //      Camembert
	  // //////////////////////////////////// // -->
	  <?php if ($camembert != ""){?>	
	  <div>
	  	  <div class="page-header">
		<h3>
			Authorizations during the periode <br> <small></small>
		</h3>
	  </div>
	  <div id="camembert" class="text-center">
		<?=  $camembert ?>
		
		<?php 
			$nameFile = "temp/camembert_authSVG.svg";
			$openFile = fopen($nameFile,"w");
			$toWrite = $camembert;
			fwrite($openFile, $toWrite);
			fclose($openFile);
		
			exec('sudo /usr/bin/inkscape -D temp/camembert_authSVG.svg -e temp/camembert_authJPG.jpg -b "#ffffff" -h800');
		?>
		</div>
		<br>
		<button type="button" onclick="location.href='temp/camembert_authJPG.jpg'" download="pie_chart_authorizations" class="btn btn-primary" id="navlink">Export as jpeg</button>
		
	  </div>
	  <br>
	  
	  <?php }?>
	  
	  <!-- /////////////////////////////////// //
	  //      minimal stats
	  // //////////////////////////////////// // -->
	  <?php if ($msData){?>
	  <div>
	  	  <div class="page-header">
		<h3>
			Counting <br> <small></small>
		</h3>
	  </div>
	  <?php 
	  if ($msData["erreur"] == "yes"){
	  ?>
		<p> <?= $msData["popup"]?> </p>
	  <?php	
	  }
	  else{
	  ?>
	  <table class="table table-striped table-bordered">
	  <thead>
	  <tr>
	  	<td>Search criteria</td>
	  	<td>Results</td>
	  </tr>
	  </thead>
	  <tbody>
	  <tr>
	  	<td>
	  		<p><?= $msData["criteres"] ?></p>
	  	</td>
	  	<td>
	  	Number of training : <?= $msData["numOfRows"]?><br/>
		Nomber of users : <?= $msData["distinct_nf"]?><br/>
		Nomber of units : <?= $msData["distinct_laboratoire"]?><br/>
		Nomber of VISAs : <?= $msData["distinct_visa"]?><br/>
		Nomber of resources : <?= $msData["distinct_machine"]?><br/>
		Nomber of new user : <?= $msData["new_people"]?>
	  	</td>
	  </tr>
	  </tbody>
	  </table>
		<?php }?>
		 <?php }?>
		 <button type="button" onclick="location.href='sygrrif/statauthorizationscountingcsv'" class="btn btn-primary" id="navlink">Export as csv</button>
		 

		
	  <!-- /////////////////////////////////// //
	  //      details stats
	  // //////////////////////////////////// // -->
	  <?php if ($dsData){?>
	  <div>
	  	  <div class="page-header">
		<h3>
			Details <br> <small></small>
		</h3>
	  </div>
	  <?php 
	  if ($dsData["erreur"] == "yes"){
	  ?>
		<p> <?= $dsData["popup"]?> </p>
	  <?php	
	  }
	  else{
	  	 
	  	?>
	  	<table class="table table-striped table-bordered">
	  	<thead>
			<tr>
				<td> Date </td>
				<td> User </td>
				<td> Unit </td>
				<td> Visa </td>
				<td> Resource </td>
				<td> Responsible </td>
			</tr>
		</thead>
		<tbody>
	  	<?php 
	  	
	  	 $i=0;
	  	 //print_r($dsData["data"]);
		 foreach($dsData["data"] as $v){
		?> <tr>
			<td> <?= $v['Date'] ?> </td>
			<td> <?= $v['Utilisateur'] ?> </td>
			<td> <?= $v['Laboratoire'] ?> </td>
			<td> <?= $v['Visa'] ?> </td>
			<td> <?= $v['machine'] ?> </td>
			<td> <?= $v['responsable'] ?> </td>
		<tr> <?php
		 }	
		 ?>
		 					</tbody>
		 					</table>
		 					<?php 
	  }		 
	?>
	<?php }?>
</div>
<button type="button" onclick="location.href='sygrrif/statauthorizationsdetailcsv'" class="btn btn-primary" id="navlink">Export as csv</button>
</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
