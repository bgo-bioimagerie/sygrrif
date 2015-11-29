
<?php
include_once 'Modules/sprojects/Model/SpTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo SpTranslator::SpConfigAbstract($lang); ?>
</p>
