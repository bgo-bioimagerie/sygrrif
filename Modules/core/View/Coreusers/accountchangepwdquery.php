<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<?php 
require_once 'Modules/core/Model/CoreTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				<?php echo  CoreTranslator::Change_password($lang); ?>  <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> <?php echo  CoreTranslator::Unable_to_change_the_password($lang) ?></p>
			<p> <?php echo  $msgError ?></p>
		<?php }else{?>
			<p> <?php echo  CoreTranslator::The_password_has_been_successfully_updated($lang) ?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='coreusers'" class="btn btn-success" id="navlink"><?php echo  CoreTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>