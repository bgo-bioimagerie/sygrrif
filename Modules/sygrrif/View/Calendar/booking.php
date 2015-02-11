<?php $this->title = "SyGRRiF Booking"?>

<?php echo $navBar?>

<head>
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

<?= SyTranslator::Select_a_resource_on_the_navigation_bar($lang) ?>

</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
