<?php $this->title = "SyGRRiF edit pricing"?>

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
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrif/addunitpricingquery"
		method="post">
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Associate_a_pricing_to_a_unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID  <?php echo " " . SyTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="id_unit" type="text" name="id_unit" value="<?php echo  $this->clean($unitId)?>" readonly
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo SyTranslator::Name($lang) . " " . SyTranslator::Unit($lang) ?> </label>
			<div class="col-xs-10">
				<input class="form-control" id="unit_name" type="text" name="unit_name" value="<?php echo  $this->clean($unitName)?>" readonly
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Pricing($lang)?></label>
			<div class="col-xs-10">
					<select class="form-control" name="id_pricing">
						<?php 
						foreach($pricingList as $pricing){
							$pricingID = $this->clean($pricing['id']);
							$selected = "";
							if ($curentPricingId == $pricingID){
								$selected = "selected=\"selected\"";
							}
						?>
							<option value="<?php echo  $pricingID ?>" <?php echo $selected?>> <?php echo  $this->clean($pricing['tarif_name']) ?> </option>
						<?php 
						}
						?>
				</select>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/unitpricing'" class="btn btn-default" id="navlink"><?php echo  SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
