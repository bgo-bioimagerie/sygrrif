
<?php
include_once 'Modules/agenda/Model/AgTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo AgTranslator::AgConfigAbstract($lang); ?>
</p>
