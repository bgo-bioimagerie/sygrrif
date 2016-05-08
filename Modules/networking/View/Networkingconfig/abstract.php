
<?php
include_once 'Modules/networking/Model/NtTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo NtTranslator::NtConfigAbstract($lang); ?>
</p>
