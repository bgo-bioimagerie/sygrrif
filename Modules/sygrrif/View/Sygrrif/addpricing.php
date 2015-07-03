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
			<?= SyTranslator::Add_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Montant</label>
			<div class="col-xs-10">
				<input class="form-control" id="montant" type="text" name="montant"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Unique_price($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_unique">
						<OPTION value="oui"> <?= SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?= SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Price_night($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_nuit">
						<OPTION value="oui"> <?= SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?= SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
			<br></br>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?= SyTranslator::Night_beginning($lang) ?></label>
				<div class="col-xs-2">
				<select class="form-control col-xs-2" name="night_start">
					<OPTION value="18"> 18h </OPTION>
					<OPTION value="19"> 19h </OPTION>
					<OPTION value="20"> 20h </OPTION>
					<OPTION value="21"> 21h </OPTION>
					<OPTION value="22"> 22h </OPTION>
				</select>
				</div>
				<label for="inputEmail" class="control-label col-xs-3"><?= SyTranslator::Night_end($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?= SyTranslator::Price_weekend($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_we">
						<OPTION value="oui"> <?= SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?= SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?= SyTranslator::Weekend_days($lang) ?></label>
				<div class="col-xs-2">
					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="lundi"> <?= SyTranslator::Monday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mardi"> <?= SyTranslator::Tuesday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mercredi"> <?= SyTranslator::Wednesday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="jeudi"> <?= SyTranslator::Thursday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="vendredi"> <?= SyTranslator::Friday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="samedi" checked> <?= SyTranslator::Saturday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="dimanche" checked> <?= SyTranslator::Sunday($lang) ?>
    				</label>
  					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/pricing'" class="btn btn-default" id="navlink"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
