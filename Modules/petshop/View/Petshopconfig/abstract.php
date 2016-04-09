<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
require_once 'Modules/petshop/Model/PsTranslator.php';
?>
<p>
    <?php echo PsTranslator::PetShopAbstract($lang) ?>
</p>