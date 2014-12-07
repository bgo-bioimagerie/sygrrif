<?php $this->title = "Modules manager"?>

<?php echo $navBar?>
<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Modules configuration<br> <small></small>
			</h1>
		</div>
		
		<?php 

		foreach ($modules as $module){
		?>
		<div>
			<h2><?= $module['name'] ?> </h2>
			
			<div class="col-md-12">
			<div class="col-md-10 col-md-offset-1">
			<?= $module['abstract'] ?>
			</div>
			</div>
			
			<div class="col-md-2 col-md-offset-10">
			<button type='button' onclick="location.href='<?= $module['action'] ?>'" 
			         class="btn btn-xs btn-primary" id="navlink">Config</button>
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
