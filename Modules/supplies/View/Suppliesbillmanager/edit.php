<?php $this->title = "Supplies Bill"?>

<?php echo $navBar?>

<head>

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>


<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-12">
            <?php echo $formHtml ?>
        </div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
