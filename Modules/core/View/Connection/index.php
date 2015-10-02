<?php $this->title = "SyGRRiF Database - Connexion" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<?php 
// get the navigator language
require_once 'Modules/core/Model/CoreTranslator.php';
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$language = $language{0}.$language{1};
if ($language == "fr"){
	$language = "Fr";
}
?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo  $home_title ?></h1>
            <div class="account-wall">
                <img class="img-responsive center-block" alt="logo" src="<?php echo  $logo ?>" >
                
                <br></br>
               
                <div class="form">
				<h3 style="text-align:center;"><?php echo  $home_message ?></h3>
				</div>
                
                <br></br>
                
                <?php if (isset($msgError) && $msgError!=""): ?>
                <div class="alert alert-danger">
    			<p><?php echo  $msgError ?></p>
    			</div>
				<?php endif; ?>
                
                <br></br>
                
                <form class="form-signin" action="connection/login" method="post">
	                <input name="login" type="text" class="form-control" placeholder="<?php echo  CoreTranslator::Login($language) ?>" required autofocus>
	                <input name="pwd" type="password" class="form-control" placeholder="<?php echo  CoreTranslator::Password($language) ?>" required>
	                <button class="btn btn-lg btn-primary btn-block" type="submit"> <?php echo  CoreTranslator::Ok($language) ?> </button>
                </form>
                    
            </div>
            <br></br>
            <a href="mailto:<?php echo  $admin_email ?>" class="text-center new-account"><?php echo  CoreTranslator::Contact_the_administrator($language) ?></a>
        </div>
    </div>
</div>
