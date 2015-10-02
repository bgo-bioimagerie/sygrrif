<?php $this->title = "Storage"?>

<?php echo $navBar?>

<?php
$lang = "En";
if (isset ( $_SESSION ["user_settings"] ["language"] )) {
	$lang = $_SESSION ["user_settings"] ["language"];
}
?>

<head>
<script type="text/javascript" src="externals/jquery-1.11.1.js" charset="UTF-8"></script>
</head>

<?php 
if($menu){
	//include "Modules/storage/View/storagenavbar.php";
}
?>

<div class="content">
	
  <div class="col-lg-10 col-lg-offset-1">
  <?php if (isset($message) && $message != "" ): ?>

	<div class="col-lg-12">
		<br/>
	</div>
	
        <div class="alert alert-success" role="alert">
    	<p><?php echo  $message ?></p>
    	</div>
  <?php endif; ?>
  </div>

  <div class="col-lg-10 col-lg-offset-1">
	<div class="page-header">
		<h2>
			<?php echo  StTranslator::ManageFiles($lang) ?> <br> <small></small>
		</h2>
	</div>
	
	<div class="col-lg-10 col-lg-offset-2">
		<br/>
	</div>
	
	<div class="col-lg-12"><br/></div>
	
	<?php 
	foreach ($files as $filesDir){
		?>
		
		<div class="page-header">
			<h3>
			<?php echo  $filesDir["name"] ?> <br> <small></small>
			</h3>
		</div>
			
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th style="width:65%;">File Name</th>
				<th style="width:15%;">Size</th>
				<th style="width:20%;">Last modification</th>
				<th style="width:10%;"></th>
			</tr>
		</thead>
		<tbody>
		
		<?php foreach($filesDir["files"] as $file){?>
			<tr>
				<td><?php echo  $file["name"] ?></td>
				<td><?php echo  $file["size"] ?></td>
				
				<?php 
				$mtime = "";
				if ($lang == "Fr"){
					$mtime = date("d/m/Y H:i:s", $file["mtime"]);
				}
				else{
					$mtime = date("Y-m-d H:i:s", $file["mtime"]);
				}
				
				?>
				<td><?php echo  $mtime ?></td>
				
				<?php 
				$fileURL = $file["name"];
				?>
				
				<td>
				<form name="downloadform" id="downloadform" role="form" class="form-horizontal" action="storage/download" method="post">
				<input type="text" name="filename" value="<?php echo $fileURL?>" hidden/>
				<input type="text" name="dir" value="<?php echo $filesDir["name"]?>" hidden/>
				<input  class="btn btn-primary" type="submit" value="<?php echo  StTranslator::Download($lang)?>" />
				</form>
				</td>		
			</tr>
		<?php }?>
		</tbody>
	</table>

	<?php 
	}
	?>
	
	<!--
	<div class="col-lg-12">
		<label>Disk Usage:</label>
		<?php echo  $userUsage ?> 
	</div>
	-->
	
	</div>
	</div>
	
  	<div>
</div>