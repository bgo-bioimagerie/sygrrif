<?php $this->title = "SyGRRiF Areas"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1> <?= SyTranslator::Areas($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped text-center table-bordered">
			<thead>
				<tr>
				    <th><a href="sygrrif/areas/id">ID</a></th>
					<th><a href="sygrrif/areas/name"><?= SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/pricing/restricted"> <?= SyTranslator::Is_resticted($lang) ?></a></th>
					<th><a href="sygrrif/pricing/display_order"> <?= SyTranslator::Display_order($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $areas as $area ) : ?> 
				<tr>
					<!--  Id -->
					<?php $areaId = $this->clean ( $area ['id'] ); ?>
					<td><?= $areaId ?></td>
				    <!--  name -->
				    <td><?= $this->clean ( $area ['name'] ); ?></td>
				    <!--  restricted -->
				    <td>
				    <?php 
				    	$restricted = $this->clean ( $area ['restricted'] );
						if ($restricted == 1){
							echo "yes";
						}			  
						else{
							echo "no";
						}  
				    ?>
				    </td>
				    <!--  Display order -->
				    <td><?= $this->clean ( $area ['display_order'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editarea/<?= $areaId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
