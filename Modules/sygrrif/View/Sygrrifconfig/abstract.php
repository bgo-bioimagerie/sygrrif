

<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>
<p>
<?php echo SyTranslator::SyConfigAbstract($lang); ?>
</p>