
<?php
include_once 'Modules/bioseapp/Model/BiTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo BiTranslator::BiConfigAbstract($lang); ?>
</p>
