<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet">
</head>

<?php include "Modules/petshop/View/petshopnavbar.php"; ?>
<?php include "Modules/petshop/View/Psprojects/tabs.php"; ?>

<br>
<div class="col-md-12">
    <?php echo $tableHtml ?>
</div>

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
    <?php

 endif;
