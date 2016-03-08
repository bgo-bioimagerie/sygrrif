<?php $this->title = "SyGRRiF Edit Unitary resource"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>

<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form role="form" class="form-horizontal" action="calendar/edittimeunitaryresourcequery"
		method="post">
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($resource_base["id"]) == ""){
				$buttonName = SyTranslator::Add($lang);
				echo "Add time and unitary resource";
			}
			else{
				$buttonName = SyTranslator::Edit($lang);
				echo "Edit time and unitary resource";
			}
			?>	
			<br> <small></small>
			</h1>
		</div>
	
		<!-- hidden fields -->
		<input class="form-control" type="hidden" name="id" value="<?php echo $this->clean($resource_base["id"]); ?>"/> 
		<input class="form-control" type="hidden" name="name" value="<?php echo $this->clean($resource_base["name"]); ?>"/> 
		<input class="form-control" type="hidden" name="description" value="<?php echo $this->clean($resource_base["description"]); ?>"/> 
		<input class="form-control" type="hidden" name="accessibility_id" value="<?php echo $this->clean($resource_base["accessibility_id"]); ?>"/> 
		<input class="form-control" type="hidden" name="category_id" value="<?php echo $this->clean($resource_base["category_id"]); ?>"/> 
		<input class="form-control" type="hidden" name="area_id" value="<?php echo $this->clean($resource_base["area_id"]); ?>"/> 
		<input class="form-control" type="hidden" name="display_order" value="<?php echo $this->clean($resource_base["display_order"]); ?>"/> 
		
		<?php foreach($resource_info["supplynames"] as $suppliesN){?>
		<input class="form-control" type="hidden" name="supplynames[]" value="<?php echo  $suppliesN ?>"/> 
		<?php }?>
		
		<input class="form-control" type="hidden" name="day_begin" value="<?php echo $this->clean($resource_info["day_begin"]); ?>"/> 
		<input class="form-control" type="hidden" name="day_end" value="<?php echo $this->clean($resource_info["day_end"]); ?>"/> 
		<input class="form-control" type="hidden" name="size_bloc_resa" value="<?php echo $this->clean($resource_info["size_bloc_resa"]); ?>"/> 
		<input class="form-control" type="hidden" name="resa_time_setting" value="<?php echo $this->clean($resource_info["resa_time_setting"]); ?>"/> 
		<input class="form-control" type="hidden" name="default_color_id" value="<?php echo $this->clean($resource_info["default_color_id"]); ?>"/> 
		
		<?php 
		$availableDays = explode(",", $resource_info["available_days"]);
		//echo "av days = " . $resource_info["available_days"] . "</br>";
		//print_r($availableDays);
		?>
		<input class="form-control" type="hidden" name="monday" value="<?php if ($availableDays[0] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="tuesday" value="<?php if ($availableDays[1] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="wednesday" value="<?php if ($availableDays[2] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="thursday" value="<?php if ($availableDays[3] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="friday" value="<?php if ($availableDays[4] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="saturday" value="<?php if ($availableDays[5] == 1){echo 1;}?>"/> 
		<input class="form-control" type="hidden" name="sunday" value="<?php if ($availableDays[6] == 1){echo 1;}?>"/> 
	
		<div class="page-header">
			<h3>
			<?php echo  SyTranslator::Prices_for($lang) ?> : <?php echo  $resource_base["name"] ?>
				<br> <small></small>
			</h3>
		</div>
		
		
		<div class="form-group">
		<table class="table table-striped text-center">
		<thead>
			<tr>
			  <th class="text-center"> Pricing/type <th/>		
			  <th class="text-center"> Time <th/>
			  <?php 
			  foreach ($resource_info['supplynames'] as $supplyName){
			  		echo "<th class=\"text-center\"> " . $supplyName . " </th>";	
			  }
			  ?>
			  	
			</tr>
		</thead>
		<tbody>
		<?php 
		$pricingCount = -1;
		foreach ($pricingTable as $pricing){
			
			$pricingCount++;
			$pid = $this->clean($pricing['id']);
			$pname = $this->clean($pricing['name']);
			$punique = $this->clean($pricing['tarif_unique']);
			$val_day = 0;
			if (isset($pricing['val_day'])){
				$val_day = $this->clean($pricing['val_day']);
			}
			$val_night = 0;
			if (isset($pricing['val_night'])){
				$val_night = $this->clean($pricing['val_night']);
			}
			$val_we = 0;
			if (isset($pricing['val_we'])){
				$val_we = $this->clean($pricing['val_we']);
			}
			
			if ($punique){
				?>
				<tr>
					<td><b><?php echo  $pname ?></b></td>
					<td></td>
					<td> <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid. "_day" ?>" 
					                         value="<?php echo  $val_day ?>"/> € (H.T.)</td>
					<td></td>
				
			<?php
			}
			else {
				?>
				<tr>
					<td><b><?php echo  $pname ?></b></td>
					<td><?php echo  SyTranslator::Price_day($lang) ?>: <input id="tarif" type="text" class="text-center" name="<?php echo  $pid. "_day" ?>" value="<?php echo  $val_day ?>"/> € (H.T.)</td>
				<?php	
				
				$pnight = $this->clean($pricing['tarif_night']);
				$pwe = $this->clean($pricing['tarif_we']);

				if (($pnight == "1") AND ($pwe== "0")){
					?>
					<td><? SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_night" ?>" value="<?php echo  $val_night ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "0") AND ($pwe == "1")){
					?>
					<td><? SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_we" ?>" value="<?php echo  $val_we ?>"/> € (H.T.)</td>
					<td></td>
					<?php
				}
				else if (($pnight == "1") AND ($pwe == "1")){
					?>
					<td><? SyTranslator::Price_Night($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_night" ?>" value="<?php echo  $val_night ?>"/> € (H.T.)</td>
					<td><? SyTranslator::Price_w_e($lang) ?>: <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid . "_we" ?>" value="<?php echo  $val_we ?>"/> € (H.T.)</td>
				    <?php
				}
				?>
				
				<?php
			}
			// supply
			$count = 0;
			foreach ($resource_info['supplynames'] as $supplyName){
				$priceSup = 0;
				if (isset($suppliesPrices[$pricingCount][$count])){
					$priceSup = $suppliesPrices[$pricingCount][$count];	
				}
			?>
				<td><input id="tarif" type="text" class="text-center" name="<?php echo  $pid. "_" . $count ?>" value="<?php echo $priceSup ?>"/> € (H.T.)</td>	
			<?php
			$count++;
			}
			?>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		</div>
				
		<div class="col-xs-3" id="button-div">
			<?php if ($this->clean($resource_base["id"]) != ""){ ?>
			<button type="button" onclick="location.href='<?php echo "calendar/deletecalendarresource/".$this->clean($resource_base["id"]) ?>'" class="btn btn-danger"><?php echo  SyTranslator::Delete($lang) ?></button>
			<?php } ?>
		</div>		
		<div class="col-xs-3 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources/resources'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
