<?php $this->title = "sprojects Edit Item"?>

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
	<form role="form" class="form-horizontal" action="sprojectsitems/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($id) == ""){
				$buttonName = "Add";
				echo SpTranslator::Add_Item($lang);
			}
			else{
				$buttonName = "Edit";
				echo SpTranslator::Edit_Item($lang);
			}
				?>	
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			<?php echo  SpTranslator::Description($lang) ?>
				<br> <small></small>
			</h3>
		</div>
	
		
		<?php if ($this->clean($id) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?php echo $this->clean($id) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::Name($lang) ?> </label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?php echo $this->clean($name) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Description($lang) ?> </label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" name="description"
				><?php echo $this->clean($description) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Type($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="type_id">
					<?php 
					foreach($itemsTypes as $itemType){
						$selected = "";
						if ($type_id == $itemType["id"]){
							$selected = "selected=\"selected\"";
						}
						?>
						<option value="<?php echo $this->clean($itemType["id"]) ?>"  <?php echo $selected ?>> <?php echo $this->clean($itemType["local_name"]) ?></option>
					<?php 
					}
					?>
					</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SpTranslator::Is_active($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="is_active">
					<option value="1" <?php if ($is_active==1){echo "selected=\"selected\"";} ?>> <?php echo  CoreTranslator::yes($lang) ?> </option>
					<option value="0" <?php if ($is_active==0){echo "selected=\"selected\"";} ?>> <?php echo  CoreTranslator::no($lang) ?> </option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  CoreTranslator::Display_order($lang) ?> </label>
			<div class="col-xs-8">
				<input class="form-control" type="number" name="display_order"
				       value="<?php echo $this->clean($displayOrder) ?>"  
				/>
			</div>
		</div>
		<div class="page-header">
			<h3>
			<?php echo SpTranslator::Prices($lang)?>
				<br> <small></small>
			</h3>
		</div>
				<div class="form-group">
		<table class="table table-striped text-center">
		<?php 
		foreach ($pricingTable as $pricing){
			
			if ($pricing['id'] > 1){
				$pid = $this->clean($pricing['id']);
				$pname = $this->clean($pricing['name']);
				$val_price = 0;
				if (isset($pricing['val_price'])){
					$val_price = $this->clean($pricing['val_price']);
				}	
				?>
				<tr>
					<td><b><?php echo  $pname ?></b></td>
					<td></td>
					<td> <input id="tarif" type="text" class="text-center"  name="<?php echo  $pid. "_price" ?>" 
					                         value="<?php echo  $val_price ?>"/> € (H.T.)</td>
					<td></td>
				</tr>
				<?php
			}

		}
		?>
		</table>
		</div>

		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  $buttonName ?>" />
				<button type="button" onclick="location.href='sprojectsitems'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?> </button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
