
<?php
include_once 'Modules/template/Model/TeTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo TeTranslator::TeConfigAbstract($lang); ?>
</p>
