<?php $this->title = "Sheet"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/sheet/View/navbar.php"; ?>
<?php require_once 'Modules/sheet/Model/ShTranslator.php';?>

	<div class="col-md-9">
	
		<div class="page-header">
			<h1>
			<?php echo  $templateName ?>
			  <br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<?php 
					foreach($sheets as $arr){
					
						foreach($arr as $key => $val){
							if (!is_int($key) && $key != "id_template"){
								echo "<td>".$key."</td>";
							}
						}
						break;
					}
					?>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($sheets as $arr){
					?><tr> <?php
					foreach ( $arr as $key => $val ){
						if (!is_int($key) && $key != "id_template"){
					?> 
					
						<td><?php echo  $this->clean ($val) ?></td>
					<?php 	
					}}	
					?>
					<td>
						<button type='button' onclick="location.href='sheet/edit/<?php echo  $this->clean ( $arr ['id'] ) ?>'" class="btn btn-xs btn-primary"><?php echo  CoreTranslator::Edit($lang) ?></button>
					</td>  
		    		</tr>
		    	<?php } ?>
				
			</tbody>
		</table>

	</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
