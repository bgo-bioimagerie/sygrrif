<?php 
require_once 'Modules/core/Model/CoreConfig.php';
$modelCoreConfig = new CoreConfig();
$coremenucolor = $modelCoreConfig->getParam("coremenucolor");
$coremenucolortxt = $modelCoreConfig->getParam("coremenucolortxt");
if ($coremenucolor == ""){
	$coremenucolor = "#337ab7";
}
if($coremenucolortxt == ""){
	$coremenucolortxt = "#ffffff";
}
?>

<head>

<style>
.bs-docs-header {
	position: relative;
	padding: 30px 15px;
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo  $coremenucolor ?>;
}

#navlink {
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.bs-docs-header {
	position: relative;
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: <?php echo  $coremenucolor ?>;
}

#navlink {
	color: <?php echo  $coremenucolortxt ?>;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: <?php echo  $coremenucolortxt ?>;
	background-color: <?php echo  $coremenucolor ?>;
	border: none;
	-moz-box-shadow: 0px 0px px #000000;
-webkit-box-shadow: 0px 0px px #000000;
-o-box-shadow: 0px 0px 0px #000000;
box-shadow: 0px 0px 0px #000000;
}

legend {
	color: <?php echo  $coremenucolortxt ?>;
}
</style>

</head>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}

$classWell = 'col-md-3 well';
?>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h2><?php echo  WbTranslator::Web($lang) ?></h2>

		<div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  WbTranslator::Menu($lang) ?></legend>
                                    <button onclick="location.href='wbmenu/'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Menu($lang) ?></button>
				<br/>
                                    <button onclick="location.href='wbmenu/links'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Links($lang) ?></button>
				<!--
                                    <br/>	
                                    <button onclick="location.href='wbmenu/stylesheet'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Stylesheet($lang) ?></button>
                                -->
                </fieldset>
		</div>
		<div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  WbTranslator::Home($lang) ?></legend>
                                    <button onclick="location.href='wbhomeadmin/carousel'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Carousel($lang) ?></button>
				<br/>
                                    <button onclick="location.href='wbhomeadmin/features'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Features($lang) ?></button>
				<br/>	
                                    <button onclick="location.href='wbhomeadmin/events'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Events($lang) ?></button>
                                <br/>	
                                    <button onclick="location.href='wbhomeadmin/news'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::News($lang) ?></button>
                        
                        </fieldset>
		</div>
                <div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  WbTranslator::Pages($lang) ?></legend>
                                    <button onclick="location.href='wbsubmenus'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Submenus($lang) ?></button>
				    <button onclick="location.href='wbsubmenus/edit/0'" class="btn btn-link" id="navlink">+</button>
                                <br/> 
                                    <button onclick="location.href='wbsubmenus/items'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Submenusitems($lang) ?></button>
				    <button onclick="location.href='wbsubmenus/edititem/0'" class="btn btn-link" id="navlink">+</button>
                                <br/> 
                                    <button onclick="location.href='Wbarticleslistadmin'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::ArticlesList($lang) ?></button>
				    <button onclick="location.href='Wbarticleslistadmin/edit/0'" class="btn btn-link" id="navlink">+</button>
                                
                                <br/> 
                                    <button onclick="location.href='wbarticlesadmin'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Articles($lang) ?></button>
				    <button onclick="location.href='wbarticlesadmin/edit/0'" class="btn btn-link" id="navlink">+</button>
                                   
                                    
                                    
                        </fieldset>
		</div>
                <div class=<?php echo  $classWell ?> >
			<fieldset>
				<legend><?php echo  WbTranslator::Contact($lang) ?></legend>
                                    <button onclick="location.href='wbcontactadmin'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::Contact($lang) ?></button>
				<br/>
                                    <button onclick="location.href='wbteamadmin'" class="btn btn-link" id="navlink"><?php echo  WbTranslator::People($lang) ?></button>
                                    <button onclick="location.href='wbteamadmin/edit/0'" class="btn btn-link" id="navlink">+</button>
                        </fieldset>
		</div>
		
	</div>
</div>


