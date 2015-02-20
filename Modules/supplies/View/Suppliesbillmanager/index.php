<?php $this->title = "Supplies Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= SuTranslator::Supplies_bill($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="suppliesbillmanager/index/id">ID</a></td>
					<td><a href="suppliesbillmanager/index/number"><?= SuTranslator::Number($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/date_generated"><?= SuTranslator::Date_Generated($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/date_paid"><?= SuTranslator::Date_Paid($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/is_paid"><?= SuTranslator::Is_Paid($lang) ?></a></td>
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
				    <td><?= $this->clean ( $bill ['date_generated'] ); ?></td>
				    <td><?= $this->clean ( $bill ['date_paid'] ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $bill ['is_paid'] );
				    if ($is_active){$is_active = "yes";}
				    else{$is_active = "no";}
				    ?>
				    <td><?= $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='suppliesbillmanager/edit/<?= $itemId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button>
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

