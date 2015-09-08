
<?php 
require_once 'Modules/sheet/Model/ShTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<head>
<style type="text/css">

#navlink {
	color: #585858;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

h2{
    color: #000;
}

legend{
	color: #000;
}
</style>
</head>

<div class="col-xs-2" style="background-color: #fff; height:5000px; border-right: 2px solid #e1e1e1; ">
		<h2><?= ShTranslator::Sheets($lang) ?></h2>
		
		<div class="col-xs-12" >
			<fieldset>
				<legend><?= ShTranslator::Templates($lang) ?></legend>
					<button onclick="location.href='shtemplates/'" class="btn btn-link" id="navlink"><?= ShTranslator::Templates($lang) ?></button>
					<button onclick="location.href='shtemplates/edit'" class="btn btn-link" id="navlink"><?= ShTranslator::Add($lang) ?></button>
			</fieldset>
		</div>
		
		<div class="col-xs-12" style="height: 12px;">
		</div>
		<div class="col-xs-12">
		
			<?php 
			require_once 'Modules/sheet/Model/ShTemplate.php';
			$ShTemplate = new ShTemplate();
			$sheetsTemplates = $ShTemplate->getTemplates("name");
			?>
			<fieldset>
				<legend><?= ShTranslator::Sheets($lang) ?></legend>
					<?php 
					foreach($sheetsTemplates as $template){
						?>
						<button onclick="location.href='sheet/listsheet/<?= $template["id"] ?>'" class="btn btn-link" id="navlink"><?= $template["name"] ?></button>
						<button onclick="location.href='sheet/add/<?= $template["id"] ?>'" class="btn btn-link" id="navlink">+</button>
						<br/>
						<?php 
					}
					?>
			</fieldset>
		</div>

</div>


