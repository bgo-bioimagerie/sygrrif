<?php $this->title = "SyGRRiF Database add user"?>

<?php echo $navBar?>

<?php include "Modules/supplies/View/navbar.php"; 
require_once 'Modules/supplies/Model/SuTranslator.php';
?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		
		<div class="page-header">
			<h1>
			<?php echo  SuTranslator::Delete_entry($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<div>
			<p> <?php echo SuTranslator::Delete_entry_Warning($lang) ?></p>
		</div>
		
		<form role="form" class="form-horizontal" action="suppliesentries/deletequery" method="post">
			
			<input class="form-control" id="id" type="hidden" name="id" value="<?php echo  $entryID ?>" />
			<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Delete($lang)?>" />
			</div>
       </form>
		
     </div>
</div>