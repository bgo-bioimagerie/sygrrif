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
            <h1 class="text-center login-title">Database</h1>
            <div class="account-wall">
                <img class="img-responsive center-block" alt="logo" src="Themes/logo.jpg" >
                
                <br></br>
                
                <?php if (isset($msgError)): ?>
                <div class="alert alert-danger">
    			<p><?= $msgError ?></p>
    			</div>
				<?php endif; ?>
                
                <br></br>
                
                <form class="form-signin" action="connection/login" method="post">
	                <input name="login" type="text" class="form-control" placeholder="login" required autofocus>
	                <input name="pwd" type="password" class="form-control" placeholder="password" required>
	                <button class="btn btn-lg btn-primary btn-block" type="submit"> Ok </button>
                </form>
                    
            </div>
            <br></br>
            <a href="#" class="text-center new-account">Contact the administrator</a>
        </div>
    </div>
</div>
