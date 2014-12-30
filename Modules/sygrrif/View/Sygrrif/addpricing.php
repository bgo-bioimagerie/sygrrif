<?php $this->title = "SyGRRiF add pricing"?>

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
	<form role="form" class="form-horizontal" action="sygrrif/addpricingquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Add pricing <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Name</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Unique price</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_unique">
						<OPTION value="oui"> Yes </OPTION>
						<OPTION value="non"> No </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Price night</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_nuit">
						<OPTION value="oui"> Yes </OPTION>
						<OPTION value="non"> No </OPTION>
				</select>
			</div>
			<br></br>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3">Night beginning</label>
				<div class="col-xs-2">
				<select class="form-control col-xs-2" name="night_start">
					<OPTION value="18"> 18h </OPTION>
					<OPTION value="19"> 19h </OPTION>
					<OPTION value="20"> 20h </OPTION>
					<OPTION value="21"> 21h </OPTION>
					<OPTION value="22"> 22h </OPTION>
				</select>
				</div>
				<label for="inputEmail" class="control-label col-xs-3">Night end</label>
				<div class="col-xs-2">
				<select class="form-control" name="night_end">
					<OPTION value="6"> 6h </OPTION>
					<OPTION value="7"> 7h </OPTION>
					<OPTION value="8"> 8h </OPTION>
					<OPTION value="9"> 9h </OPTION>
				</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Price weekend</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_we">
						<OPTION value="oui"> Yes </OPTION>
						<OPTION value="non"> No </OPTION>
				</select>
			</div>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3">Weekend days</label>
				<div class="col-xs-2">
					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="lundi"> Monday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mardi"> Tuesday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mercredi"> Wednesday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="jeudi"> Thursday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="vendredi"> Friday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="samedi" checked> Saturday
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="dimanche" checked> Sunday
    				</label>
  					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button type="button" onclick="location.href='sygrrif/pricing'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
