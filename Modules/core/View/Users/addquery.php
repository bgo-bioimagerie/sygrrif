<?php $this->title = "SyGRRiF Database add user"?>

<?php echo $navBar?>

<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

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
			<p> <?= CoreTranslator::Unable_to_add_the_user($lang) ?></p>
			<p> <?= $msgError ?></p>
		<?php }else{?>
			<p> <?= CoreTranslator::The_user_had_been_successfully_added($lang)?></p>
		<?php } ?>
		</div>
		<div class="col-md-1 col-md-offset-10">
			<button onclick="location.href='users'" class="btn btn-success" id="navlink"><?= CoreTranslator::Ok($lang) ?></button>
		</div>
		
     </div>
</div>