

<?php 
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>
<p>
<?php echo SyTranslator::SyConfigAbstract($lang); ?>
</p>