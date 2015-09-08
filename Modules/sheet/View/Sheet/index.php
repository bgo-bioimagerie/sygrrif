<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   
</head>



<?php include "Modules/sheet/View/navbar.php"; ?>


<div class="col-xs-10">

</div> 

    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>