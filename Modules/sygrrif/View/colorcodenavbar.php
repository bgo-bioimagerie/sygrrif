
<style>
#colorparagraph{
	height:25px;
	border-radius:5px;
}

</style>

<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>

<div class="col-lg-12">
<br/>
<br/>
	<div class="page-header">
		<h4>
			<?= SyTranslator::color_code($lang) ?>
			<br> <small></small>
		</h4>
	</div>

	<?php 
	$cmpt = 0;
	for ($i = 0 ; $i < count($colorcodes) ; $i++){
		$colorcode = $colorcodes[$i];
		$name = $this->clean($colorcode["name"]);
		$color = $this->clean($colorcode["color"]);
		$cmpt++;
	if ($cmpt == 1){
		?>
		<div class="col-lg-12">
		<?php 
	}	
	?>
	
	<div class="col-xs-2">
		<p class="text-center" id="colorparagraph" style="background-color: #<?=$color?>;"><?=$name?></p>
	</div>
	<?php 
		if ($cmpt == 6 || $i == count($colorcodes)-1){
		?>
			</div>
			<?php 
			$cmpt=0;
		}	
	}
	?>

</div>

