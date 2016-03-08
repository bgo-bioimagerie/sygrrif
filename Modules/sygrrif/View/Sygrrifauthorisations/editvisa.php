<?php $this->title = "SyGRRiF Edit VISA"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>

<?php
include "Modules/sygrrif/View/navbar.php"; 
?>

<br>
	<div class="col-md-6 col-md-offset-3">
	<?php echo $formHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
