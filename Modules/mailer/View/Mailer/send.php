<?php $this->title = "Mailer"?>

<?php echo $navBar?>

<?php
$lang = "En";
		if (isset ( $_SESSION ["user_settings"] ["language"] )) {
			$lang = $_SESSION ["user_settings"] ["language"];
		}
?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
			<?php echo  MailerTranslator::Send_email($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<div>
			<p> <?php echo $message ?></p>
		</div>
		
		<div class="col-lg-2 col-lg-offset-10">
		<button type="button" onclick="location.href='mailer'" class="btn btn-default"><?php echo  CoreTranslator::Ok($lang)?></button>
		</div>
     </div>
</div>