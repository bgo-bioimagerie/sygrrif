<?php $this->title = "SyGRRiF edit pricing"?>

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
	<form role="form" class="form-horizontal" action="sygrrifpricing/editpricingquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Edit_pricing($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">ID</label>
			<div class="col-xs-10">
				<input class="form-control" id="id" type="text" name="id" value="<?php echo  $this->clean($pricing['id'])?>" readonly
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" value="<?php echo  $this->clean($pricing['name'])?>" readonly
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Unique_price($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_unique">
						<?php $unique = $this->clean($pricing['tarif_unique']) ?>
						<OPTION value="1" <?php if ($unique==1){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" <?php if ($unique==0){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::No($lang)?> </OPTION>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Price_night($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_night">
					    <?php $tnuit = $this->clean($pricing['tarif_night']) ?>
						<OPTION value="1" <?php if ($tnuit==1){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" <?php if ($tnuit==0){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::No($lang)?> </OPTION>
				</select>
			</div>
			<br></br>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Night_beginning($lang)?></label>
				<div class="col-xs-2">
				<select class="form-control col-xs-2" name="night_start">
				    <?php $snight = $this->clean($pricing['night_start']) ?>
					<OPTION value="18" <?php if ($snight==18){echo "selected=\"selected\"";}?>> 18h </OPTION>
					<OPTION value="19" <?php if ($snight==19){echo "selected=\"selected\"";}?>> 19h </OPTION>
					<OPTION value="20" <?php if ($snight==20){echo "selected=\"selected\"";}?>> 20h </OPTION>
					<OPTION value="21" <?php if ($snight==21){echo "selected=\"selected\"";}?>> 21h </OPTION>
					<OPTION value="22" <?php if ($snight==22){echo "selected=\"selected\"";}?>> 22h </OPTION>
				</select>
				</div>
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Night_end($lang)?></label>
				<div class="col-xs-2">
				<select class="form-control" name="night_end">
				    <?php $enight = $this->clean($pricing['night_end']) ?>
					<OPTION value="6" <?php if ($enight==6){echo "selected=\"selected\"";}?>> 6h </OPTION>
					<OPTION value="7" <?php if ($enight==7){echo "selected=\"selected\"";}?>> 7h </OPTION>
					<OPTION value="8" <?php if ($enight==8){echo "selected=\"selected\"";}?>> 8h </OPTION>
					<OPTION value="9" <?php if ($enight==9){echo "selected=\"selected\"";}?>> 9h </OPTION>
				</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Price_weekend($lang) ?></label>
			<div class="col-xs-10">
					<select class="form-control" name="tarif_we">
					    <?php $tarif_we = $this->clean($pricing['tarif_we']) ?>
						<OPTION value="1" <?php if ($tarif_we==1){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" <?php if ($tarif_we==0){echo "selected=\"selected\"";}?>> <?php echo  SyTranslator::No($lang)?> </OPTION>
				</select>
			</div>
			
			
			<?php 
			$jours = $this->clean($pricing['choice_we']);
			$list = explode(",", $jours);
			if (count($list) < 7){
				$list[0] = 0; $list[1] = 0; $list[2] = 0; $list[3] = 0;
				$list[4] = 0; $list[5] = 1; $list[6] = 1;
			}
			
			?>
			<div class="col-xs-10 col-xs-offset-2">
				<label for="inputEmail" class="control-label col-xs-3"><?php echo  SyTranslator::Weekend_days($lang)?></label>
				<div class="col-xs-2">
					<div class="checkbox">
    				<label>
    				    <?php $lundi = $list[0]; ?>
      					<input type="checkbox" name="lundi" <?php if ($lundi==1){echo "checked";}?>> <?php echo  SyTranslator::Monday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $mardi = $list[1]; ?>
      					<input type="checkbox" name="mardi" <?php if ($mardi==1){echo "checked";}?>> <?php echo  SyTranslator::Tuesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    					<?php $mercredi = $list[2]; ?>
      					<input type="checkbox" name="mercredi" <?php if ($mercredi==1){echo "checked";}?>> <?php echo  SyTranslator::Wednesday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $jeudi = $list[3]; ?>
      					<input type="checkbox" name="jeudi" <?php if ($jeudi==1){echo "checked";}?>> <?php echo  SyTranslator::Thursday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $vendredi = $list[4]; ?>
      					<input type="checkbox" name="vendredi" <?php if ($vendredi==1){echo "checked";}?>> <?php echo  SyTranslator::Friday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $samedi = $list[5]; ?>
      					<input type="checkbox" name="samedi" <?php if ($samedi==1){echo "checked";}?>> <?php echo  SyTranslator::Saturday($lang)?>
    				</label>
  					</div>
  					<div class="checkbox">
    				<label>
    				    <?php $dimanche = $list[6]; ?>
      					<input type="checkbox" name="dimanche" <?php if ($dimanche==1){echo "checked";}?>> <?php echo  SyTranslator::Sunday($lang)?>
    				</label>
  					</div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang)?>" />
				<button type="button" onclick="location.href='sygrrifpricing/pricing'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>