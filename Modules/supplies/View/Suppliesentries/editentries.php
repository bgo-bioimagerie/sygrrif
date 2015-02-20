<?php $this->title = "Supplies"?>

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
	<form role="form" class="form-horizontal" action="suppliesentries/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php if ($this->clean($entry["id"]) == ""){
				$buttonName = CoreTranslator::Add($lang);
				echo SuTranslator::Add_Order($lang);
			}
			else{
				$buttonName = CoreTranslator::Edit($lang);;
				echo SuTranslator::Edit_Order($lang);
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
	
		<?php if ($this->clean($entry["id"]) != ""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="control-label col-xs-4">ID</label>
				<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="id" value="<?=$this->clean($entry["id"]) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::User($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_user">
				<?php foreach($users as $user){ 
					$userid = $this->clean($user["id"]);
					$userName = $this->clean($user["name"]) . " " . $this->clean($user["firstname"]); 
					$selected = "";
					if ($userid == $this->clean($entry["id_user"])){
						$selected = "selected=\"selected\"";
					}
					?>
					<option value="<?= $userid ?>" <?= $selected ?>> <?= $userName ?> </option>
				<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::Status($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_status">
				<?php
					$selected = "selected=\"selected\"";
					$status = $this->clean($entry["id_status"]);
					?>
					<option value="1" <?php if ($status==1){echo $selected;}?>> <?= CoreTranslator::Open($lang) ?>  </option>
					<option value="0" <?php if ($status==0){echo $selected;}?>> <?= CoreTranslator::Close($lang) ?> </option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Opened_date($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="date_open" value="<?= CoreTranslator::dateFromEn($this->clean($entry["date_open"]), $lang) ?>" readonly/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Closed_date($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="date_close" value="<?= CoreTranslator::dateFromEn($this->clean($entry["date_close"]), $lang) ?>" readonly/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SuTranslator::Last_modified_date($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="date_last_modified" value="<?= CoreTranslator::dateFromEn($this->clean($entry["date_last_modified"]), $lang) ?>" readonly/>
			</div>
		</div>
		
		<div class="page-header">
			<h3>
			<?= SuTranslator::Order($lang) ?>
				<br> <small></small>
			</h3>
		</div>
		
		<!--  add here the order list -->
		<?php 
		foreach ($itemsOrder as $itemOrder ){
			
			$id_item = $this->clean($itemOrder['id']);
			$name_item = $this->clean($itemOrder['name']);
			$quantity = $this->clean($itemOrder['quantity']);
		?>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= $name_item ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="id" type="text"  name="item_<?= $id_item ?>" value="<?=$quantity ?>" />
			</div>
		</div>
		
		<?php
		}
		?>
		
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= $buttonName ?>" />
				<button type="button" onclick="location.href='suppliesentries'" class="btn btn-default" id="navlink"><?= CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
