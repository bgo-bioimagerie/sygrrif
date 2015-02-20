<?php $this->title = "Supplies Edit Item"?>

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
	<form role="form" class="form-horizontal" action="suppliesitems/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($id) == ""){
				$buttonName = "Add";
				echo SuTranslator::Add_Item($lang);
			}
			else{
				$buttonName = "Edit";
				echo SuTranslator::Edit_Item($lang);
			}
				?>	
				<br> <small></small>
			</h1>
		</div>
	
	
		<div class="page-header">
			<h3>
			<?= SuTranslator::Description($lang) ?>
				<br> <small></small>
			</h3>
		</div>
	
		
		<?php if ($this->clean($id) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?=$this->clean($id) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::Name($lang) ?> </label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?=$this->clean($name) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Description($lang) ?> </label>
			<div class="col-xs-8">
				<textarea class="form-control" id="name" name="description"
				><?=$this->clean($description) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Is_active($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="is_active">
					<option value="1" <?php if ($is_active==1){echo "selected=\"selected\"";} ?>> <?= CoreTranslator::yes($lang) ?> </option>
					<option value="0" <?php if ($is_active==0){echo "selected=\"selected\"";} ?>> <?= CoreTranslator::no($lang) ?> </option>
				</select>
			</div>
		</div>
		<div class="page-header">
			<h3>
			Prices
				<br> <small></small>
			</h3>
		</div>
				<div class="form-group">
		<table class="table table-striped text-center">
		<?php 
		foreach ($pricingTable as $pricing){
			
			$pid = $this->clean($pricing['id']);
			$pname = $this->clean($pricing['tarif_name']);
			$val_price = 0;
			if (isset($pricing['val_price'])){
				$val_price = $this->clean($pricing['val_price']);
			}	
			?>
			<tr>
				<td><b><?= $pname ?></b></td>
				<td></td>
				<td> <input id="tarif" type="text" class="text-center"  name="<?= $pid. "_price" ?>" 
				                         value="<?= $val_price ?>"/> € (H.T.)</td>
				<td></td>
			</tr>
			<?php
		}
		?>
		</table>
		</div>

		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= $buttonName ?>" />
				<button type="button" onclick="location.href='suppliesitems'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?> </button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
