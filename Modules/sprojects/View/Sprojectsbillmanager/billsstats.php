<?php $this->title = "sprojects Bills"?>

<?php echo $navBar?>

<head>

</head>

<?php include "Modules/sprojects/View/navbar.php"; ?>

<br>
<div class="col-md-6 col-md-offset-3">	
		<?php echo $formHtml ?>
</div>

<?php if ($stats != ""){
	?>
<div class="col-md-6 col-md-offset-3">
		<div class="page-header">
			<h1>
				<?php echo  SpTranslator::Statistics($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="col-md-12">
		    <table class="table table-striped table-bordered">
	      		<tr>
	      			<td><?php echo SpTranslator::TotalNumberOfBills($lang) ?></td>
	      			<td><?php echo $stats["totalNumberOfBills"] ?></td>
	      		</tr>
	      		<tr>
	      			<td><?php echo SpTranslator::TotalPrice($lang) ?></td>
	      			<td><?php echo $stats["totalPrice"] . " € HT"?></td>
	      		</tr>
	      		
	      		<tr>
	      			<td></td>
	      			<td></td>
	      		</tr>
	      		<tr>
	      			<td><?php echo SpTranslator::NumberOfAcademicBills($lang) ?></td>
	      			<td><?php echo $stats["numberOfAcademicBills"] ?></td>
	      		</tr>
	      		<tr>
	      			<td><?php echo SpTranslator::TotalPriceOfAcademicBills($lang) ?></td>
	      			<td><?php echo $stats["totalPriceOfAcademicBills"] . " € HT"?></td>
	      		</tr>
	
	      		<tr>
	      		<td></td>
	      		<td></td>
	      		</tr>
	      		
	      		<tr>
	      			<td><?php echo SpTranslator::NumberOfPrivateBills($lang) ?></td>
	      			<td><?php echo $stats["numberOfPrivateBills"] ?></td>
	      		</tr>
	      		<tr>
	      			<td><?php echo SpTranslator::TotalPriceOfPrivateBills($lang) ?></td>
	      			<td><?php echo $stats["totalPriceOfPrivateBills"] . " € HT"?></td>
	      		</tr>
      		</table>
		</div>
</div>
<?php }?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

