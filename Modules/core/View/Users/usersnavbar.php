
<head>

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
		<h2><?= CoreTranslator::Users_Institutions($lang) ?></h2>
		<div class="col-md-9 col-md-offset-3">
		
				<div class="col-md-12">
				    <button onclick="location.href='units/'" class="btn btn-link" id="navlink"><?= CoreTranslator::Units($lang) ?></button>
					<button onclick="location.href='units/add'" class="btn btn-link" id="navlink"><?= CoreTranslator::Add_unit($lang) ?></button>
				</div>

				<div class="col-md-12">
					<button onclick="location.href='users'" class="btn btn-link" id="navlink"><?= CoreTranslator::Active_Users($lang) ?> </button>
					<button onclick="location.href='users/unactiveusers'" class="btn btn-link" id="navlink"><?= CoreTranslator::Unactive_Users($lang) ?></button>
					<button onclick="location.href='users/add'" class="btn btn-link" id="navlink"><?= CoreTranslator::Add_User($lang) ?></button>
				</div>
		</div>
	</div>
</div>


