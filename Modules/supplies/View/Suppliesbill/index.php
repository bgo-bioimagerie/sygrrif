<?php $this->title = "Supplies bill"?>

<?php echo $navBar?>

<head>

<script src="externals/jquery-1.11.1.js"></script>

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>
	
<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="suppliesbill"
		method="post" id="statform">
	
	
		<div class="page-header">
			<h1>
				<?php echo  SuTranslator::Supplies_bill($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<?php
		if ($errorMessage != ''){
			?>
			<div class="alert alert-danger">
				<p><?php echo  $errorMessage ?></p>
			</div>
		<?php } ?>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Unit($lang) ?> </label>
			<div class="col-xs-10">
					<select class="form-control" name="unit" id="unit" onchange="updateResponsibe(this);"
						>
					<?php 
					foreach ($unitsList as $unit){
						$unitId = $this->clean( $unit['id'] );	
						$unitName = $this->clean( $unit['name'] );
						$checked = "";
						if ($selectedUnitId == $unitId){
							$checked = ' selected="selected"';
						}
					?>
					<OPTION value="<?php echo  $unitId?>" <?php echo  $checked ?>> <?php echo $unitName?> </OPTION>
					<?php
					}
					?>
				</select>
				<script type="text/javascript">
    				function updateResponsibe(sel) {
    					$( "#statform" ).submit();
    				}
				</script>
			</div>
		</div>	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Responsible($lang)?></label>
			<div class="col-xs-10">
					<select class="form-control" name="responsible">
					<OPTION value="0" > ... </OPTION>
					<?php 
					foreach ($responsiblesList as $resp){
						$respId = $this->clean( $resp['id'] );	
						$respName = $this->clean( $resp['name'] . " " . $resp['firstname']);
					?>
					<OPTION value="<?php echo  $respId?>"> <?php echo $respName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
		</div>	
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='suppliesentries'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
