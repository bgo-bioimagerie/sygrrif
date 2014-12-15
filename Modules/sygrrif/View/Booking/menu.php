
    <head>
        <link rel="stylesheet" href="bootstrap/datepicker/css/datepicker.css">
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css">
    </head>

    
<div class="col-md-2">
<br></br>
<br></br>
  <div>
    <label for="area" class="control-label">Area</label>
    <div >
      <select class="form-control" name="area">
      <?php 
      foreach($areas as $area){
      	$areaId = $this->clean($area['id']);
      	$areaName = $this->clean($area['name']);
      	$selected = "";
      	if ($areaId == $curentArea){
      		$selected = "selected=\"selected\"";
      	} 
      ?>
      <OPTION value="<?= $areaId ?>" <?= $selected ?>> <?= $areaName ?> </OPTION>	
      	
      <?php 
      }
      ?>
      </select>
    </div>
  </div>
  <div >
    <label for="resource" class="control-label">Resource</label>
    <div>
      <select class="form-control" name="resource">
      <?php 
      foreach($resources as $resource){
      	$resourceId = $this->clean($resource['id']);
      	$resourceName = $this->clean($resource['name']);
      	$selected = "";
      	if ($resourceId == $curentResource){
      		$selected = "selected=\"selected\"";
      	} 
      ?>
      <OPTION value="<?= $resourceId ?>" <?= $selected ?>> <?= $resourceName ?> </OPTION>	
      	
      <?php 
      }
      ?>
      </select>
    </div>
  </div>	

  <div class="page-header">
  </div>
  <div id="datepickerarea" class="text-center">
    <div class="date"  >
    </div>
        <!-- Load jQuery and bootstrap datepicker scripts -->
        <script src="bootstrap/jquery-1.11.1.js"></script>
        <script src="bootstrap/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $('.date').datepicker({
                    format: "yyyy/mm/dd",
    		    todayHighlight: true
                });
            
            });
        </script>
  </div>

  <div class="page-header">
  </div>
  <p>description of types</p>	

</div>
