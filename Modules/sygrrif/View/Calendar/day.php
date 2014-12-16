<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sygrrif/View/Calendar/navbar.php"; ?>

<p>
ADD HERE THE CALENDAR
</p>


<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
