<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Themes/navbar-fixed-top.css" rel="stylesheet">
    
</head>
    
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?php echo Configuration::get("name"); ?> </a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="home">Accueil</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">data <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<?php 
        				foreach ($toolMenu as $key => $value) {
        					echo "<li><a href= $key > $value </a></li>";
        				}
        			?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">admin <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
				      <?php 
        				foreach ($toolAdmin as $key => $value) {
        					echo "<li><a href= $key > $value </a></li>";
        				}
        			  ?>
					</ul>
				</li>
				<!-- <li><a href="#contact">Help</a></li>  -->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?= $userName ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
        				<li><a href=users/manageaccount > My Account </a></li>
        				<li class="divider"></li>
        				<li><a href=connection/logout > logout </a></li>
					</ul>
				</li>

			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
