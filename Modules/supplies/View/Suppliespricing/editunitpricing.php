<?php $this->title = "Supplies edit pricing"?>

<?php echo $navBar?>

<head>
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
	<form role="form" class="form-horizontal" action="suppliespricing/addunitpricingquery"
		method="post">
	
		<div class="page-header">
			<h1>
			<?= SuTranslator::Associate_a_pricing_to_a_unit($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID <?= CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="id_unit" type="text" name="id_unit" value="<?= $this->clean($unitId)?>" readonly
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="unit_name" type="text" name="unit_name" value="<?= $this->clean($unitName)?>" readonly
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SuTranslator::Pricing($lang) ?></label>
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
							<option value="<?= $pricingID ?>" <?=$selected?>> <?= $this->clean($pricing['tarif_name']) ?> </option>
						<?php 
						}
						?>
				</select>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='suppliespricing/unitpricing'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
