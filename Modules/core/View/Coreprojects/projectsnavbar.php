
<head>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">

<style>
.bs-docs-header {
	position: relative;
	padding: 30px 15px;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}
</style>

</head>

<?php 
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h2><?php echo  CoreTranslator::Projects($lang) ?> </h2>
		<div class="col-md-9 col-md-offset-3">
		
				<div class="col-md-12">
				    <button onclick="location.href='projects/index'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Projects($lang) ?></button>
					<button onclick="location.href='projects/add'" class="btn btn-link" id="navlink"><?php echo  CoreTranslator::Add_project($lang) ?></button>
				</div>
		</div>
	</div>
</div>


