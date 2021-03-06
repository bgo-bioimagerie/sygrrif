<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>

<link rel="stylesheet" href="externals/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="externals/fixedHeaderTable/dataTables.bootstrap.css">
<link rel="stylesheet" href="externals/fixedHeaderTable/dataTables.fixedHeader.css">

<script src="externals/jquery-1.11.1.js"></script>
<script src="externals/fixedHeaderTable/jquery.dataTables.js"></script>
<script src="externals/fixedHeaderTable/dataTables.fixedHeader.min.js"></script>
<script src="externals/fixedHeaderTable/dataTables.bootstrap.js"></script>

<style>
body { font-size: 120%; padding: 1em; margin-top:30px; margin-left: -15px;}
div.FixedHeader_Cloned table { margin: 0 !important }

table{
  white-space: nowrap;
}

thead tr{
  height: 50px;
}

</style>

<script>
$(document).ready( function() {
	       $('#example').dataTable( {
	       "aoColumns": [
	                     { "bSearchable": false },
	                     null,
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false },
	                     { "bSearchable": false }
	                   ],
	       "lengthMenu": [[100, 200, 300, -1], [100, 200, 300, "All"]]
	       }
	        );
	     } );
</script>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable();
    new $.fn.dataTable.FixedHeader( table, {
        alwaysCloneTop: true
    });

} );
</script>



</head>

<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="contatiner">

