<?php $this->title = "sprojects add pricing"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sprojects/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sprojectspricing/addpricingquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SpTranslator::Add_pricing($lang) ?>
			 <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::color($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" type="color" name="color"
				/>
			</div>
		</div>
			
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sprojectspricing'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
