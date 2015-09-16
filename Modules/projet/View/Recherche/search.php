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
<?php include "Modules/projet/View/projetnavbar.php"; ?>
 

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form name="form" class="form-horizontal" action="Recherche/search"
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
			<label for="inputEmail" class="control-label col-xs-2"> Condition </label>
			<div class="col-xs-10">
				<select class="form-control" name="condition_et_ou" >
					<OPTION value="and" <?php if(isset($condition_et_ou) && $condition_et_ou == 1){echo "selected=\"selected\"";}?>> <?=SyTranslator::validettcondition($lang)?> </OPTION>
					<OPTION value="or" <?php if(isset($condition_et_ou) && $condition_et_ou == 0){echo "selected=\"selected\"";}?>> <?=SyTranslator::validecondition($lang)?> </OPTION>
				</select>
			</div>	
				
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::query($lang) ?></label>
			<div class="col-xs-10">
			<?php for($i = 0 ; $i < 6 ; $i++){
			?>
				<div class="col-xs-4">
				<select class="form-control" name="champ[]" >
					<?php 
					$checkedNumFiche = "";
					$checkedTypeP = "";
					$checkedNac = "";
					$checkedA = "";
					$checkedTypeA = "";
					$checkedInvP="";
					$checkedProm = "";
					$checkedOpg="";
					$checkedproinjc="";
					$checkedCstn = "";
					$checkedGamds="";
					$checkedsoins="";
					$checkedcout = "";
					$checkedint = "";
					$checkedirm = "";
					$checkedlirm = "";
					if($champ[$i] == "numerofiche"){
						$checkedNumFiche = "selected=\"selected\"";
					}
					else if ($champ[$i] == "type"){
						$checkedTypeP = "selected=\"selected\"";
					}
					else if ($champ[$i] == "nac"){
						$checkedNac = "selected=\"selected\"";
					}
					else if ($champ[$i] == "acronyme"){
						$checkedA = "selected=\"selected\"";
					}
					else if ($champ[$i] == "typeactivite"){
						$checkedTypeA = "selected=\"selected\"";
					}
					else if ($champ[$i] == "ipprenom"){
						$checkedInvP = "selected=\"selected\"";
					}
					else if ($champ[$i] == "promoteur"){
						$checkedProm = "selected=\"selected\"";
					}
					else if ($champ[$i] == "opglibelle"){
						$checkedOpg = "selected=\"selected\"";
					}
					else if ($champ[$i] == "protocoleinjecte"){
						$checkedproinjc = "selected=\"selected\"";
					}
					else if ($champ[$i] == "cstnt"){
						$checkedCstn = "selected=\"selected\"";
					}
					else if ($champ[$i] == "gamds"){
						$checkedGamds = "selected=\"selected\"";
					}
					else if ($champ[$i] == "soinscourant"){
						$checkedsoins = "selected=\"selected\"";
					}
					else if ($champ[$i] == "tarif"){
						$checkedcout = "selected=\"selected\"";
					}
					else if ($champ[$i] == "intitule"){
						$checkedint = "selected=\"selected\"";
					}
					else if ($champ[$i] == "irm"){
						$checkedirm = "selected=\"selected\"";
					}
					else if ($champ[$i] == "lastirm"){
						$checkedlirm = "selected=\"selected\"";
					}
					?>
					<OPTION value="numerofiche" <?= $checkedNumFiche ?>> <?=ProjetTranslator::numerofiche($lang) ?> </OPTION>
					<OPTION value="type" <?= $checkedTypeP ?>> <?= ProjetTranslator::type($lang) ?> </OPTION>
					<OPTION value="nac" <?= $checkedNac ?>>Neuro, Abdo, Cardio </OPTION>
					<OPTION value="acronyme" <?= $checkedA ?>> <?= ProjetTranslator::Acronyme($lang) ?> </OPTION>
					<OPTION value="typeactivite" <?= $checkedTypeA ?>> <?= ProjetTranslator::typeactivite($lang) ?> </OPTION>
					<OPTION value="ipprenom" <?= $checkedInvP ?>> Prenom investigateur principal </OPTION>
					<OPTION value="promoteur" <?= $checkedProm ?>> <?= ProjetTranslator::prom($lang) ?> </OPTION>
					<OPTION value="opglibelle" <?= $checkedOpg ?>> Organisme Partenaire Gestionnaire </OPTION>
					<OPTION value="protocoleinjecte" <?= $checkedproinjc ?>> <?=ProjetTranslator::protocoleinjecte($lang)?> </OPTION>
					<OPTION value="cstnt" <?= $checkedCstn ?>>  Correspondant technique Neunrinfo  </OPTION>
					<OPTION value="gamds" <?= $checkedGamds ?>>Shanoir </OPTION>
					<OPTION value="soinscourant" <?= $checkedsoins ?>> <?=ProjetTranslator::soins($lang)?> </OPTION>
					<OPTION value="tarif" <?= $checkedcout ?>> <?=ProjetTranslator::prix($lang)?> </OPTION>
					<OPTION value="intitule" <?= $checkedint ?>> <?=ProjetTranslator::cotation($lang)?> </OPTION>
					<OPTION value="irm" <?= $checkedirm ?>> <?=ProjetTranslator::irm($lang)?> </OPTION>
					<OPTION value="lastirm" <?= $checkedlirm ?>> <?=ProjetTranslator::derirm($lang)?> </OPTION>
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
					$checkedNumFiche = "";
					$checkedA = "";
					$checkedNac = "";
					
					if(isset($summary_rq)){
						if ($summary_rq == "numerofiche"){
							$checkedNumFiche = "selected=\"selected\"";
						}
						else if ($summary_rq == "acronyme"){
							$checkedA = "selected=\"selected\"";
						}
						else if ($summary_rq == "nac"){
							$checkedNac = "selected=\"selected\"";
						}
					}
					?>
					<OPTION value="numerofiche" <?= $checkedNumFiche ?>> <?= ProjetTranslator::numerofiche($lang) ?> </OPTION>
					<OPTION value="acronyme" <?= $checkedA ?>> <?= SyTranslator::Acronyme($lang) ?> </OPTION>
					<OPTION value="nac" <?= $checkedNac ?>> Neuro, Abdo, Cardio </OPTION>
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
   <caption><?= count($table) ?> <?=SyTranslator::resertrouve($lang)?></caption>
 
   <thead> 
       <tr>				
           <th><?= ProjetTranslator::numerofiche($lang) ?></th>
           <th><?= ProjetTranslator::type($lang) ?></th>
           <th>Neuro, Abdo, Cardio</th>
           <th><?= SyTranslator::Acronyme($lang) ?></th>
           <th><?= ProjetTranslator::typeactivite($lang) ?></th> 
           <th>  Prenom investigateur principal </th>
           <th> <?= ProjetTranslator::prom($lang) ?> </th>
           <th> Organisme Partenaire Gestionnaire </th>
            <th> <?=ProjetTranslator::protocoleinjecte($lang)?> </th>
           <th>  Correspondant technique Neunrinfo </th>
           <th>Shanoir </th>
           <th><?=ProjetTranslator::soins($lang)?> </th>
           <th><?=ProjetTranslator::prix($lang)?></th>
            <th><?=ProjetTranslator::cotation($lang)?></th>
           <th><?=ProjetTranslator::irm($lang)?></th>
           <th><?=ProjetTranslator::derirm($lang)?></th>
          
       </tr>
   </thead>

   <tbody> 
   	   <?php
	   foreach ($table as $t){
   	   ?>
       <tr>
           <td> <?= $t["numerofiche"] ?> </td>
           <td><?= $t["type"] ?></td>
           <td><?= $t["nac"] ?></td>
           <td><?= $t['acronyme'] ?></td>
           <td><?= $t["typeactivite"] ?></td>
            <td><?= $t["ipprenom"] ?></td>
           <td><?= $t["promoteur"] ?></td>
           <td><?= $t["opglibelle"] ?></td>
           <td><?= $t["protocoleinjecte"] ?></td>
            <td><?= $t["cstnt"] ?></td>
           <td><?= $t["gamds"] ?></td>
           <td><?= $t["soinscoutant"] ?></td>
            <td><?= $t["tarif"] ?></td>
             <td><?= $t["intitule"] ?></td>
              <td><?= $t["irm"] ?></td>
               <td><?= $t["lastirm"] ?></td>
           
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
   <caption><?=SyTranslator::resumen($lang)?> </caption>

   <?php
   $countTable = $summaryTable['countTable'];
   $resourcesNames = $summaryTable['acronyme'];
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
		   	
   			<th> (<?= $col ?>) </th>
   		<?php
   			$totalC += $col;
   			
   		}
   	?>
   		<th>(<?= $totalC ?>) </th>
   	</tr>
   	<?php
   	$totalCG += $totalC;
  
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
   				
   			}
   			?>
   			<th> (<?= $sumC ?>)  </th>
   			<?php 
   		}
   		?>
   		<th> (<?= $totalCG ?>) </th>
   </tr>
   
   </tbody>
  </table> 
 <?php 
}
?>

