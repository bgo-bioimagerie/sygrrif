<?php $this->title = "Pltaform-Manager" ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    #jumbotron{
    	background-color: #fff;
    }
    </style>
</head>

<?php if ($errorMessage != 'success'){?>

<div class="container">
	<div class="alert alert-danger">
        <h1>Error:</h1>
        <p> <?php echo $errorMessage ?> </p>
	</div>

</div> 

<?php }else{ ?>

<div class="container">
  <div class="jumbotron">
    <h1>Finished</h1>
    <p> The SyGRRiF Database has been successfully installed </p>
    <br>
    <div class="col-md-12 text-center">
      <button onclick="location.href='home'" class="btn btn-success" id="navlink">Start SyGRRif</button>
    </div>

  </div>
</div>

<?php }?>


<?php if (isset($msgError)): ?>
    <p><?php echo  $msgError ?></p>
<?php endif; ?>