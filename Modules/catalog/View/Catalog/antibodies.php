<?php include('Modules/catalog/View/Catalog/toolbar.php') ?>


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
	                     { "bSearchable": true },
	                     null,
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true },
	                     { "bSearchable": true }
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


<div class="col-md-12" style="height:15px">
    
</div>

	<div class="col-md-12">
	
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        
                        <tr>
                            <th class="text-center" colspan="7" style="width:75%; color:#337AB7;">Anticorps</th>
                            <th class="text-center" colspan="4" style="width:25%; background-color: #eeffee; color:#337AB7;">Tissus</th>
                        </tr>
                        
			<tr>
                            <th class="text-center" style="width:5%; color:#337AB7;"></th>
                            <th class="text-center" style="width:5%; color:#337AB7;">No</th>
                            <th class="text-center" style="width:5%; color:#337AB7;"><?php echo CaTranslator::Name($lang) ?></th>
                            <th class="text-center" style="width:5%; color:#337AB7;"><?php echo CaTranslator::Ranking($lang) ?></th>
                            <th class="text-center" style="width:5%; color:#337AB7;"><?php echo CaTranslator::Staining($lang) ?></th>
                            <th class="text-center" style="width:5%; color:#337AB7;"><?php echo CaTranslator::Provider($lang) ?></th>
                            <th class="text-center" style="width:5%; color:#337AB7;"><?php echo CaTranslator::Reference($lang) ?></th>
                            <th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;"><?php echo CaTranslator::Spices($lang) ?></th>
                            <th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;"><?php echo CaTranslator::Sample($lang) ?></th>
                            <th class="text-center" style="width:5%; background-color: #eeffee; color:#337AB7;"><?php echo CaTranslator::Status($lang) ?></th>
                        </tr>    
                                
			</thead>
                     
			<tbody>
                            <?php foreach ( $entries as $entry ) : ?> 
                            <tr>
                                <td width="10%" class="text-left">
                                    <?php
                                    $imageFile = "data/catalog/" . $entry["image_url"];
                                    if (!file_exists($imageFile)){
                                        $imageFile = "Modules/catalog/View/images_icon.png";
                                    }
                                    list($width, $height, $type, $attr) = getimagesize($imageFile);
                                    ?>
                                    <a href="<?php echo $imageFile?>" itemprop="contentUrl" data-size="<?php echo $width?>x<?php echo $height?>">
                                        <img src="<?php echo $imageFile?>" itemprop="thumbnail" alt="photo" width="25" height="25"/>
                                    </a>
                                </td>
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['no_h2p2'] ); ?></td>
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['nom'] ); ?></td> 
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['ranking'] ); ?></td> 
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['staining'] ); ?></td>
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['fournisseur'] ); ?></td> 
                                <td width="10%" class="text-left"><?php echo  $this->clean ( $entry ['reference'] ); ?></td> 
                                
                                <!-- Tissus -->
                                <td width="10%" class="text-left" style="background-color: #eeffee;">
                                    <?php 
				    	$tissus = $entry ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>"  . $tissus[$i]['espece'] 
										. "</p>";  
				    	}			    	
                                        echo $val;
                                    ?>
				</td>
                                
                                <td width="10%" class="text-left" style="background-color: #eeffee;"><?php 
				    	$tissus = $entry ['tissus'];
				    	$val = "";
				    	for( $i = 0 ; $i < count($tissus) ; ++$i){
				    		$val = $val . "<p>" 
                                                . $tissus[$i]['prelevement']
						. "</p>";  
				    	}			    	
					echo $val;
                                        ?>
                                </td>
                                
                                <td width="10%;" class="text-left" style="background-color: #eeffee;">
                                    <?php 
				    	$tissus = $entry ['tissus'];
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
				    ?>
                                </td>
                                
                            </tr>
                            <?php endforeach; ?>
				
			</tbody>
                </table>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

