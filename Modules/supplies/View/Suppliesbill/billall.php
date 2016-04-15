<?php $this->title = "Supplies bill"?>

<?php echo $navBar?>

<head>

<script src="externals/jquery-1.11.1.js"></script>

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>
	
<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="suppliesbill/billallquery"
		method="post" id="statform">
	
	
            <div class="page-header">
                <h1>
                    <?php echo  SuTranslator::BillAll($lang) ?> <br> <small></small>
                </h1>
            </div>
		
            <div class="form-group">
                <p><?php echo  SuTranslator::BillAllMessage($lang) ?></p>
            </div>
			
            <br>
            <div class="col-xs-4 col-xs-offset-8" id="button-div">
                <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Ok($lang) ?>" />
                <button type="button" onclick="location.href='suppliesentries'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
            </div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
