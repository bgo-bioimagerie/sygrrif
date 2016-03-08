<?php $this->title = "SyGRRiF Statistics"?>

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
	<form role="form" class="form-horizontal" action="sygrrifstats/statisticsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Statistics($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Begining_period($lang) ?></label>
				<div class="col-xs-5">
				<select class="form-control" name="month_start">
					<OPTION value="1" > <?php echo SyTranslator::Jan($lang)?> </OPTION>
					<OPTION value="2" > <?php echo SyTranslator::Feb($lang)?> </OPTION>
					<OPTION value="3" > <?php echo SyTranslator::Mar($lang)?> </OPTION>
					<OPTION value="4" > <?php echo SyTranslator::Apr($lang)?> </OPTION>
					<OPTION value="5" > <?php echo SyTranslator::May($lang)?> </OPTION>
					<OPTION value="6" > <?php echo SyTranslator::Jun($lang)?> </OPTION>
					<OPTION value="7" > <?php echo SyTranslator::July($lang)?> </OPTION>
					<OPTION value="8" > <?php echo SyTranslator::Aug($lang)?> </OPTION>
					<OPTION value="9" > <?php echo SyTranslator::Sept($lang)?> </OPTION>
					<OPTION value="10" > <?php echo SyTranslator::Oct($lang)?> </OPTION>
					<OPTION value="11" > <?php echo SyTranslator::Nov($lang)?> </OPTION>
					<OPTION value="12" > <?php echo SyTranslator::Dec($lang)?> </OPTION>
				</select>
			</div>
			<div class="col-xs-5">
				<select class="form-control" name="year_start">
					<?php 
					for($i=2010; $i<=date('Y')+1; $i++){
						$checked = "";
						if ($i == date('Y')){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?php echo  $i?>" <?php echo  $checked?>> <?php echo $i?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::End_period($lang) ?></label>
				<div class="col-xs-5">
				<select class="form-control" name="month_end">
					<OPTION value="1" > <?php echo SyTranslator::Jan($lang)?> </OPTION>
					<OPTION value="2" > <?php echo SyTranslator::Feb($lang)?> </OPTION>
					<OPTION value="3" > <?php echo SyTranslator::Mar($lang)?> </OPTION>
					<OPTION value="4" > <?php echo SyTranslator::Apr($lang)?> </OPTION>
					<OPTION value="5" > <?php echo SyTranslator::May($lang)?> </OPTION>
					<OPTION value="6" > <?php echo SyTranslator::Jun($lang)?> </OPTION>
					<OPTION value="7" > <?php echo SyTranslator::July($lang)?> </OPTION>
					<OPTION value="8" > <?php echo SyTranslator::Aug($lang)?> </OPTION>
					<OPTION value="9" > <?php echo SyTranslator::Sept($lang)?> </OPTION>
					<OPTION value="10" > <?php echo SyTranslator::Oct($lang)?> </OPTION>
					<OPTION value="11" > <?php echo SyTranslator::Nov($lang)?> </OPTION>
					<OPTION value="12" > <?php echo SyTranslator::Dec($lang)?> </OPTION>
				</select>
			</div>
			<div class="col-xs-5">
				<select class="form-control" name="year_end">
					<?php 
					for($i=2010; $i<=date('Y')+1; $i++){
						$checked = "";
						if ($i == date('Y')){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?php echo  $i?>" <?php echo  $checked?>> <?php echo $i?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Export($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="export_type"> 
					<OPTION value="1" > Graph </OPTION>
					<OPTION value="2" > csv </OPTION>
				</select>
			</div>
		</div>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
