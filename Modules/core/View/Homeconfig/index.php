<?php $this->title = "Platform-Manager"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<?php echo $formHtml ?> 
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