<div class="col-md-2 col-md-offset-10">
<br/>
<button type="button" onclick="location.href='anticorps/anticorpscsv'" class="btn btn-primary"><?php echo  SyTranslator::Export_as_csv($lang) ?></button>
</div>	
	<div class="col-md-12">
		<div class="page-header" style="margin-top: -20px;">
			<h1>
				Anticorps<br> <small></small>
			</h1>
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
				if(!isset($searchColumn)){
					$searchColumn = "";
				}
				if(!isset($searchCom)){
					$searchCom = "";
				}
				
				?>
				<div class="col-md-12">
					<label class="control-label col-md-1">Recherche Avancée:</label>
					
					<div class="col-md-9">
						<label class="control-label col-md-1" style="margin:0px;">Nom:</label>
						<div class="col-md-3">
							<input class="form-control" id="searchName" type="text" name="searchName" value="<?php echo  $searchName ?>"
							/>
						</div>
                                               
						<label for="inputEmail" class="control-label col-md-1">No H2P2:</label>
						<div class="col-md-2">
							<input class="form-control" id="searchNoH2P2" type="text" name="searchNoH2P2" value="<?php echo  $searchNoH2P2 ?>"
							/>
						</div>
						<label for="inputEmail" class="control-label col-md-2">Source:</label>
						<div class="col-md-3">
							<input class="form-control" id="searchSource" type="text" name="searchSource" value="<?php echo  $searchSource ?>"
							/>
						</div>
					</div>
					<label class="control-label col-md-2"></label>
				</div>
				
				<div class="col-md-12">
					<label class="control-label col-md-1"></label>
					<div class="col-md-9">	
						<label for="inputEmail" class="control-label col-md-1">Tissu cible:</label>
						<div class="col-md-3">
							<input class="form-control" id="searchCible" type="text" name="searchCible" value="<?php echo  $searchCible ?>"
							/>
						</div>
						
						<label for="inputEmail" class="control-label col-md-1">Statut:</label>
						<div class="col-md-2">
							<select class="form-control" id="searchValide" name="searchValide">
								<OPTION value="0" <?php if($searchColumn=="0"){echo $selected;} ?> >  </OPTION>
								<OPTION value="1" <?php if($searchValide=="1"){echo $selected;} ?> > Validé </OPTION>
								<OPTION value="2" <?php if($searchValide=="2"){echo $selected;} ?> > Non validé </OPTION>
								<OPTION value="3" <?php if($searchValide=="3"){echo $selected;} ?> > Non testé </OPTION>
							</select>
						</div>
						
						<label for="inputEmail" class="control-label col-md-2">Propriétaire:</label>
						<div class="col-md-3">
							<input class="form-control" id="searchResp" type="text" name="searchResp" value="<?php echo  $searchResp ?>"
							/>
						</div>
						<label class="control-label col-md-2"></label>
					</div>
				</div>
				<div class="col-md-12">
				<label class="control-label col-md-1"></label>
					<div class="col-md-9">
						<div class="col-md-11">	
							<label class="control-label col-md-1">Commentaire:</label>
								<div class="col-md-4">
								<input class="form-control" id="searchCom" type="text" name="searchCom" value="<?php echo  $searchCom ?>"
								/>
							</div>
						</div>	
					</div>
			
					<div class="col-md-2" id="button-div">
			        	<input type="submit" class="btn btn-primary" value="Rechercher" />
					</div>
				</div>
      		</form>
		</div>
		
				<div class="col-md-12" style="margin-top: 15px;">
			<p></p><br/>
		</div>
	
	<div class="col-md-12">
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>	 
				<tr>
					<th class="text-center" colspan="10" style="width:45%; color:#337AB7;">Anticorps</th>
					<th class="text-center" colspan="2" style="width:10%; background-color: #ffeeee; color:#337AB7;">Protocole</th>
					<th class="text-center" colspan="6" style="width:25%; background-color: #eeffee; color:#337AB7;">Tissus</th>
					<th class="text-center" colspan="4" style="width:20%; background-color: #eeeeff; color:#337AB7;">Propriétaire</th>
				</tr>
				 
				<tr>			
                                        <th></th>
					<th class="text-center" style="width:1em; color:#337AB7;">No</th> 
					<th class="text-center" style="width:5%; color:#337AB7;">Nom</th>
					<th class="text-center" style="width:2%; color:#337AB7;">St</th>
					<th class="text-center" style="width:5%; color:#337AB7;">Fournisseur</th>
					<th class="text-center" style="width:5%; color:#337AB7;">Source</th>
					<th class="text-center" style="width:5%; color:#337AB7;">Référence</th>
					<th class="text-center" style="width:5%; color:#337AB7;">Clone</th>
					<th class="text-center" style="width:5%; color:#337AB7;">lot</th>
					<th class="text-center" style="width:5%; color:#337AB7;">Isotype</th>
								
					<th class="text-center" style="width:5%; background-color: #ffeeee; color:#337AB7;">proto</th>
					<th class="text-center" style="width:5%; background-color: #ffeeee; color:#337AB7;">AcI dil</th>
					
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">commentaire</th>
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">espèce</th>
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">organe</th>
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">statut</th>
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">ref. bloc</th>
					<th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;">prélèvement</th>	
					
					<th class="text-center" style="width:5em; background-color: #eeeeff; color:#337AB7;">Nom</th>
					<th class="text-center" style="width:5%; background-color: #eeeeff; color:#337AB7;">disponibilité</th>
					<th class="text-center" style="width:5%; background-color: #eeeeff; color:#337AB7;">Date réception</th>
					<th class="text-center" style="width:5%; background-color: #eeeeff; color:#337AB7;">No Dossier</th>
					
				</tr>
			</thead>
			
			<tbody>
				<?php foreach ( $anticorpsArray as $anticorps ) : ?> 
                                
				<tr>
                                    <td width="10%" class="text-left">
                                    <?php
                                    $imageFile = "data/antibodies/" . $anticorps["image_url"];
                                    if (!file_exists($imageFile) || is_dir($imageFile)){
                                        $imageFile = "Modules/catalog/View/images_icon.png";
                                    }
                                    list($width, $height, $type, $attr) = getimagesize($imageFile);
                                    ?>
                                    <a href="<?php echo $imageFile?>" itemprop="contentUrl" data-size="<?php echo $width?>x<?php echo $height?>">
                                        <img src="<?php echo $imageFile?>" itemprop="thumbnail" alt="photo" width="25" height="25"/>
                                    </a>
                                </td>
					<?php $anticorpsId = $this->clean ( $anticorps['id'] ); 
                                        $isCatalogue = "";
                                        if ($anticorps['export_catalog'] == 1){
                                            $isCatalogue = " (c)";
                                        } 
                                        ?>
					
					<td style="width:1em;" class="text-left"><a href="anticorps/edit/<?php echo  $anticorpsId ?>"><?php echo  $this->clean ( $anticorps ['no_h2p2'] . $isCatalogue ); ?></a></td>
					<td width="5%" class="text-left"><a href="anticorps/edit/<?php echo  $anticorpsId ?>"><?php echo  $this->clean ( $anticorps ['nom'] ); ?></a></td>
					<td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['stockage'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['fournisseur'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['source'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['reference'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['clone'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['lot'] ); ?></td>
				    <td width="5%" class="text-left"><?php echo  $this->clean ( $anticorps ['isotype'] ); ?></td>
				    
				    
				    
				    <!--  PROTOCOLE -->
				     <td width="5%" class="text-left" style="background-color: #ffeeee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		
				    		if($tissus[$i]['ref_protocol'] == "0"){
				    			$val .= "<p>Manuel</p>";
				    		}
				    		else{
				    			$val .= "<p><a href=\"protocols/protoref/" . $anticorps ['id'] . "\">"  
										. $tissus[$i]['ref_protocol'] . "</a></p>";
				    		}  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				    <td width="5%" class="text-left" style="background-color: #ffeeee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  
										. $tissus[$i]['dilution']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				    <!-- TISSUS -->
				    <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['comment']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  . $tissus[$i]['espece'] 
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
		                                . $tissus[$i]['organe']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				     <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		
				    		$statusTxt = "";
				    		$background = "#ffffff";
				    		foreach($status as $stat){
				    			if ($tissus[$i]['status'] == $stat["id"]){
				    				$statusTxt = $stat['nom'];
				    				$background = $stat["color"];
				    			}
				    		}
				    		$val = $val . "<p style=\"background-color: #".$background."\">" 
		                                . $statusTxt
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    
				     <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['ref_bloc']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
				    
				    <td width="5%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $anticorps ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
										. $tissus[$i]['prelevement']
										. "</p>";  
				    	}			    	
					    echo $val;
				    ?></td>
			
				    
				   

				    <td width="5%" class="text-left" style="width:5em; background-color: #eeeeff;"><?php
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
				    
				    <td width="5%" class="text-left" style="background-color: #eeeeff;"><?php
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
				    
				    <td width="5%" class="text-left" style="background-color: #eeeeff;"><?php
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
				   
				    <td width="5%" class="text-left" style="background-color: #eeeeff;"><?php
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
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
			
		</table>
		</div>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
