<?php $this->title = "Anticorps: Edit Anticorp"?>

<?php echo $navBar?>
<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="anticorps/addquery" method="post">
		<div class="page-header">
			<h1>
				Edit Anticorps <br> <small></small>
			</h1>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Id</label>
			<div class="col-xs-10">
			    <input class="form-control" id="id" type="text" name="id" value="<?= $anticorps['id'] ?>" readonly
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Nom</label>
			<div class="col-xs-10">
				<input class="form-control" id="nom" type="text" name="nom" value="<?= $anticorps['nom'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No H2P2</label>
			<div class="col-xs-10">
				<input class="form-control" id="no_h2p2" type="text" name="no_h2p2" value="<?= $anticorps['no_h2p2'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Date Reception</label>
			<div class="col-xs-10">
				<input class="form-control" id="date_recept" type="text" name="date_recept" value="<?= $anticorps['date_recept'] ?>"
				/>
			</div>
		</div>
	    <br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Référence</label>
			<div class="col-xs-10">
				<input class="form-control" id="reference" type="text" name="reference" value="<?= $anticorps['reference'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Clone</label>
			<div class="col-xs-10">
				<input class="form-control" id="clone" type="text" name="clone" value="<?= $anticorps['clone'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Fournisseur</label>
			<div class="col-xs-10">
				<input class="form-control" id="fournisseur" type="text" name="fournisseur" value="<?= $anticorps['fournisseur'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Lot</label>
			<div class="col-xs-10">
				<input class="form-control" id="lot" type="text" name="lot" value="<?= $anticorps['lot'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Isotype</label>
			<div class="col-xs-10">
				<input class="form-control" id="isotype" type="text" name="isotype" value="<?= $anticorps['isotype'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Source</label>
			<div class="col-xs-10">
				<input class="form-control" id="source" type="text" name="source" value="<?= $anticorps['source'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Stockage</label>
			<div class="col-xs-10">
				<input class="form-control" id="stockage" type="text" name="stockage" value="<?= $anticorps['stockage'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No Protocole</label>
			<div class="col-xs-10">
				<input class="form-control" id="No_Proto" type="text" name="No_Proto" value="<?= $anticorps['No_Proto'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">disponible</label>
			<div class="col-xs-10">
				<input class="form-control" id="disponible" type="text" name="disponible" value="<?= $anticorps['disponible'] ?>"
				/>
			</div>
		</div>
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='anticorps'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
