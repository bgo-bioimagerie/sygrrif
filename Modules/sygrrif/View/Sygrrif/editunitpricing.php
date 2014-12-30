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
				Associate a pricing to a unit <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID Unit</label>
			<div class="col-xs-10">
				<input class="form-control" id="id_unit" type="text" name="id_unit" value="<?= $this->clean($unitId)?>" readonly
				/>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name Unit</label>
			<div class="col-xs-10">
				<input class="form-control" id="unit_name" type="text" name="unit_name" value="<?= $this->clean($unitName)?>" readonly
				/>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Pricing</label>
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
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='sygrrif/unitpricing'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
