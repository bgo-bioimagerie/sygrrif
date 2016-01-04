
<?php
include_once 'Modules/catalog/Model/CaTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo CaTranslator::CaConfigAbstract($lang); ?>
</p>
