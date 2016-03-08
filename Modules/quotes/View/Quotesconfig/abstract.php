
<?php
include_once 'Modules/quotes/Model/QoTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo QoTranslator::QoConfigAbstract($lang); ?>
</p>
