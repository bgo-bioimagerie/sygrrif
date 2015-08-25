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
	include "Modules/storage/View/storagenavbar.php";
}
?>

<div class="content">
	
  <div class="col-lg-10 col-lg-offset-1">
  <?php if (isset($message) && $message != "" ): ?>

	<div class="col-lg-12">
		<br/>
	</div>
	
        <div class="alert alert-success" role="alert">
    	<p><?= $message ?></p>
    	</div>
  <?php endif; ?>
  </div>

  <div class="col-lg-10 col-lg-offset-1">
	<div class="page-header">
		<h2>
			<?= StTranslator::ManageFiles($lang) ?> <br> <small></small>
		</h2>
	</div>
	
	<div class="col-lg-10 col-lg-offset-1">
		<br/>
	</div>

	<div class="col-lg-10 col-lg-offset-1">

	<div class="col-lg-12">
	<form role="form" action="storage/download" method="post">
		<div class="col-lg-4"><label><?= StTranslator::LocalDirDownload($lang) ?></label></div>
		<div class="col-lg-8"><input class="form-control" type="text" name="localurl" id="localurl" required/></div>
		
	</div>
	
	<div class="col-lg-12"><br/></div>
	
	<table class="table table-striped table-bordered">
		<theader>
			<tr>
				<th style="width:70%;">File Name</th>
				<th style="width:20%;">Size</th>
				<th style="width:10%;">Download</th>
			</tr>
		</theader>
		
		<?php 
		$fileNum = 0;
		foreach($files as $file){
			$fileNum++;
			?>
			<tr>
				<td><?= $file["name"] ?></td>
				<td><?= $file["size"] ?></td>
				
				<?php 
				//$fileURL = str_replace(".", "__--__",$file["name"]);
				//$fileURL = str_replace(" ", "__---__", $fileURL);
				//$fileURL = str_replace("/", "__----__", $fileURL);
				$fileURL = $file["name"];
				?>
				
				<td>
				<input type="text" name="filename_<?=$fileNum?>" value="<?=$fileURL?>" hidden/>
				<INPUT type="checkbox" name="data_<?=$fileNum?>" >
				</td>	
			</tr>
		<?php }?>
	</table>
	<input type="text" name="numFiles" value="<?=$fileNum?>" hidden/>
	<div class="col-xs-1 col-xs-offset-11">
		<input  class="btn btn-primary" type="submit" value="<?= StTranslator::Download($lang)?>" />
	</div>
	</form>

	<div class="col-lg-12">
		<label>Disk Usage:</label>
		<?= $userUsage ?> 
		<br/>
		<label>Disk Quotas:</label>
		<?= $userQuotas ?> Go
	</div>
	
	</div>
	</div>
	
  	<div>
</div>