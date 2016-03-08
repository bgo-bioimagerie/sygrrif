<?php $this->title = "SyGRRiF Statistics"?>

<?php echo $navBar?>

<head>
	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
	
<?php include "Modules/sygrrif/View/navbar.php"; 
require_once 'Modules/core/Model/CoreTranslator.php';
?>

<br>
<div class="container">
    <?php echo $formHtml ?>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