</div>







</div>



<br>



<?php include "Modules/core/View/timepicker_script.php" ?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
<!-- 
<?php if(isset($info)){?>
<table class="table table-striped table-hover ">
 <thead>
    <tr>
      <th>Id</th>
      <th><?=ProjetTranslator::typeactivite($lang)?></th>
      <th>NAC</th>
	  <th><?=ProjetTranslator::Acronyme($lang)?></th>
	  <th><?=ProjetTranslator::protocoleinjecte($lang)?></th>
	  <th><?=ProjetTranslator::dureeexam($lang)?></th>
	  <th><?=ProjetTranslator::numerovisite($lang)?></th>
	   <th><?=ProjetTranslator::nombredexam($lang)?></th>
	  <th><?=ProjetTranslator::dureetotale($lang)?></th>
	  <th><?=ProjetTranslator::montant($lang)?></th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach ($info as $value){?>
  <tr>
      <td><?php echo $value['idform']?></td>
      <td><?php echo $value['typeactivite']?></td>
      <td><?php echo $value['nac']?></td>
      <td><?php echo $value['acronyme']?></td>
      <td><?php echo $value['protocoleinjecte']?></td>
      <td><?php echo $value['duree']?></td>
      <td><?php echo $value['numerovisite']?></td>
      <td><?php echo $value['nbrexam']?></td>
      <td><?php echo $value['dureetotale']?></td>
      <td><?php echo $value['tarif']?></td>
      
      <td></td>
      
    </tr><?php }?>
  
    
 </tbody>
</table><?php }?>
<?php if(isset($donnee)){?>
<table class="table table-striped table-hover ">
 <thead>
    <tr>
    <th>Id</th>
   	 <th>NAC</th>
     <th><?=ProjetTranslator::typeactivite($lang)?></th>
     <th><?=ProjetTranslator::Acronyme($lang)?></th>
	 <th><?=ProjetTranslator::protocoleinjecte($lang)?></th>
	  <th><?=ProjetTranslator::dureeexam($lang)?></th>
	  <th><?=ProjetTranslator::numerovisite($lang)?></th>
	   <th><?=ProjetTranslator::nombredexam($lang)?></th>
	  <th><?=ProjetTranslator::dureetotale($lang)?></th>
	  <th><?=ProjetTranslator::montant($lang)?></th>
    </tr>
  </thead>
  <tbody>
  
  <?php foreach ($donnee as $value){?>
  <tr>
      <td><?php echo $value['idform']?></td>
      <td><?php echo $value['nac']?></td>
      <td><?php echo $value['typeactivite']?></td>
      <td><?php echo $value['acronyme']?></td>
     <td><?php echo $value['protocoleinjecte']?></td>
      <td><?php echo $value['duree']?></td>
      <td><?php echo $value['numerovisite']?></td>
      <td><?php echo $value['nbrexam']?></td>
      <td><?php echo $value['dureetotale']?></td>
      <td><?php echo $value['tarif']?></td>
      
      <td></td>
      
    </tr><?php }?>
  
    
 </tbody>
</table><?php }?>


 -->
