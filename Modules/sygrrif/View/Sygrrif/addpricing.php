<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

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
				Ajouter tarif <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">nom</label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Tarif unique</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_unique">
						<OPTION value="oui"> Oui </OPTION>
						<OPTION value="non"> Non </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Tarif nuit</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_nuit">
						<OPTION value="oui"> Oui </OPTION>
						<OPTION value="non"> Non </OPTION>
				</select>
			</div>
			<br></br>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3">début nuit</label>
				<div class="col-xs-2">
				<select class="form-control col-xs-2" name="night_start">
					<OPTION value="18"> 18h </OPTION>
					<OPTION value="19"> 19h </OPTION>
					<OPTION value="20"> 20h </OPTION>
					<OPTION value="21"> 21h </OPTION>
					<OPTION value="22"> 22h </OPTION>
				</select>
				</div>
				<label for="inputEmail" class="control-label col-xs-3">fin nuit</label>
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
			<label for="inputEmail" class="control-label col-xs-2">Tarif weekend</label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_we">
						<OPTION value="oui"> Oui </OPTION>
						<OPTION value="non"> Non </OPTION>
				</select>
			</div>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3">Jours weekend</label>
				<div class="col-xs-2">
					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="lundi"> Lundi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mardi"> Mardi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mercredi"> Mercredi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="jeudi"> Jeudi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="vendredi"> Vendredi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="samedi" checked> Samedi
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="dimanche" checked> Dimanche
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
