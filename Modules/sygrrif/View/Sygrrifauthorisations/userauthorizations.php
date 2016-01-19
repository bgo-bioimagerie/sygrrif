<?php $this->title = "SyGRRiF user authorization"?>

<?php echo $navBar?>

<head>
<link href="externals/datepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/core/View/usersnavbar.php"; ?>

<br>
	<div class="col-md-10 col-md-offset-1">
	
	<?php 
	if ($message != ""){
		?>
		<div class="alert alert-success text-center">
		<?php echo $message ?>
		</div>
		<?php 
	}
	?>
	
	<form role="form" class="form-horizontal" action="Sygrrifauthorisations/userauthorizationsquery"
		method="post">
	
		<div class="page-header">
			<h1>
				<?php echo SyTranslator::Authorisations_for($lang) . " : " . $userName ?> <br> <small></small>
			</h1>
		</div>
	
		<input class="form-control" type="hidden"  name="user_id" value="<?php echo $userID?>" />
		<input class="form-control" type="hidden"  name="unit_id" value="<?php echo $unit_id?>" />
	
		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th width="50%"> <?php echo SyTranslator::Resource($lang) ?> </th>
					<th width="10%"> <?php echo SyTranslator::Active_Authorizations($lang) ?> </th>
					<th width="20%"> <?php echo SyTranslator::Date($lang) ?> </th>
					<th width="20%"> <?php echo SyTranslator::Visa($lang) ?> </th>
				</tr>
			</thead>
			<tbody>
		
		<?php 
		foreach($resources as $resource){
			
			// search if there is an authorization
			$idx = 0;
			$found = false;
			for($i = 0 ; $i < count($userAuthorizations) ; $i++){
				if ($userAuthorizations[$i]["resource_id"] == $resource["id"]){
					$idx = $i;
					$found = true;
					break;
				}
			}
			?>
			<tr>
			<td> <input type="hidden" name="resource_id[]" value="<?php echo $resource["id"]?>"> <?php echo $resource["name"] ?> </td>
			<?php 
			if ($found){
				?>
					<td> 
					    <?php 
					    $is_active = $this->clean($userAuthorizations[$idx]['is_active']);
					    $bg_color = "#FF8C00";
					    if ($is_active == 1){
					    	$bg_color = "#32CD32";
					    }
					    ?>
						<select style="background-color:<?php echo $bg_color?>;" class="form-control" name="is_active[]">
							<?php 
							
							?>
							<OPTION value="1" <?php if ($is_active == 1){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::Yes($lang)?> </OPTION>
							<OPTION value="0" <?php if ($is_active == 0){echo "selected=\"selected\"";} ?>> <?php echo  SyTranslator::No($lang) ?> </OPTION>
						</select>
					</td>
					<td> 
						<div class='input-group date form_date_<?php echo  $lang ?>' >
							<input type='text' class="form-control" name="date[]"
							       value="<?php echo  CoreTranslator::dateFromEn($this->clean($userAuthorizations[$idx]['date']), $lang)  ?>"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div> 
					</td>
					<td>
						<select class="form-control" name="visa_id[]">
							<OPTION value="1"> -- </OPTION>
							<?php 
							$authVisaId = $this->clean($userAuthorizations[$idx]['visa_id']);
							foreach ($visas[$resource["id"]] as $visa):?>
							    <?php $visaname = $this->clean( $visa['desc']);
							          $visaId = $this->clean( $visa['id'] );
							          $checked = "";
							          if ($authVisaId == $visaId){
							          	$checked = "selected=\"selected\"";
							          }
							    ?>
								<OPTION value="<?php echo  $visaId ?>" <?php echo  $checked ?> > <?php echo  $visaname ?> </OPTION>
							<?php endforeach; ?>
						</select>
						
					</td>
				
				<?php 
			}
			else{
			?>
				<td> 
					<select style="background-color: #FF8C00;" class="form-control" name="is_active[]">
						<OPTION value="1" > <?php echo SyTranslator::Yes($lang)?> </OPTION>
						<OPTION value="0" selected="selected"> <?php echo SyTranslator::No($lang) ?> </OPTION>
					</select>
				</td>
				<td> 
					<div class='input-group date form_date_<?php echo  $lang ?>' >
						<input type='text' class="form-control" name="date[]"
						       value=""/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</td>
				<td>
						<select class="form-control" name="visa_id[]">
							<OPTION value="1"> -- </OPTION>
							<?php 
							foreach ($visas[$resource["id"]] as $visa):
									$visaname = $this->clean( $visa['desc']);
								    $visaId = $this->clean( $visa['id'] );
								   ?>
								<OPTION value="<?php echo  $visaId ?>"> <?php echo  $visaname ?> </OPTION>
							<?php endforeach; ?>
						</select>
				</td>
			<?php
			} 
			?>
			</tr>
			<?php 
		}
		?>
		</tbody>
		</table>
		
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='coreusers'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
</div>


<?php include 'Modules/core/View/timepicker_script.php'?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
