
<?php
include_once 'Modules/web/Model/WbTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo WbTranslator::WbConfigAbstract($lang); ?>
</p>
