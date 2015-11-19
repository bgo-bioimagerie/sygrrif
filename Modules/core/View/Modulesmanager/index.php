<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>
<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Modules_configuration($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<?php 

		foreach ($modules as $module){
		?>
		<div>
			<h2><?php echo  $module['name'] ?> </h2>
			
			<div class="col-md-12">
			<div class="col-md-10 col-md-offset-1">
			<?php include $module['abstract'] ?>
			</div>
			</div>
			
			<div class="col-md-2 col-md-offset-10">
			<button type='button' onclick="location.href='<?php echo  $module['action'] ?>'" 
			         class="btn btn-xs btn-primary" id="navlink"><?php echo  CoreTranslator::Config($lang)?></button>
			</div>
		</div>
		<?php			
		}
		?>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
