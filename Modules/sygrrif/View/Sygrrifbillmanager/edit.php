<?php $this->title = "Supplies Bill"?>

<?php echo $navBar?>

<head>

	<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
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
	      
	  <form role="form" class="form-horizontal" action="sygrrifbillmanager/editquery" method="post">
	
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Edit_Bill_Informations($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<input class="form-control" id="id" type="hidden"  name="id" value="<?php echo  $this->clean($billInfo["id"]) ?>" />
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Number($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="number"
				       value="<?php echo $this->clean($billInfo["number"]) ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Date_generated($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="date_generated"
				       value="<?php echo CoreTranslator::dateFromEn($this->clean($billInfo["date_generated"]), $lang) ?>" readonly 
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::TotalHT($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="total_ht"
				       value="<?php echo CoreTranslator::dateFromEn($this->clean($billInfo["total_ht"]), $lang) ?>" 
				/>
			</div>
		</div>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Date_paid($lang) ?></label>
				<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input id="test32" type='text' class="form-control" name="date_paid" 
					       value="<?php echo  CoreTranslator::dateFromEn($this->clean($billInfo["date_paid"]), $lang) ?>" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Is_Paid($lang) ?></label>
			<div class="col-xs-8">
				<?php  $is_active = $this->clean($billInfo["is_paid"]);?>
				<select class="form-control" name="is_paid">
					<option value="1" <?php if ($is_active==1){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Yes($lang) ?> </option>
					<option value="0" <?php if ($is_active==0){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::No($lang) ?> </option>
				</select>
			</div>
		</div>
	
		<div class="col-xs-2 col-xs-offset-4" id="button-div">
		<button type="button" onclick="location.href='sygrrifbillmanager/removeentry/<?php echo $this->clean($billInfo["id"])?>'" class="btn btn-danger"><?php echo  SyTranslator::Delete($lang) ?></button>
		</div>        			
				
		<div class="col-xs-3 col-xs-offset-3" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifbillmanager'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
	
      </form>
	      
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php'; ?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
