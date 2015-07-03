<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Themes/navbar-fixed-top.css" rel="stylesheet">
	
</head>

<?php 
require_once 'Modules/core/Model/CoreTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
    
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="padding-left:90px; padding-right:90px;">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=""><img style="height:35px; margin-top: -9px;"
             src="Themes/logo.jpg"></a>
		</div>
		<div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php 
				$refHome = "Home";
				if (isset($_SESSION["user_settings"]["homepage"])){
						$refHome = $_SESSION["user_settings"]["homepage"];
				}	
				?>
			
				<li><a href="<?= $refHome ?>"><?= CoreTranslator::Home($lang) ?></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?= CoreTranslator::Tools($lang) ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<?php 
					
        				foreach ($toolMenu as $tool) {
        					$key = $tool['link'];
        					$value = $tool['name'];
        					?>
        					<li><a href="<?=$key?>" > <?= CoreTranslator::MenuItem($value, $lang) ?> </a></li>
        					<?php
        				}
        			?>
					</ul>
				</li>
				
				<?php 
				if ($toolAdmin){
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= CoreTranslator::Admin($lang) ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
				      <?php 
        				foreach ($toolAdmin as $tool) {
        					$key = $tool['link'];
        					$value = $tool['name'];
        					echo "<li><a href= $key > $value </a></li>";
        				}
        			  ?>
					</ul>
				</li>
				<?php }?>
				<!-- <li><a href="#contact">Help</a></li>  -->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?= $userName ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
        				<li><a href=users/manageaccount > <?= CoreTranslator::My_Account($lang) ?> </a></li>
        				<li><a href=settings > <?= CoreTranslator::Settings($lang) ?> </a></li>
        				<li class="divider"></li>
        				<li><a href=connection/logout > <?= CoreTranslator::logout($lang) ?> </a></li>
					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="externals/jquery-1.11.1.js"></script>
<script src="externals/bootstrap/js/bootstrap.min.js"></script> 
