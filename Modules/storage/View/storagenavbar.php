
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

.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #cdbfe3;
	background-color: #337ab7;
	border: none;
}

legend {
	color: #ffffff;
}
</style>

</head>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<!-- <h2><?php echo  CoreTranslator::Users_Institutions($lang) ?></h2>  -->
		
		
		<div class='col-md-4 well'>
			<fieldset>
					<button onclick="location.href='storage/index'" class="btn btn-link" id="navlink"><?php echo  StTranslator::MyAccount($lang) ?> </button>
				<br/>
					<button onclick="location.href='storage/usersquotas'" class="btn btn-link" id="navlink"><?php echo  StTranslator::Users_quotas($lang) ?></button>
			</fieldset>
		</div>
		
	</div>
</div>


