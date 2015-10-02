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
			<?php echo  SuTranslator::Supplies_bill($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="suppliesbillmanager/index/id">ID</a></td>
					<td><a href="suppliesbillmanager/index/number"><?php echo  SuTranslator::Number($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/date_generated"><?php echo  SuTranslator::Date_Generated($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/date_paid"><?php echo  SuTranslator::Date_Paid($lang) ?></a></td>
					<td><a href="suppliesbillmanager/index/is_paid"><?php echo  SuTranslator::Is_Paid($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $billsList as $bill ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $bill ['id'] ); ?>
					<td><?php echo  $itemId ?></td>
				    <td><?php echo  $this->clean ( $bill ['number'] ); ?></td>
				    <td><?php echo  $this->clean ( $bill ['date_generated'] ); ?></td>
				    <td><?php echo  $this->clean ( $bill ['date_paid'] ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $bill ['is_paid'] );
				    if ($is_active){$is_active = "yes";}
				    else{$is_active = "no";}
				    ?>
				    <td><?php echo  $is_active; ?></td>
				    <td>
				      <button type='button' onclick="location.href='suppliesbillmanager/edit/<?php echo  $itemId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  CoreTranslator::Edit($lang) ?></button>
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

