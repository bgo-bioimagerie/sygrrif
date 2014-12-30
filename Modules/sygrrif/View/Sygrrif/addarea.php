<?php $this->title = "SyGRRiF Add Area"?>

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
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrif/addareaquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Add area <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3">Name</label>
			<div class="col-xs-9">
				<input class="form-control" id="name" type="text" name="name"  
				/>
			</div>
		</div>
	    <div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3">Is resticted</label>
			<div class="col-xs-9">
					<select class="form-control" name="restricted">
						<?php $restricted = $this->clean($area['restricted']) ?>
						<OPTION value="1" > Yes </OPTION>
						<OPTION value="0" selected="selected"> No </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3">Display order</label>
			<div class="col-xs-9">
				<input class="form-control" id="name" type="number" name="display_order"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button type="button" onclick="location.href='areas'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
