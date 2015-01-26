
<style>
#colorparagraph{
	height:25px;
	border-radius:5px;
}

</style>

<div class="col-lg-12">

	<div class="page-header">
		<h4>
			Color code <br> <small></small>
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
	
	<div class="col-xs-1">
		<p class="text-center" id="colorparagraph" style="background-color: #<?=$color?>;"><?=$name?></p>
	</div>
	<?php 
		if ($cmpt == 12 || $i == count($colorcodes)-1){
		?>
			</div>
			<?php 
			$cmpt=0;
		}	
	}
	?>

</div>

