

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php 
require_once 'Modules/zoomify/Model/ZoTranslator.php';
echo ZoTranslator::ConfigAbstract($lang); ?>
</p>