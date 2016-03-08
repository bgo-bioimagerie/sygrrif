<?php $this->title = "SyGRRiF block resource"?>

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
	<form role="form" class="form-horizontal" action="sygrrifareasresources/blockresourcesquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::block_resources($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<div class="col-lg-12">
			<?php if ($errormessage != ""){
				?>
				<div class="alert alert-danger text-center">
					<p><?php echo  $errormessage ?></p>
		    	</div>
			<?php } ?>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Short_description($lang)?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="short_description"
				       value=""
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Resources($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="resources[]" size="10" multiple="multiple">
					<?php 
					foreach ($resources as $resource){
						?>
						<option value="<?php echo  $resource["id"] ?>"><?php echo  $resource["name"] ?></option>
						<?php
					}
					?>
 				</select>
			</div>
		</div>
		
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Beginning_of_the_reservation($lang)?>:</label>
			<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" name="begin_date"
					       value=""/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">    
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::time($lang)?>:</label>
				
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_hour"
				       value="" 
				/>
				</div>
				<div class="col-xs-1">
				<b>:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="begin_min"
				       value=""
				/>
				</div>
			</div>
		</div>
		
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::End_of_the_reservation($lang)?>:</label>
			<div class="col-xs-8">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" name="end_date"
					       value=""/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<div class="form-group">    
			<div class="col-xs-8 col-xs-offset-4">
				<!-- time -->
				
				<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::time($lang)?>:</label>
				
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="end_hour"
				       value="" 
				/>
				</div>
				<div class="col-xs-1">
				<b>:</b>
				</div>
				<div class="col-xs-3">
				<input class="form-control" id="name" type="text" name="end_min"
				       value=""
				/>
				</div>
			</div>
		</div>
		
				<!-- color code -->
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo SyTranslator::Color_code($lang)?></label>
			<div class="col-xs-8">
			<select class="form-control" name="color_code_id" <?php echo $readOnlyGlobal?>>
			<?php 
			$colorID = 1;
			foreach ($colorCodes as $colorCode){
				$codeID = $this->clean($colorCode["id"]);
				$codeName = $this->clean($colorCode["name"]);
				$selected = "";
				if ($codeID == $colorID ){
					$selected = "selected=\"selected\"";
				}
				?>
				<OPTION value="<?php echo  $codeID ?>" <?php echo  $selected ?>> <?php echo  $codeName?> </OPTION>
				<?php 
			}
			?>
			</select>
			</div>
		</div>
		
		<br></br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php"?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
