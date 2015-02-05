<?php $this->title = "Modules manager"?>

<?php echo $navBar?>
<?php 
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Modules_configuration($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<?php 

		foreach ($modules as $module){
		?>
		<div>
			<h2><?= $module['name'] ?> </h2>
			
			<div class="col-md-12">
			<div class="col-md-10 col-md-offset-1">
			<?php include $module['abstract'] ?>
			</div>
			</div>
			
			<div class="col-md-2 col-md-offset-10">
			<button type='button' onclick="location.href='<?= $module['action'] ?>'" 
			         class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Config($lang)?></button>
			</div>
		</div>
		<?php			
		}
		?>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
