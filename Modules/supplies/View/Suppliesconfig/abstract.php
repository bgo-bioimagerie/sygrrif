
<?php
include_once 'Modules/supplies/Model/SuTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo SuTranslator::SuConfigAbstract($lang); ?>
</p>
