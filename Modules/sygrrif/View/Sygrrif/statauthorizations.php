<?php $this->title = "SyGRRiF Statistics"?>

<?php echo $navBar?>

<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="externals/datepicker/js/moments.js"></script>
	<script src="externals/jquery-1.11.1.js"></script>

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
				<?= SyTranslator::Statistics_authorizations($lang) ?>
				<br> <small></small>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_Start($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>' >
					<input type='text' class="form-control" name="searchDate_start" id="searchDate_start"
					       value="<?= CoreTranslator::dateFromEn($searchDate_start, $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			<script src="externals/datepicker/js/bootstrap-datetimepicker.min.js"></script>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_End($lang)?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>' >
					<input id="test32" type='text' class="form-control" name="searchDate_end" 
					       value="<?= CoreTranslator::dateFromEn($searchDate_end, $lang)  ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::User($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Curent_unit($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Unit_at_the_authorization_date_time($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Visa($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Resource($lang)?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Outputs($lang)?></label>
			<div class="col-xs-10">
				<div class="checkbox">
			    	<label>
			    	<?php 
			    	$checked = "";
			    	if ($view_pie_chart != ""){
			    		$checked = "checked";
			    	} 
			    		?>
			      	<input type="checkbox" name="view_pie_chart" <?= $checked ?>> <?= SyTranslator::view_resources_pie_chart($lang)?> 
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
			      	<input type="checkbox" name="view_counting" <?= $checked ?>> <?= SyTranslator::view_counting($lang)?>
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
			      	<input type="checkbox" name="view_details" <?= $checked ?>> <?= SyTranslator::view_details($lang)?>
			    	</label>
               </div>
  
			</div>
		</div>	
			
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Calculate($lang)?>" />
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
			<?= SyTranslator::Results($lang)?> <br> <small></small>
		</h2>
	  </div>
	
	
	
		   <!-- /////////////////////////////////// //
	  //      Camembert
	  // //////////////////////////////////// // -->
	  <?php if ($camembert != ""){?>	
	  <div>
	  	  <div class="page-header">
		<h3>
			<?= SyTranslator::Authorisations($lang) ?>
			<br> <small></small>
		</h3>
	  </div>
	  <div id="camembert" class="text-center">
		<?=  $camembert ?>
		
		<?php 
		
		if (Configuration::get("saveImages") == "enable"){
			$nameFile = "data/temp/camembert_authSVG.svg";
			$openFile = fopen($nameFile,"w");
			$toWrite = $camembert;
			fwrite($openFile, $toWrite);
			fclose($openFile);
		
			exec('sudo /usr/bin/inkscape -D data/temp/camembert_authSVG.svg -e data/temp/camembert_authJPG.jpg -b "#ffffff" -h800');
		}
		?>
		</div>
		<br>
		<?php if (Configuration::get("saveImages") == "enable"){ ?>
		<button type="button" onclick="location.href='data/temp/camembert_authJPG.jpg'" download="pie_chart_authorizations" class="btn btn-primary" id="navlink"><?= SyTranslator::Export_as_jpeg($lang) ?></button>
		<?php } ?>
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
			<?= SyTranslator::Counting($lang) ?> <br> <small></small>
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
	  	<td><?= SyTranslator::Search_criteria($lang) ?></td>
	  	<td><?= SyTranslator::Results($lang) ?></td>
	  </tr>
	  </thead>
	  <tbody>
	  <tr>
	  	<td>
	  		<p><?= $msData["criteres"] ?></p>
	  	</td>
	  	<td>
	  	<?= SyTranslator::Number_of_training($lang) ?> : <?= $msData["numOfRows"]?><br/>
		<?= SyTranslator::Nomber_of_users($lang) ?> : <?= $msData["distinct_nf"]?><br/>
		<?= SyTranslator::Nomber_of_units($lang) ?> : <?= $msData["distinct_laboratoire"]?><br/>
		<?= SyTranslator::Nomber_of_VISAs($lang) ?> : <?= $msData["distinct_visa"]?><br/>
		<?= SyTranslator::Nomber_of_resources($lang) ?> : <?= $msData["distinct_machine"]?><br/>
		<?= SyTranslator::Nomber_of_new_user($lang) ?> : <?= $msData["new_people"]?>
	  	</td>
	  </tr>
	  </tbody>
	  </table>
		<?php }?>
		 <?php }?>
		 <button type="button" onclick="location.href='sygrrif/statauthorizationscountingcsv'" class="btn btn-primary" id="navlink"><?= SyTranslator::Export_as_xls($lang) ?></button>
		 

		
	  <!-- /////////////////////////////////// //
	  //      details stats
	  // //////////////////////////////////// // -->
	  <?php if ($dsData){?>
	  <div>
	  	  <div class="page-header">
		<h3>
			<?= SyTranslator::detail($lang)?>
			<br> <small></small>
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
				<td> <?= SyTranslator::Date($lang) ?> </td>
				<td> <?= SyTranslator::User($lang) ?> </td>
				<td> <?= SyTranslator::Unit($lang) ?> </td>
				<td> <?= SyTranslator::Visa($lang) ?> </td>
				<td> <?= SyTranslator::Resource($lang) ?> </td>
				<td> <?= SyTranslator::Responsible($lang) ?> </td>
			</tr>
		</thead>
		<tbody>
	  	<?php 
	  	
	  	 $i=0;
	  	 //print_r($dsData["data"]);
		 foreach($dsData["data"] as $v){
		?> <tr>
			<td> <?= CoreTranslator::dateFromEn($v['Date'], $lang)  ?> </td>
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
<button type="button" onclick="location.href='sygrrif/statauthorizationsdetailcsv'" class="btn btn-primary" id="navlink"><?= SyTranslator::Export_as_xls($lang) ?></button>
</div>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
