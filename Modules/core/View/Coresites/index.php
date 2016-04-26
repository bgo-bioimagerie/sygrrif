<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/core/View/sitesnavbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-10 col-md-offset-1">
	
		<?php echo  $tableHtml ?>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
