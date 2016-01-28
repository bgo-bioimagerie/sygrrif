<?php include('Modules/catalog/View/Catalog/toolbar.php') ?>

<br/>
<div class="col-md-12" style="height:15px"></div>
<div class="contatiner">
	<div class="col-md-12">
	
		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
                                        <th></th>
					<th>No</th>
					<th><?php echo CaTranslator::Name($lang) ?></th>
					<th><?php echo CaTranslator::Provider($lang) ?></th>
                                        <th><?php echo CaTranslator::Reference($lang) ?></th>
                                        <th><?php echo CaTranslator::Spices($lang) ?></th>
                                        <th><?php echo CaTranslator::Comment($lang) ?></th>
				</tr>
			</thead>
                     
			<tbody>
                            <?php foreach ( $entries as $entry ) : ?> 
                            <tr>
                                <td>
                                    <?php
                                    $imageFile = "data/catalog/" . $entry["image_url"];
                                    if (!file_exists($imageFile)){
                                        $imageFile = "Modules/catalog/View/images_icon.png";
                                    }
                                    list($width, $height, $type, $attr) = getimagesize($imageFile);
                                    ?>
                                    <a href="<?php echo $imageFile?>" itemprop="contentUrl" data-size="<?php echo $width?>x<?php echo $height?>">
                                        <img src="<?php echo $imageFile?>" itemprop="thumbnail" alt="photo" width="100" height="100"/>
                                    </a>
                                </td>
                                <td><?php echo  $this->clean ( $entry ['no_h2p2'] ); ?></td>
                                <td><?php echo  $this->clean ( $entry ['nom'] ); ?></td> 
                                <td><?php echo  $this->clean ( $entry ['fournisseur'] ); ?></td> 
                                <td><?php echo  $this->clean ( $entry ['reference'] ); ?></td> 
                                <td><?php echo  $this->clean ( $entry ['especes'] ); ?></td> 
                                <td><?php echo  $this->clean ( $entry ['comment'] ); ?></td> 
                            </tr>
                            <?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

