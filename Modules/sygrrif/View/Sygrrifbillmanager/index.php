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
			<?php echo  SyTranslator::Sygrrif_Bills($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div style="height:25px"></div>
		<button type='button' onclick="location.href='sygrrifbillmanager/export'"
						class="btn btn-xs btn-primary"><?php echo  SyTranslator::Export($lang) ?></button>
		<div style="height:25px"></div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<!--  <td><a href="sygrrifbillmanager/index/id">ID</a></td>  -->
					<td><a href="sygrrifbillmanager/index/number"><?php echo  SyTranslator::Number($lang) ?></a></td>
					<?php if ($projectStatus > 0){
						?>
						<td><a href="sygrrifbillmanager/index/id_project"><?php echo  SyTranslator::Project($lang) ?></a></td>
					<?php }
					else{
						?>
						<td><a href="sygrrifbillmanager/index/responsible"><?php echo  SyTranslator::Responsible($lang) ?></a></td>
						<td><a href="sygrrifbillmanager/index/unit"><?php echo  SyTranslator::Unit($lang) ?></a></td>
						<?php
					}
					?>
					<td><a href="sygrrifbillmanager/index/period_begin"><?php echo  SyTranslator::Period_begin($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/period_end"><?php echo  SyTranslator::Period_end($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/date_generated"><?php echo  SyTranslator::Date_Generated($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/total_ht"><?php echo  SyTranslator::TotalHT($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/date_paid"><?php echo  SyTranslator::Date_Paid($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/is_paid"><?php echo  SyTranslator::Is_Paid($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $billsList as $bill ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $bill ['id'] ); ?>
					 <!-- <td><?php echo  $itemId ?></td>  -->
				    <td><?php echo  $this->clean ( $bill ['number'] ); ?></td>
				    <?php if ($projectStatus > 0){
						?>
						<td><?php echo  $this->clean ( $bill ['id_project'] ); ?></td>
					<?php }
					else{
						?>
						<td><?php echo  $this->clean ( $bill ['resp_name'] . " " . $bill ['resp_firstname'] ); ?></td>
						<td><?php echo  $this->clean ( $bill ['unit'] ); ?></td>
						<?php
					}
					?>
				    <td><?php echo  $this->clean ( CoreTranslator::dateFromEn( $bill ['period_begin'], $lang) ); ?></td>
				    <td><?php echo  $this->clean ( CoreTranslator::dateFromEn( $bill ['period_end'], $lang) ); ?></td>
				    <td><?php echo  $this->clean ( CoreTranslator::dateFromEn( $bill ['date_generated'], $lang) ); ?></td>
				    <td><?php echo  $this->clean ( $bill ['total_ht'] ); ?></td>
				    <td><?php echo  $this->clean ( CoreTranslator::dateFromEn( $bill ['date_paid'], $lang) ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $bill ['is_paid'] );
				    if ($is_active){$is_active = SyTranslator::Yes($lang);}
				    else{$is_active = SyTranslator::No($lang);}
				    ?>
				    <td><?php echo  $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrifbillmanager/edit/<?php echo  $itemId ?>'" class="btn btn-xs btn-primary"><?php echo  SyTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

