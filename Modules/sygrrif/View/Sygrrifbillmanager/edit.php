<?php $this->title = "Supplies Bill"?>

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
	      
	  <form role="form" class="form-horizontal" action="sygrrifbillmanager/editquery" method="post">
	
		<div class="page-header">
			<h1>
				Edit Bill Informations
				<br> <small></small>
			</h1>
		</div>
		
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $this->clean($billInfo["id"]) ?>" />
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Number</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="number"
				       value="<?=$this->clean($billInfo["number"]) ?>" readonly  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Date generated</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="date_generated"
				       value="<?=$this->clean($billInfo["date_generated"]) ?>" readonly 
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Date generated</label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="date_paid"
				       value="<?=$this->clean($billInfo["date_paid"]) ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Is Paid</label>
			<div class="col-xs-8">
				<?php  $is_active = $this->clean($billInfo["is_paid"]);?>
				<select class="form-control" name="is_paid">
					<option value="1" <?php if ($is_active==1){echo "selected=\"selected\"";} ?>> Yes </option>
					<option value="0" <?php if ($is_active==0){echo "selected=\"selected\"";} ?>> No </option>
				</select>
			</div>
		</div>
	
		<div class="col-xs-2 col-xs-offset-4" id="button-div">
		<button type="button" onclick="location.href='sygrrifbillmanager/removeentry/<?=$this->clean($billInfo["id"])?>'" class="btn btn-danger" id="navlink">Delete</button>
		</div>        			
				
		<div class="col-xs-3 col-xs-offset-3" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='sygrrifbillmanager'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
	
      </form>
	      
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
