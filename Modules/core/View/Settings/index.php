<?php $this->title = "User settings"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::User_Settings($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<?php 
		foreach ($modulesControllers as $controller){
			
			// add a link to the module settings
			?>
			<div>
				<div>
				<h2>
					<div class="col-md-10">
					<?php echo  $this->clean($controller["module"])?> 
					</div>
					<div class="col-md-2">
					<button type="button" onclick="location.href='<?php echo  $this->clean($controller["controller"]) ?>'" class="btn btn-primary" id="navlink"><?php echo  CoreTranslator::Edit($lang) ?></button>
					</div>
				</h2>	
				</div>
			</div>
			<?php 
		}
		?>
      
    </div>
</div>