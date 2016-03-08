<?php $this->title = "sprojects edit pricing"?>

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
	<form role="form" class="form-horizontal" action="sprojectspricing/editpricingquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SpTranslator::Edit_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
				<input class="form-control" id="id" type="text" name="id" value="<?php echo  $this->clean($pricing['id'])?>" readonly
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?php echo  $this->clean($pricing['tarif_name'])?>"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::color($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" type="color" name="color" value="<?php echo  $this->clean($pricing['tarif_color'])?>"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SpTranslator::Type($lang) ?></label>
			<div class="col-xs-10">
				<?php  $type = $this->clean($pricing["tarif_type"]);?>
				<select class="form-control" name="type">
					<option value="1" <?php if ($type==1){echo "selected=\"selected\"";} ?>> <?php echo SpTranslator::Academique($lang) ?> </option>
					<option value="2" <?php if ($type==2){echo "selected=\"selected\"";} ?>> <?php echo SpTranslator::Industry($lang) ?>  </option>
				</select>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sprojectspricing'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
