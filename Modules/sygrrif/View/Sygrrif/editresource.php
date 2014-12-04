<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

#tarif{
	text-align: center;
	width: 30%;
}

</style>


</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<?php
if ($typeEdit == 1){
	include "Modules/sygrrif/View/Sygrrif/editresourcecalendar.php";
}
else{
	include "Modules/sygrrif/View/Sygrrif/editresourcequantity.php";
}
	
?>


<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
