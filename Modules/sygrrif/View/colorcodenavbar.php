
<style>
#colorparagraph{
	height:25px;
	border-radius:5px;
}

</style>

<div class="col-lg-2">

	<div class="page-header">
		<h4>
			Color code <br> <small></small>
		</h4>
	</div>

	<?php 
	foreach ($colorcodes as $colorcode){
		$name = $this->clean($colorcode["name"]);
		$color = $this->clean($colorcode["color"]);
	?>
		<p class="text-center" id="colorparagraph" style="background-color: #<?=$color?>;"><?=$name?></p>
	<?php 
	}
	?>

</div>

