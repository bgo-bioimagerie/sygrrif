

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php 
require_once 'Modules/storage/Model/StTranslator.php';
echo StTranslator::ConfigAbstract($lang); ?>
</p>