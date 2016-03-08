

<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php echo SyTranslator::SyConfigAbstract($lang); ?>
</p>