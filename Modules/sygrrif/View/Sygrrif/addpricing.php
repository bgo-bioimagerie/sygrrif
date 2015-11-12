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
			<?php echo  SyTranslator::Add_pricing($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Unique_price($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_unique">
						<OPTION value="oui"> <?php echo  SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?php echo  SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Price_night($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_nuit">
						<OPTION value="oui"> <?php echo  SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?php echo  SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
			<br></br>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Night_beginning($lang) ?></label>
				<div class="col-xs-2">
				<select class="form-control col-xs-2" name="night_start">
					<OPTION value="18"> 18h </OPTION>
					<OPTION value="19"> 19h </OPTION>
					<OPTION value="20"> 20h </OPTION>
					<OPTION value="21"> 21h </OPTION>
					<OPTION value="22"> 22h </OPTION>
				</select>
				</div>
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Night_end($lang) ?></label>
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
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Price_weekend($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_we">
						<OPTION value="oui"> <?php echo  SyTranslator::Yes($lang) ?> </OPTION>
						<OPTION value="non"> <?php echo  SyTranslator::No($lang) ?> </OPTION>
				</select>
			</div>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Weekend_days($lang) ?></label>
				<div class="col-xs-2">
					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="lundi"> <?php echo  SyTranslator::Monday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mardi"> <?php echo  SyTranslator::Tuesday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="mercredi"> <?php echo  SyTranslator::Wednesday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="jeudi"> <?php echo  SyTranslator::Thursday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="vendredi"> <?php echo  SyTranslator::Friday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="samedi" checked> <?php echo  SyTranslator::Saturday($lang) ?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
      					<input type="checkbox" name="dimanche" checked> <?php echo  SyTranslator::Sunday($lang) ?>
    				</label>
  					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif/pricing'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
