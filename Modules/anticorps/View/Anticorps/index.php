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
	
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td class="text-center"><a href="anticorps/index/id">ID</a></td>
					<td class="text-center"><a href="anticorps/index/nom">Nom</a></td>
					<td class="text-center"><a href="anticorps/index/no_h2p2">No H2P2</a></td>
					<td class="text-center"><a href="anticorps/index/fournisseur">Fournisseur</a></td>
					<td class="text-center"><a href="anticorps/index/id_source">Source</a></td>
					<td class="text-center"><a href="anticorps/index/reference">Référence</a></td>
					<td class="text-center"><a href="anticorps/index/clone">Clone</a></td>
					<td class="text-center"><a href="anticorps/index/lot">lot</a></td>
					<td class="text-center"><a href="anticorps/index/id_isotype">Isotype</a></td>
					<td class="text-center"><a href="anticorps/index/stockage">Stockage</a></td>
					<td class="text-center"><a href="anticorps/"><p style="border-bottom: 1px solid #f1f1f1">Tissus</p> espèce - organe - validé - ref. bloc - dilution - temps d'incubation -  ref. protocol</a></td>
					<td class="text-center"><a href="anticorps/"><p style="border-bottom: 1px solid #f1f1f1">Propriétaire</p> Nom - disponibilité - Date réception</a></td>
					<td></td>
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
				    
				    <td class="text-center" style="min-width: 300px; "><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  . $tissus[$i]['espece'] . " - "
		                                . $tissus[$i]['organe'] . " - "
		                                . $tissus[$i]['valide'] . " - "
										. $tissus[$i]['ref_bloc'] . " - "
										. $tissus[$i]['dilution'] . " - "
										. $tissus[$i]['temps_incubation'] . " - "
										. $tissus[$i]['ref_protocol'] . "</p>";  
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
					    	$txt = $this->clean ( $name ) . " - " . $this->clean($dispo) . " - " . $this->clean($date_recept); 
					    	
					    	if ($this->clean($dispo) == "épuisé"){
					    		echo '<p style="background-color:#ff0000; color:#fff">' . $txt . '</p>';
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
