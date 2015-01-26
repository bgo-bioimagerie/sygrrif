<?php $this->title = "Supplies add pricing"?>

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
				Associate a pricing to a unit <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unit</label>
			<div class="col-xs-10">
					<select class="form-control" name="id_unit">
						<?php 
						foreach($unitsList as $unit){
						?>
							<option value="<?= $this->clean($unit['id'])?>"> <?= $this->clean($unit['name']) ?> </option>
						<?php 
						}
						?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Pricing</label>
			<div class="col-xs-10">
					<select class="form-control" name="id_pricing">
						<?php 
						foreach($pricingList as $pricing){
						?>
							<option value="<?= $this->clean($pricing['id'])?>"> <?= $this->clean($pricing['tarif_name']) ?> </option>
						<?php 
						}
						?>
				</select>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button type="button" onclick="location.href='suppliespricing/unitpricing'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
