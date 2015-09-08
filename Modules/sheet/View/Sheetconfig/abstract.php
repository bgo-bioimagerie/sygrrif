

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php 
require_once 'Modules/sheet/Model/ShTranslator.php';
echo ShTranslator::ConfigAbstract($lang); ?>
</p>