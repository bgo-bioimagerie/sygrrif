<?php $this->title = "Supplies Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Sygrrif_Bills($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrifbillmanager/index/id">ID</a></td>
					<td><a href="sygrrifbillmanager/index/number"><?= SyTranslator::Number($lang) ?></a></td>
					<td><a href="sygrrifbillmanager/index/date_generated"><?= SyTranslator::Date_Generated($lang) ?></a></td>
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
					<td><?= $itemId ?></td>
				    <td><?= $this->clean ( $bill ['number'] ); ?></td>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['date_generated'], $lang) ); ?></td>
				    <td><?= $this->clean ( CoreTranslator::dateFromEn( $bill ['date_paid'], $lang) ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $bill ['is_paid'] );
				    if ($is_active){$is_active = "yes";}
				    else{$is_active = "no";}
				    ?>
				    <td><?= $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrifbillmanager/edit/<?= $itemId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
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

