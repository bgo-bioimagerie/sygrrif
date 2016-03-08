<?php $this->title = "Supplies Items"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="col-md-6 col-md-offset-3">
	<?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

