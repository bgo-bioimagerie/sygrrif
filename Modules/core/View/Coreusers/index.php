<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<?php include "Modules/Core/View/usersnavbar.php"; ?>

<br>
	<div class="col-lg-12">

		<?php echo  $tableHtml ?>
	</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
