<?php $this->title = "SyGRRiF Database - Connexion" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>


<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">SyGRRif base de données</h1>
            <div class="account-wall">
                <img class="img-responsive center-block" src="Themes/logo.jpg" alt="logo">
                <br>
                
                <?php if (isset($msgError)): ?>
                <div class="alert alert-danger">
    			<p><?= $msgError ?></p>
    			</div>
				<?php endif; ?>
                
                </br>
                <form class="form-signin" action="connection/login" method="post">
	                <input name="login" type="text" class="form-control" placeholder="Identifiant" required autofocus>
	                <input name="pwd" type="password" class="form-control" placeholder="Mot de passe" required>
	                <button class="btn btn-lg btn-primary btn-block" type="submit"> Valider </button>
                </form>
                    
            </div>
            <br></br>
            <a href="#" class="text-center new-account">Contacter l'administrateur </a>
        </div>
    </div>
</div>
