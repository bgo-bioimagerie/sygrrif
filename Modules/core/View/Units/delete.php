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
			<?php echo  CoreTranslator::Delete_Unit($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<div>
			<p> <?php echo CoreTranslator::Delete_Unit_Warning($lang, $unitName) ?></p>
		</div>
		
		<form role="form" class="form-horizontal" action="units/deletequery" method="post">
			
			<input class="form-control" id="id" type="hidden" name="id" value="<?php echo  $unitId ?>" />
			<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Delete($lang)?>" />
			</div>
       </form>
		
     </div>
</div>