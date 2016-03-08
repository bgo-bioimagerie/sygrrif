<?php $this->title = "SyGRRiF Edit Area"?>

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
	<form role="form" class="form-horizontal" action="sygrrifareasresources/editareaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				<?php echo SyTranslator::Edit_area($lang) ?> <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" value="<?php echo  $area['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?php echo  $area['name'] ?>"  
				/>
			</div>
		</div>
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Is_resticted($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="restricted">
						<?php $restricted = $this->clean($area['restricted']) ?>
						<OPTION value="1" <?php if ($restricted==1){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" <?php if ($restricted==0){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::No($lang)?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?php echo  $area['display_order'] ?>"  
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
				       value="<?php echo $css['header_background']?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header color:</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="color" name="header_color"
				       value="<?php echo $css['header_color']?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header font size (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="header_font_size"
				       value="<?php echo  $css['header_font_size'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Resa font size (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="resa_font_size"
				       value="<?php echo  $css['resa_font_size'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Header height (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="header_height"
				       value="<?php echo  $css['header_height'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-5">Line height (px)</label>
			<div class="col-xs-7">
				<input class="form-control" id="name" type="text" name="line_height"
				       value="<?php echo  $css['line_height'] ?>"  
				/>
			</div>
		</div>
		
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources/areas'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
