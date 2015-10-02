<?php $this->title = "SyGRRiF Database add user"?>

<?php echo $navBar?>

<?php include "Modules/sheet/View/navbar.php"; ?>
<?php require_once 'Modules/sheet/Model/ShTranslator.php';?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
			<?php echo  ShTranslator::Delete($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<div>
			<p> <?php echo ShTranslator::Delete_Message($lang) ?></p>
		</div>
		
		<form role="form" class="form-horizontal" action="sheet/deletequery" method="post">
			
			<input class="form-control" id="id" type="hidden" name="id" value="<?php echo  $id_sheet ?>" />
			<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Delete($lang)?>" />
			</div>
       </form>
		
     </div>
</div>