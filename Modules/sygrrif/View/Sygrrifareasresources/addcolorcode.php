<?php $this->title = "SyGRRiF add color code"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrifareasresources/addcolorcodequery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Add_Color_Code($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Color_diese($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="color" name="color" value="#ffffff"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Text_color_diese($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="color" name="text_color" value="#000000"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="0"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources/colorcodes'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
