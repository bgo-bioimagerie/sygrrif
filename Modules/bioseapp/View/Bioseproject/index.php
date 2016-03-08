<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>
<?php include "Modules/bioseapp/View/Bioseproject/tabs.php"; ?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
	<!-- Main component for a primary marketing message or call to action -->
	
	<?php //echo $tableHtml ?>
        
</div> <!-- /container -->




<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif;
