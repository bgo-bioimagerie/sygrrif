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
	<form role="form" class="form-horizontal" action="sygrrif/statisticsquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				Statistics <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Year</label>
			<div class="col-xs-10">
					<select class="form-control" name="year">
					<?php 
					for($i=2010; $i<=date('Y')+1; $i++){
						$checked = "";
						if ($i == date('Y')){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?= $i?>" <?= $checked?>> <?=$i?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Ok" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
