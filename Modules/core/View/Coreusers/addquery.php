<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<?php include "Modules/core/View/usersnavbar.php"; ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
				Add User <br> <small></small>
			</h1>
		</div>
		
		<div>
		<?php if (isset($msgError)){ ?>
			<p> <?php echo  CoreTranslator::Unable_to_add_the_user($lang) ?></p>
			<p> <?php echo  $msgError ?></p>
		<?php }else{?>
			<p> <?php echo  CoreTranslator::The_user_had_been_successfully_added($lang)?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='coreusers'" class="btn btn-success"><?php echo  CoreTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>