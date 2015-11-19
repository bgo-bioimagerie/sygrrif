<?php $this->title = "Sheets"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}
</style>
</head>


<?php include "Modules/sheet/View/navbar.php"; ?>

<br>
<div class="col-xs-9">
	<form role="form" class="form-horizontal" action="sheet/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  ShTranslator::Edit_Sheet($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" id="id" type="hidden"  name="id_template" value="<?php echo  $templateID ?>" />
		<?php 
		if (isset($sheet_id)){
			?>
			<input class="form-control" id="id" type="hidden"  name="id_sheet" value="<?php echo  $sheet_id ?>" />
			<?php
		}
		?>
	
		<?php foreach($elements as $element){
			// input string
			if ($element["id_element_type"] == 1){
				
				$value = $element["default_values"];
				if (isset($sheetInfos['id' . $element["id"]])){
					$value = $sheetInfos['id' . $element["id"]];
				}
				
				?>
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-2"><?php echo  $element['caption'] ?></label>
					<div class="col-xs-10">
						<input class="form-control" type="text" name="id<?php echo $element["id"]?>"
												       value="<?php echo  $value ?>"  />
					</div>
				</div>
				<?php
			}
			// input number
			else if($element["id_element_type"] == 2){
				
				$value = $element["default_values"];
				if (isset($sheetInfos['id' . $element["id"]])){
					$value = $sheetInfos['id' . $element["id"]];
				}
				
				?>
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-2"><?php echo  $element['caption'] ?></label>
					<div class="col-xs-10">
						<input class="form-control" type="number" name="id<?php echo $element["id"]?>"
																       value="<?php echo  $value ?>"  />
					</div>
				</div>
				<?php
			}
			// select
			else if($element["id_element_type"] == 3){
				
				$valueSelect = "";
				if (isset($sheetInfos['id' . $element["id"]])){
					$valueSelect = $sheetInfos['id' . $element["id"]];
				}
				
				?>
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-2"><?php echo  $element['caption'] ?></label>
					<div class="col-xs-10">
						<select class="form-control" name="id<?php echo $element["id"]?>">
							<?php 
							$values = explode(";", $element["default_values"]);
							foreach ($values as $value):
								$selected = "";
								if($value == $valueSelect){
									$selected = "selected=\"selected\"";
								}
								?>	
								<OPTION value="<?php echo  $value ?>" <?php echo $selected ?> > <?php echo  $value ?> </OPTION>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<?php
			}
			// separator
			else if($element["id_element_type"] == 4){
				?>
				<div class="form-group">
				<div class="page-header">
				<h2>
					<?php echo  $element['caption'] ?>
					<br> <small></small>
				</h2>
				</div>
				</div>
				<?php
			}
			
		} 
		?>
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sheet'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
				<?php 
				if (isset($sheet_id)){
					?>
					<button type="button" onclick="location.href='<?php echo "sheet/delete/".$this->clean($sheet_id) ?>'" class="btn btn-danger"><?php echo  CoreTranslator::Delete($lang) ?></button>
					<?php 
				}
				?>
		</div>
      </form>
	</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
