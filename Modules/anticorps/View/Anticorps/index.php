<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

table{
font-size: 12px;
}

</style>

</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="contatiner">

	<div class="col-md-12">

		<div class="page-header">
			<h1>
				Anticorps<br> <small></small>
			</h1>
		</div>
		
		<div class="col-md-12">
			<form role="form" class="form-horizontal" action="anticorps/searchquery"
				  method="post">
		
			<?php
			if(!isset($searchColumn)){
				$searchColumn = "0";
			}
			if(!isset($searchTxt)){
				$searchTxt = "";
			}
			?>
				<label for="inputEmail" class="control-label col-md-2">Rechercher:</label>
				<div class="col-md-3">
					<select class="form-control" name="searchColumn">
						<?php $selected = "selected=\"selected\""; ?>
						<OPTION value="0" <?php if($searchColumn=="0"){echo $selected;} ?> > Select </OPTION>
						<OPTION value="Nom" <?php if($searchColumn=="Nom"){echo $selected;} ?> > Nom </OPTION>
						<OPTION value="No_h2p2" <?php if($searchColumn=="No_h2p2"){echo $selected;} ?> > No H2P2 </OPTION>
						<OPTION value="Fournisseur" <?php if($searchColumn=="Fournisseur"){echo $selected;} ?> > Fournisseur </OPTION>
						<OPTION value="Source" <?php if($searchColumn=="Source"){echo $selected;} ?> > Source </OPTION>
						<OPTION value="Reference" <?php if($searchColumn=="Reference"){echo $selected;} ?> > Référence </OPTION>
						<OPTION value="Clone" <?php if($searchColumn=="Clone"){echo $selected;} ?> > Clone </OPTION>
						<OPTION value="lot" <?php if($searchColumn=="lot"){echo $selected;} ?> > lot </OPTION>
						<OPTION value="Isotype" <?php if($searchColumn=="Isotype"){echo $selected;} ?> > Isotype </OPTION>
						<OPTION value="Stockage" <?php if($searchColumn=="Stockage"){echo $selected;} ?> > Stockage </OPTION>					
						<OPTION value="dilution" <?php if($searchColumn=="dilution"){echo $selected;} ?> > dilution </OPTION>
						<OPTION value="temps_incub" <?php if($searchColumn=="temps_incub"){echo $selected;} ?> > temps d'incubation </OPTION>
						<OPTION value="ref_proto" <?php if($searchColumn=="ref_proto"){echo $selected;} ?> > ref. protocol </OPTION>
						<OPTION value="espece" <?php if($searchColumn=="espece"){echo $selected;} ?> > espece </OPTION>
						<OPTION value="organe" <?php if($searchColumn=="organe"){echo $selected;} ?> > organe </OPTION>
						<OPTION value="valide" <?php if($searchColumn=="valide"){echo $selected;} ?> > validé </OPTION>
						<OPTION value="ref_bloc" <?php if($searchColumn=="ref_bloc"){echo $selected;} ?> > ref. bloc </OPTION>
						<OPTION value="nom_proprio" <?php if($searchColumn=="nom_proprio"){echo $selected;} ?> > Nom Propriétaire </OPTION>
						<OPTION value="disponibilite" <?php if($searchColumn=="disponibilite"){echo $selected;} ?> > disponibilité </OPTION>
						<OPTION value="date_recept" <?php if($searchColumn=="date_recept"){echo $selected;} ?> > date réception </OPTION>
						<OPTION value="no_dossier" <?php if($searchColumn=="no_dossier"){echo $selected;} ?> > No Dossier </OPTION>
	  				</select>
				</div>
				<div class="col-md-3">
					<input class="form-control" id="searchTxt" type="text" name="searchTxt" value="<?= $searchTxt ?>"
					/>
				</div>
			
				<div class="col-md-2" id="button-div">
		        	<input type="submit" class="btn btn-primary" value="Rechercher" />
				</div>
      		</form>
		</div>
		
		<div class="col-md-12" style="margin-top: 25px;">
			<br/>
		</div>
		
		<div class="col-md-12">
			<form role="form" class="form-horizontal" action="anticorps/advsearchquery"
				  method="post">
		
				<?php
				if(!isset($searchName)){
					$searchName = "";
				}
				if(!isset($searchNoH2P2)){
					$searchNoH2P2 = "";
				}
				if(!isset($searchSource)){
					$searchSource = "";
				}
				if(!isset($searchCible)){
					$searchCible = "";
				}
				if(!isset($searchValide)){
					$searchValide = "";
				}
				if(!isset($searchResp)){
					$searchResp = "";
				}
				
				?>
				<label class="control-label col-md-2">Recherche Avancée:</label>
				
				<div class="col-md-8">
					<label class="control-label col-md-1" style="margin:0px;">Nom:</label>
					<div class="col-md-3">
						<input class="form-control" id="searchName" type="text" name="searchName" value="<?= $searchName ?>"
						/>
					</div>
					<label for="inputEmail" class="control-label col-md-1">No H2P2:</label>
					<div class="col-md-3">
						<input class="form-control" id="searchNoH2P2" type="text" name="searchNoH2P2" value="<?= $searchNoH2P2 ?>"
						/>
					</div>
					<label for="inputEmail" class="control-label col-md-1">Source:</label>
					<div class="col-md-3">
						<input class="form-control" id="searchSource" type="text" name="searchSource" value="<?= $searchSource ?>"
						/>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">	
					<label for="inputEmail" class="control-label col-md-1">Tissu cible:</label>
					<div class="col-md-3">
						<input class="form-control" id="searchCible" type="text" name="searchCible" value="<?= $searchCible ?>"
						/>
					</div>
					
					<label for="inputEmail" class="control-label col-md-1">Status:</label>
					<div class="col-md-3">
						<select class="form-control" id="searchValide" type="text" name="searchValide">
							<OPTION value="0" <?php if($searchColumn=="0"){echo $selected;} ?> >  </OPTION>
							<OPTION value="1" <?php if($searchValide=="1"){echo $selected;} ?> > Validé </OPTION>
							<OPTION value="2" <?php if($searchValide=="2"){echo $selected;} ?> > Non validé </OPTION>
							<OPTION value="3" <?php if($searchValide=="3"){echo $selected;} ?> > Non testé </OPTION>
						</select>
					</div>
					
					<label for="inputEmail" class="control-label col-md-1">Propriétaire:</label>
					<div class="col-md-3">
						<input class="form-control" id="searchResp" type="text" name="searchResp" value="<?= $searchResp ?>"
						/>
					</div>
				</div>
			
				<div class="col-md-2" id="button-div">
		        	<input type="submit" class="btn btn-primary" value="Rechercher" />
				</div>
      		</form>
		</div>
		
		<div class="col-md-12" style="margin-top: 25px;">
			<br/>
		</div>
	
	<div>
		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="text-center" colspan="9"><a href="anticorps/">Anticorps</a></th>
					<th class="text-center" colspan="3" style="background-color: #ffeeee;"><a href="anticorps/">Protocole</a></th>
					<th class="text-center" colspan="5" style="background-color: #eeffee;"><a href="anticorps/">Tissus</a></th>
					<th class="text-center" colspan="4" style="background-color: #eeeeff;"><a href="anticorps/">Propriétaire</a></th>
					<th></th>
				</tr>
				<tr>
					<!--  <th class="text-center"><a href="anticorps/index/id">ID</a></th>  -->
					<th class="text-center"><a href="anticorps/index/nom">Nom</a></th>
					<th class="text-center"><a href="anticorps/index/no_h2p2">No H2P2</a></th>
					<th class="text-center"><a href="anticorps/index/fournisseur">Fournisseur</a></th>
					<th class="text-center"><a href="anticorps/index/id_source">Source</a></th>
					<th class="text-center"><a href="anticorps/index/reference">Référence</a></th>
					<th class="text-center"><a href="anticorps/index/clone">Clone</a></th>
					<th class="text-center"><a href="anticorps/index/lot">lot</a></th>
					<th class="text-center"><a href="anticorps/index/id_isotype">Isotype</a></th>
					<th class="text-center"><a href="anticorps/index/stockage">Stockage</a></th>
					
					<th class="text-center" style="background-color: #ffeeee;"><a href="anticorps/">ref. protocol</a></th>
					<th class="text-center" style="background-color: #ffeeee";><a href="anticorps/">dilution</a></th>
					<th class="text-center" style="background-color: #ffeeee";><a href="anticorps/">temps d'incubation</a></th>
					
					<th class="text-center" style="background-color: #eeffee;"><a href="anticorps/">espèce</a></th>
					<th class="text-center" style="background-color: #eeffee;"><a href="anticorps/">organe</a></th>
					<th class="text-center" style="background-color: #eeffee;"><a href="anticorps/">status</a></th>
					<th class="text-center" style="min-width: 10em; background-color: #eeffee;"><a href="anticorps/">ref. bloc</a></th>
					<th class="text-center" style="background-color: #eeffee;"><a href="anticorps/">prélèvement</a></th>	
					
					<th class="text-center" style="background-color: #eeeeff;"><a href="anticorps/">Nom</a></th>
					<th class="text-center" style="background-color: #eeeeff;"><a href="anticorps/">disponibilité</a></th>
					<th class="text-center" style="background-color: #eeeeff;"><a href="anticorps/">Date réception</a></th>
					<th class="text-center" style="background-color: #eeeeff;"><a href="anticorps/">No Dossier</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $anticorpsArray as $anticorps ) : ?> 
				<tr>
					<?php $anticorpsId = $this->clean ( $anticorps['id'] ); ?>
					<!--  <td class="text-left"><?= $anticorpsId ?></td> -->
					<td class="text-left"><?= $this->clean ( $anticorps ['nom'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['no_h2p2'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['fournisseur'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['source'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['reference'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['clone'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['lot'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['isotype'] ); ?></td>
				    <td class="text-left"><?= $this->clean ( $anticorps ['stockage'] ); ?></td>
				    
				    
				    <!--  PROTOCOLE -->
				     <td class="text-left" style="background-color: #ffeeee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		
				    		if($tissus[$i]['ref_protocol'] == 0){
				    			$val .= "<p>Manuel</p>";
				    		}
				    		else{
				    			$val .= "<p><a href=\"protocols/protoref/" . $tissus[$i]['ref_protocol'] . "\">"  
										. $tissus[$i]['ref_protocol'] . "</a></p>";
				    		}  
				    	}			    	
					    echo $val;
				    ?></a></td>
				    
				    
				    <td class="text-left" style="background-color: #ffeeee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['dilution']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td class="text-left" style="background-color: #ffeeee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['temps_incubation'] 
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				    <!-- TISSUS -->
				    <td class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  . $tissus[$i]['espece'] 
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
		                                . $tissus[$i]['organe']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$statusTxt = "Non testé";
				    		if ($tissus[$i]['status'] == 1){
				    			$statusTxt = "Validé";
				    		}
				    		if ($tissus[$i]['status'] == 2){
				    			$statusTxt = "Non validé";
				    		}
				    		
				    		$val = $val . "<p>" 
		                                . $statusTxt
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				     <td class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['ref_bloc']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['prelevement']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				   

				    <td class="text-left" style="background-color: #eeeeff;"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
				    		$name = $ow['name'] . " " . $ow['firstname'];
					    	$dispo = $ow['disponible'];
					    	if ($dispo == 1){$dispo = "disponible";}
					    	else if ($dispo == 2){$dispo = "épuisé";}
					    	else if ($dispo == 3){$dispo = "récupéré par équipe";}
					    	$date_recept = CoreTranslator::dateFromEn($ow['date_recept'], $lang);
					    	$txt = $this->clean ( $name );
					    	
					    	if ($this->clean($dispo) == "épuisé"){
					    		echo '<p style="background-color:#ffaaaa; color:#fff">' . $txt . '</p>';
					    	}
					    	else{
					    		echo '<p>' . $txt . '</p>';
					    	}    
				    	}
				    	?>
				    </td>
				    
				    <td class="text-left" style="background-color: #eeeeff;"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
					    	$dispo = $ow['disponible'];
					    	if ($dispo == 1){$dispo = "disponible";}
					    	else if ($dispo == 2){$dispo = "épuisé";}
					    	else if ($dispo == 3){$dispo = "récupéré par équipe";}
					    	$date_recept = CoreTranslator::dateFromEn($ow['date_recept'], $lang);
					    	$txt = $this->clean($dispo); 
					    	
					    	if ($this->clean($dispo) == "épuisé"){
					    		echo '<p style="background-color:#ffaaaa; color:#fff">' . $txt . '</p>';
					    	}
					    	else{
					    		echo '<p>' . $txt . '</p>';
					    	}    
				    	}
				    	?>
				    </td>
				    
				    <td class="text-left" style="background-color: #eeeeff;"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
					    	$name = $ow['name'] . " " . $ow['firstname'];
					    	$dispo = $ow['disponible'];
					    	if ($dispo == 1){$dispo = "disponible";}
					    	else if ($dispo == 2){$dispo = "épuisé";}
					    	else if ($dispo == 3){$dispo = "récupéré par équipe";}
					    	$date_recept = CoreTranslator::dateFromEn($ow['date_recept'], $lang);
					    	$txt = $this->clean($date_recept); 
					    	
					    	if ($this->clean($dispo) == "épuisé"){
					    		echo '<p style="background-color:#ffaaaa; color:#fff">' . $txt . '</p>';
					    	}
					    	else{
					    		echo '<p>' . $txt . '</p>';
					    	}    
				    	}
				    	?>
				    </td>
				    
				    <td class="text-left" style="background-color: #eeeeff;"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
					    	$name = $ow['name'] . " " . $ow['firstname'];
					    	$dispo = $ow['disponible'];
					    	if ($dispo == 1){$dispo = "disponible";}
					    	else if ($dispo == 2){$dispo = "épuisé";}
					    	else if ($dispo == 3){$dispo = "récupéré par équipe";}
					    	$date_recept = CoreTranslator::dateFromEn($ow['date_recept'], $lang);
					    	$txt = $this->clean($ow['no_dossier']); 
					    	
					    	if ($this->clean($dispo) == "épuisé"){
					    		echo '<p style="background-color:#ffaaaa; color:#fff">' . $txt . '</p>';
					    	}
					    	else{
					    		echo '<p>' . $txt . '</p>';
					    	}    
				    	}
				    	?>
				    </td>
				    
				    <td><button onclick="location.href='anticorps/edit/<?= $anticorpsId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>
		</div>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
