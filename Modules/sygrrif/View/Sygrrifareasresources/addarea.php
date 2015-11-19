<?php $this->title = "SyGRRiF Add Area"?>

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
	<form role="form" class="form-horizontal" action="sygrrifareasresources/addareaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Add_area($lang) ?>
			<br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-9">
				<input class="form-control" id="name" type="text" name="name"  
				/>
			</div>
		</div>
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Is_resticted($lang) ?></label>
			<div class="col-xs-9">
					<select class="form-control" name="restricted">
						<?php $restricted = $this->clean($area['restricted']) ?>
						<OPTION value="1" > <?php echo  SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="0" selected="selected"> <?php echo  SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-9">
				<input class="form-control" id="name" type="number" name="display_order"  
				/>
			</div>
		</div>
		<br></br>
				<div class="page-header">
		<h1>
			<?php echo  SyTranslator::Booking_style($lang) ?> <br> <small></small>
		</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header background:</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="color" name="header_background"
				       value="#337ab7"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header color: </label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="color" name="header_color"
				       value="#ffffff"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header font size (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="header_font_size"
				       value="12"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Resa font size (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="resa_font_size"
				       value="12"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header height (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="header_height"
				       value="70"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Line height (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="line_height"
				       value="50"  
				/>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='areas'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
