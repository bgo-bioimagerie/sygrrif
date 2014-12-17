
<head>
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">


<link href="data:text/css;charset=utf-8,"
	data-href="bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet"
	id="bs-theme-stylesheet">


<style>
.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #cdbfe3;
	background-color: #337ab7;
	border: none;
}

legend {
	color: #ffffff;
}
</style>

</head>

<div class="bs-docs-header" id="content">
	<div class="container">
		<h1>SyGRRif Booking</h1>

		<form role="form" class="form-horizontal" action="sygrrif/booking" method="post" id="navform">
		<div class='col-md-4 well'>
			<fieldset>
				<legend>Area</legend>
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
		<div class='col-md-4 well'>
			<fieldset>
				<legend>Resource</legend>
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
		<div class='col-md-4 well'>
			<fieldset>
				<legend>Date</legend>
				<div >
				<div class='input-group date' id='datetimepicker5'>
					<input id="date-daily" type='text' class="form-control" data-date-format="YYYY-MM-DD" name="curentDate"
						value="<?= $menuData["curentDate"] ?>"
					/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		        <script src="bootstrap/datepicker/js/moments.js"></script>
				<script src="bootstrap/jquery-1.11.1.js"></script>
				<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
	      		<script type="text/javascript">
				$(function () {
					$('#datetimepicker5').datetimepicker({
						pickTime: false
					});
				});
			    </script>
			    <script type="text/javascript">
			    $('#datetimepicker5').datepicker().on('changeDate', function (ev) {
	   				 $('#date-daily').change();
				});
				$('#date-daily').val('0000-00-00');
				$('#date-daily').change(function () {
					$( "#navform" ).submit();
				});
				</script>
		    </div>
		 </div>   
	  </form>
	</div>
</div>


