<?php $this->title = "Supplies Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-8 col-md-offset-2">
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Sygrrif_Bills($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div style="height:25px"></div>
		<button type='button' onclick="location.href='sygrrifbillmanager/export'"
						class="btn btn-xs btn-primary"><?= SyTranslator::Export($lang) ?></button>
		<div style="height:25px"></div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<!--  <td><a href="sygrrifbillmanager/index/id">ID</a></td>  -->
					<td><a href="sygrrifbillmanager/index/number"><?= SyTranslator::Number($lang) ?></a></td>
					<?php if ($projectStatus > 0){
						?>
						<td><a href="sygrrifbillmanager/index/id_project"><?= SyTranslator::Project($lang) ?></a></td>
					<?php }
					else{
						?>
						<td><a href="sygrrifbillmanager/index/responsible"><?= SyTranslator::Responsible($lang) ?></a></td>
						<td><a href="sygrrifbillmanager/index/unit"><?= SyTranslator::Unit($lang) ?></a></td>
						<?php
					}
					?>
					<td><a href="sygrrifbillmanager/index/period_begin"><?= SyTranslator::Period_begin($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/period_end"><?= SyTranslator::Period_end($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/date_generated"><?= SyTranslator::Date_Generated($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/total_ht"><?= SyTranslator::TotalHT($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/date_paid"><?= SyTranslator::Date_Paid($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/is_paid"><?= SyTranslator::Is_Paid($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $billsList as $bill ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $bill ['id'] ); ?>
					 <!-- <td><?= $itemId ?></td>  -->
				    <td><?= $this->clean ( $bill ['number'] ); ?></td>
				    <?php if ($projectStatus > 0){
						?>
						<td><?= $this->clean ( $bill ['id_project'] ); ?></td>
					<?php }
					else{
						?>
						<td><?= $this->clean ( $bill ['resp_name'] . " " . $bill ['resp_firstname'] ); ?></td>
						<td><?= $this->clean ( $bill ['unit'] ); ?></td>
						<?php
					}
					?>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['period_begin'], $lang) ); ?></td>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['period_end'], $lang) ); ?></td>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['date_generated'], $lang) ); ?></td>
				    <td><?= $this->clean ( $bill ['total_ht'] ); ?></td>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['date_paid'], $lang) ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $bill ['is_paid'] );
				    if ($is_active){$is_active = SyTranslator::Yes($lang);}
				    else{$is_active = SyTranslator::No($lang);}
				    ?>
				    <td><?= $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrifbillmanager/edit/<?= $itemId ?>'" class="btn btn-xs btn-primary"><?= SyTranslator::Edit($lang) ?></button>
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

