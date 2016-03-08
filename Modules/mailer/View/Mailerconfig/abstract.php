

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<p>
<?php 
require_once 'Modules/mailer/Model/MailerTranslator.php';
echo MailerTranslator::MailerConfigAbstract($lang); ?>
</p>