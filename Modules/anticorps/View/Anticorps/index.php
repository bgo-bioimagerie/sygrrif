<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
	
		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="text-center" colspan="10"><a href="anticorps/index/id"></a></th>
					<th class="text-center" colspan="3"><a href="anticorps/">Protocole</a></th>
					<th class="text-center" colspan="4"><a href="anticorps/">Tissus</a></th>
					<th class="text-center" colspan="3"><a href="anticorps/">Propriétaire</a></td>
					<th></th>
				</tr>
				<tr>
					<th class="text-center"><a href="anticorps/index/id">ID</a></th>
					<th class="text-center"><a href="anticorps/index/nom">Nom</a></th>
					<th class="text-center"><a href="anticorps/index/no_h2p2">No H2P2</a></th>
					<th class="text-center"><a href="anticorps/index/fournisseur">Fournisseur</a></th>
					<th class="text-center"><a href="anticorps/index/id_source">Source</a></th>
					<th class="text-center"><a href="anticorps/index/reference">Référence</a></th>
					<th class="text-center"><a href="anticorps/index/clone">Clone</a></th>
					<th class="text-center"><a href="anticorps/index/lot">lot</a></th>
					<th class="text-center"><a href="anticorps/index/id_isotype">Isotype</a></th>
					<th class="text-center"><a href="anticorps/index/stockage">Stockage</a></th>
					<th class="text-center"><a href="anticorps/">dilution</a></th>
					<th class="text-center"><a href="anticorps/">temps d'incubation</a></th>
					<th class="text-center"><a href="anticorps/">ref. protocol</a></th>
					<th class="text-center"><a href="anticorps/">espèce</a></th>
					<th class="text-center"><a href="anticorps/">organe</a></th>
					<th class="text-center"><a href="anticorps/">validé</a></th>
					<th class="text-center"><a href="anticorps/">ref. bloc</a></th>
					<th class="text-center"><a href="anticorps/">Nom</a></th>
					<th class="text-center"><a href="anticorps/">disponibilité</a></th>
					<th class="text-center"><a href="anticorps/">Date réception</a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $anticorpsArray as $anticorps ) : ?> 
				<tr>
					<?php $anticorpsId = $this->clean ( $anticorps['id'] ); ?>
					<td class="text-center"><?= $anticorpsId ?></td>
					<td class="text-center"><?= $this->clean ( $anticorps ['nom'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['no_h2p2'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['fournisseur'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['source'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['reference'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['clone'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['lot'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['isotype'] ); ?></td>
				    <td class="text-center"><?= $this->clean ( $anticorps ['stockage'] ); ?></td>
				    
				    <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['dilution']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['temps_incubation'] 
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['ref_protocol'] . "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				    <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  . $tissus[$i]['espece'] 
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
		                                . $tissus[$i]['organe']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
		                                . $tissus[$i]['valide']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				     <td class="text-center"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['ref_bloc']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>

				    <td class="text-center"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
				    		$name = $ow['firstname'] . " " . $ow['name'];
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
				    
				    <td class="text-center"><?php
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
				    
				    <td class="text-center"><?php
				    	$owner =  $anticorps ['proprietaire'];
				    	foreach ($owner as $ow){
					    	$name = $ow['firstname'] . " " . $ow['name'];
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
				    
				    <td><button onclick="location.href='anticorps/edit/<?= $anticorpsId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button></td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
