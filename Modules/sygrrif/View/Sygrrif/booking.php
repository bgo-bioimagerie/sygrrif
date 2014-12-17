<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#desc{
	border: 1px dashed #aaaaaa;
	height: 200px;
	padding-top:95px;
	color: #aaaaaa;
}

</style>


</head>


<?php include "Modules/sygrrif/View/bookingnavbar.php"; ?>

<br></br>

<div class="col-lg-6 col-lg-offset-3">

<div id="desc" class="text-center">

Select a resource on the navigation bar


</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
