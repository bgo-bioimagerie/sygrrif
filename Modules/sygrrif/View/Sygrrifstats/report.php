<?php $this->title = "SyGRRiF Project bill"?>


 
<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="externals/datepicker/js/moments.js"></script>
	<script src="externals/jquery-1.11.1.js"></script>

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>
<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form name="form" class="form-horizontal" action="sygrrifstats/report"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::grr_report($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<?php
		if (isset($errorMessage) && $errorMessage != ''){
			?>
			<div class="alert alert-danger">
				<p><?= $errorMessage ?></p>
			</div>
		<?php } ?>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_Start($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>'>
				
				    <?php $date = ""; if(isset($searchDate_start)){$date=CoreTranslator::dateFromEn($searchDate_start, $lang);}?> 
					<input type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_start" id="searchDate_start"
					       value="<?=$date?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Date_End($lang) ?></label>
				<div class="col-xs-10">
				<div class='input-group date form_date_<?= $lang ?>'>
				<?php $date = ""; if(isset($searchDate_end)){$date=CoreTranslator::dateFromEn($searchDate_end, $lang);}?> 
					<input id="test32" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="searchDate_end" 
					       value="<?= $date ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"> Condition </label>
			<div class="col-xs-10">
				<select class="form-control" name="condition_et_ou" >
					<OPTION value="and" <?php if(isset($condition_et_ou) && $condition_et_ou == 1){echo "selected=\"selected\"";}?>> Valide toutes les conditions suivantes </OPTION>
					<OPTION value="or" <?php if(isset($condition_et_ou) && $condition_et_ou == 0){echo "selected=\"selected\"";}?>> Valide au moins une des conditions suivantes </OPTION>
				</select>
			</div>	
				
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::query($lang) ?></label>
			<div class="col-xs-10">
			<?php for($i = 0 ; $i < 5 ; $i++){
			?>
				<div class="col-xs-4">
				<select class="form-control" name="champ[]" >
					<?php 
					$checkedArea = "";
					$checkedRes = "";
					$checkedC = "";
					$checkedS = "";
					$checkedF = "";
					$checkedRec = "";
					if($champ[$i] == "area"){
						$checkedArea = "selected=\"selected\"";
					}
					else if ($champ[$i] == "resource"){
						$checkedRes = "selected=\"selected\"";
					}
					else if ($champ[$i] == "color_code"){
						$checkedC = "selected=\"selected\"";
					}
					else if ($champ[$i] == "short_description"){
						$checkedS = "selected=\"selected\"";
					}
					else if ($champ[$i] == "full_description"){
						$checkedF = "selected=\"selected\"";
					}
					else if ($champ[$i] == "recipient"){
						$checkedRec = "selected=\"selected\"";
					}
					?>
					<OPTION value="area" <?= $checkedArea ?>> <?= SyTranslator::Area($lang) ?> </OPTION>
					<OPTION value="resource" <?= $checkedRes ?>> <?= SyTranslator::Resource($lang) ?> </OPTION>
					<OPTION value="color_code" <?= $checkedC ?>> <?= SyTranslator::Color_code($lang) ?> </OPTION>
					<OPTION value="short_description" <?= $checkedS ?>> <?= SyTranslator::Short_desc($lang) ?> </OPTION>
					<OPTION value="full_description" <?= $checkedF ?>> <?= SyTranslator::Full_description($lang) ?> </OPTION>
					<OPTION value="recipient" <?= $checkedRec ?>> <?= SyTranslator::recipient($lang) ?> </OPTION>
				</select>
				
				</div>
				<div class="col-xs-4">
				<select class="form-control" name="type_recherche[]" >
					<OPTION value="1" <?php if(isset($type_recherche[$i]) && $type_recherche[$i] == 1){echo "selected=\"selected\"";}?>> <?= SyTranslator::Contains($lang) ?> </OPTION>
					<OPTION value="0" <?php if(isset($type_recherche[$i]) && $type_recherche[$i] == 0){echo "selected=\"selected\"";}?>> <?= SyTranslator::Does_not_contain($lang) ?> </OPTION>
				</select>
				</div>
				<div class="col-xs-4">
				<?php 
				$value = "";
				if(isset($text[$i])){
					$value = $text[$i];
				}
				?>
				<input type="text" class="form-control" name="text[]" value="<?=$value?>" />
		</div>
		<?php 	
		}?>
		</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Output($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="output">
					<?php 
					if (isset($output)){
						
					}
					?>
					<OPTION value="1" <?php if (isset($output) && $output == 1){echo "selected=\"selected\"";}?>> <?=SyTranslator::detailsreservation($lang)?> </OPTION>
					<OPTION value="2" <?php if (isset($output) && $output == 2){echo "selected=\"selected\"";}?>> <?=SyTranslator::resume($lang)?> </OPTION>
					<OPTION value="3" <?php if (isset($output) && $output == 3){echo "selected=\"selected\"";}?>><?=SyTranslator::detailresume($lang)?> </OPTION>
					<OPTION value="4" <?php if (isset($output) && $output == 4){echo "selected=\"selected\"";}?>><?=SyTranslator::csvres($lang)?></OPTION>
					<OPTION value="5" <?php if (isset($output) && $output == 5){echo "selected=\"selected\"";}?>> <?=SyTranslator::csvresume($lang)?> </OPTION>
				</select>
			</div>
		</div>	
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?=SyTranslator::resumepar($lang)?> :</label>
			<div class="col-xs-10">
				<select class="form-control" name="summary_rq">
					<?php 
					$checkedC = "";
					$checkedS = "";
					$checkedRec = "";
					
					if(isset($summary_rq)){
						if ($summary_rq == "color_code"){
							$checkedC = "selected=\"selected\"";
						}
						else if ($summary_rq == "short_description"){
							$checkedS = "selected=\"selected\"";
						}
						else if ($summary_rq == "recipient"){
							$checkedRec = "selected=\"selected\"";
						}
					}
					?>
					<OPTION value="recipient" <?= $checkedRec ?>> <?= SyTranslator::recipient($lang) ?> </OPTION>
					<OPTION value="short_description" <?= $checkedS ?>> <?= SyTranslator::Short_desc($lang) ?> </OPTION>
					<OPTION value="color_code" <?= $checkedC ?>> <?= SyTranslator::Color_code($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input class="form-control" id="name" type="hidden" name="is_request" value="y"/>
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<div class="col-lg-10 col-lg-offset-1">

<?php 
if(isset($table)){
	?>
<table class="table table-striped text-center table-bordered">
   <caption><?= count($table) ?> réservations trouvées </caption>

   <thead> 
       <tr>				
           <th><?= SyTranslator::Area($lang) ?></th>
           <th><?= SyTranslator::Resource($lang) ?></th>
           <th><?= SyTranslator::Short_desc($lang) ?></th>
           <th><?= SyTranslator::Date($lang) ?></th> 
           <th> <?= SyTranslator::Full_description($lang) ?> </th>
           <th> <?= SyTranslator::Color_code($lang) ?> </th>
           <th> <?= SyTranslator::recipient($lang) ?> </th>
       </tr>
   </thead>

   <tbody> 
   	   <?php
	   foreach ($table as $t){
   	   ?>
       <tr>
           <td> <?= $t["area_name"] ?> </td>
           <td><?= $t["resource"] ?></td>
           <td><?= $t["short_description"] ?></td>
           
           <?php 
           $date = "debut : " . date( "d/m/Y à H:i", $t["start_time"]) . "<br/>";
           $date .= "fin : " . date( "d/m/Y à H:i", $t["end_time"]) . "<br/>";
           $date .= "durée : " . ($t["end_time"] - $t["start_time"])/60 . " minutes";
           ?>
           
           <td><?= $date ?></td>
           <td><?= $t["full_description"] ?></td>
           <td><?= $t["color"] ?></td>
           <td><?= $t["login"] ?></td>
       </tr>
       
       
								
       <?php 
	   }
       ?>
      
   </tbody>
</table>
<?php 
}
?>

</div>

<div class="col-lg-10 col-lg-offset-1">

<?php 
if(isset($summaryTable)){
	?>
<table class="table table-striped text-center table-bordered">
   <caption>Résumé </caption>

   <?php
   $countTable = $summaryTable['countTable'];
   $timeTable = $summaryTable['timeTable'];
   $resourcesNames = $summaryTable['resources'];
   $entrySummary = $summaryTable['entrySummary'];
   //print_r($timeTable);
   ?>
   
   
   
   <thead>
   <th></th>
   <?php 
   foreach ($resourcesNames as $name){
   ?>
   <th><?= $name ?></th>
   <?php 
   }	 
   ?>
   
   <th>Total</th>
   </thead>
   
   <tbody>
   <?php
   $i = -1;
   $totalCG = 0;
   $totalHG = 0;
   foreach ($countTable as $coutT){
   	$i++;
   	?>
   	<tr>
   	<th><?= $entrySummary[$i] ?></th>
   	<?php 
   		$j = -1;
   		$totalC = 0;
   		$totalH = 0;
   		foreach ($coutT as $col){
   			$j++;
	   	?>
		   	
   			<th> (<?= $col ?>) <?= $timeTable[$entrySummary[$i]][$resourcesNames[$j]]/3600 ?> </th>
   		<?php
   			$totalC += $col;
   			$totalH += $timeTable[$entrySummary[$i]][$resourcesNames[$j]];
   		}
   	?>
   		<th>(<?= $totalC ?>) <?= $totalH/3600 ?> </th>
   	</tr>
   	<?php
   	$totalCG += $totalC;
   	$totalHG += $totalH;
   }
   ?>
   
   <tr>
   		<th> Total </th>
   		<?php 
   		for ($i = 0 ; $i < count($resourcesNames) ; $i++){
   			// calcualte the sum
   			$sumC = 0;
   			$sumH = 0;
   			for ($x = 0 ; $x < count($entrySummary) ; $x++){
   				$sumC += $countTable[$entrySummary[$x]][$resourcesNames[$i]];
   				$sumH += $timeTable[$entrySummary[$x]][$resourcesNames[$i]];
   			}
   			?>
   			<th> (<?= $sumC ?>) <?= $sumH/3600 ?> </th>
   			<?php 
   		}
   		?>
   		<th> (<?= $totalCG ?>) <?= $totalHG/3600 ?> </th>
   </tr>
   
   </tbody>
  </table> 
 <?php 
}
?>

</div>


<br>



<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
