<?php $this->title = "Supplies Bill"?>

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
	      
	  <form role="form" class="form-horizontal" action="suppliesbillmanager/editquery" method="post">
	
		<div class="page-header">
			<h1>
				<?php echo  SuTranslator::Edit_Bill_Informations($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<input class="form-control" id="id" type="hidden"  name="id" value="<?php echo  $this->clean($billInfo["id"]) ?>" />

		<input class="form-control" id="id" type="hidden"  name="id_unit" value="<?php echo  $this->clean($billInfo["id_unit"]) ?>" />
		<input class="form-control" id="id" type="hidden"  name="id_resp" value="<?php echo  $this->clean($billInfo["id_resp"]) ?>" />
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SuTranslator::Number($lang) ?> </label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="number"
				       value="<?php echo $this->clean($billInfo["number"]) ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SuTranslator::Date_generated($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="date_generated"
				       value="<?php echo $this->clean($billInfo["date_generated"]) ?>" readonly 
				/>
			</div>
		</div>
		<div class="form-group">

			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SuTranslator::Total_HT($lang) ?> </label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="total_ht"
				       value="<?php echo $this->clean($billInfo["total_ht"]) ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SuTranslator::Date_paid($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="date" name="date_paid" value="<?php echo $this->clean($billInfo["date_paid"]) ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SuTranslator::Is_Paid($lang) ?></label>
			<div class="col-xs-8">
				<?php  $is_active = $this->clean($billInfo["is_paid"]);?>
				<select class="form-control" name="is_paid">
					<option value="1" <?php if ($is_active==1){echo "selected=\"selected\"";} ?>> <?php echo  CoreTranslator::yes($lang) ?> </option>
					<option value="0" <?php if ($is_active==0){echo "selected=\"selected\"";} ?>> <?php echo  CoreTranslator::no($lang) ?>  </option>
				</select>
			</div>
		</div>
				
		<div class="col-xs-3 col-xs-offset-3" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='suppliesbillmanager'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
	
      </form>
	      
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
