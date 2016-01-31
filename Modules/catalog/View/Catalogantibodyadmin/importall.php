<?php $this->title = "Catalog admin"?>

<?php echo $navBar?>
<?php include 'Modules/catalog/View/navbar.php' ?>

<br/>
<div class="col-xs-12">
	<div class="col-md-6 col-md-offset-3">
	
		<?php echo CaTranslator::importMessage($lang); ?> 
                <button onclick="location.href='catalogantibodyadmin/importallquery'" class="btn btn-primary">Ok</button>  
        </div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
