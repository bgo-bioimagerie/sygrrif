
<head>
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    

    <script type="text/javascript" src="externals/datepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="externals/datepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


<style>
.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 0px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
	border:0px solid #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 0px 0 rgba(0, 0, 0, .1);
	border:0px solid #337ab7;
}

#well {
	margin-top:10px;
	margin-bottom:25px;
	color: #cdbfe3;
	background-color: #337ab7;
	border:0px solid #337ab7;
}

legend {
	color: #ffffff;
}

#content{
	margin-top: -15px;
}

</style>

</head>

<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
require_once 'Modules/core/Model/CoreTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>


<div class="bs-docs-header" id="content">
	<div class="container">
		<h1><?= SyTranslator::SyGRRif_Booking($lang) ?></h1>

		<form role="form" class="form-horizontal" action="sygrrif/booking" method="post" id="navform">
		<div class='col-md-4' id="well">
			<fieldset>
				<legend><?= SyTranslator::Area($lang) ?></legend>
				<div >
					<select class="form-control" name="id_area" onchange="getareaval(this);">
						<?php 
						foreach($menuData['areas'] as $area){
							$areaID = $this->clean($area['id']);
							$curentPricingId = $this->clean($menuData['curentAreaId']);
							$selected = "";
							if ($curentPricingId == $areaID){
								$selected = "selected=\"selected\"";
							}
						?>
							<option value="<?= $areaID ?>" <?=$selected?>> <?= $this->clean($area['name']) ?> </option>
						<?php 
						}
						?>
					</select>
					<script type="text/javascript">
    					function getareaval(sel) {
    					$( "#navform" ).submit();
    					}
					</script>
				</div>
			</fieldset>
		</div>
		<div class='col-md-4' id="well">
			<fieldset>
				<legend><?= SyTranslator::Resource($lang) ?></legend>
				<div >
					<select class="form-control" name="id_resource"  onchange="getresourceval(this);">
						<option value="0" > ... </option>
						<?php 
						foreach($menuData['resources'] as $resource){
							$resourceID = $this->clean($resource['id']);
							$curentResourceId = $this->clean($menuData['curentResourceId']);
							$selected = "";
							if ($curentResourceId == $resourceID){
								$selected = "selected=\"selected\"";
							}
						?>
							<option value="<?= $resourceID ?>" <?=$selected?>> <?= $this->clean($resource['name']) ?> </option>
						<?php 
						}
						?>
					</select>
					<script type="text/javascript">
    					function getresourceval(sel) {
    					$( "#navform" ).submit();
    					}
					</script>
				</div>
			</fieldset>
		</div>
		<div class='col-md-3' id="well">
			<fieldset>
				<legend><?= SyTranslator::Date($lang) ?></legend>
				<div >
					<div class='input-group date form_date_<?= $lang ?>'>
						<input id="date-daily" type='text' class="form-control" name="curentDate"
							value="<?= CoreTranslator::dateFromEn($menuData["curentDate"], $lang) ?>"
						/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
		    	</div>
		    </fieldset>
		 </div>
		 
		 <div class='col-md-1' id="well">
			<fieldset>
			<legend style="color:#337ab7; border:0px solid #337ab7;">.</legend>
				<div >
				<input type="submit" class="btn btn-primary" value="ok" />
				</div>
			</fieldset>
		</div>   
	  </form>
	</div>
</div>

<?php include "Modules/core/View/timepicker_script.php" ?>