<?php $this->title = "Platform-Manager - Connexion" ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    
        <!-- Bootstrap core CSS -->
    <script src="Themes/caroussel/ie-emulation-modes-warning.js"></script>
    <link href="Themes/caroussel/carousel.css" rel="stylesheet"> 
    
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
        <!-- Title -->
        <div class="col-sm-12">
            <h1 class="text-center login-title"><?php echo $home_title ?></h1>
        </div>
        
        <!-- Message -->
        <div class="col-sm-10 col-sm-offset-1">
            <p></p>    
	<h3 style="text-align:center;"><?php echo  $home_message ?></h3>
            <p></p>
	</div>
        
        <!-- Carousel and Login -->
        <div class="col-md-12">
            <!-- Carousel -->
            <div class="col-md-8">
                <?php include "Modules/core/View/Connection/carousel.php" ?>
            </div>
            <!-- Login -->
            <div class="col-md-4">
                <div class="col-xs-12" style="height:100px;">
                    <p></p>
                </div>
                <div class="col-xs-12">
                <div class="account-wall">
                    <?php if (isset($msgError) && $msgError!=""): ?>
                    <div class="alert alert-danger">
                            <p><?php echo  $msgError ?></p>
                            </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-12">    
                    <br></br>
                    
                    <form class="form-signin" action="connection/login" method="post">
                        <input name="redirection" type="hidden" value="<?php echo $redirection ?>">
                        <input name="login" type="text" class="form-control" placeholder="<?php echo  CoreTranslator::Login($language) ?>" required autofocus>
                        <input name="pwd" type="password" class="form-control" placeholder="<?php echo  CoreTranslator::Password($language) ?>" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit"> <?php echo  CoreTranslator::Ok($language) ?> </button>
                    </form>

                </div>
                <br/>
                <a href="mailto:<?php echo  $admin_email ?>" class="text-center new-account"><?php echo  CoreTranslator::Contact_the_administrator($language) ?></a>
        
            </div>
        </div> 
            </div> 
    </div>
</div>
