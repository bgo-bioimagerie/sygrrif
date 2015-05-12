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
	<form name="formlocalurl">
		<div class="col-lg-4"><label><?= StTranslator::LocalDirDownload($lang) ?></label></div>
		<div class="col-lg-8"><input class="form-control" type="text" name="localurl" id="localurl"
		     onblur="document.downloadform.localurl.value = this.value;"/></div>
	</form>	
	</div>
	
	<div class="col-lg-12"><br/></div>
	
	<table class="table table-striped table-bordered">
		<theader>
			<tr>
				<th style="width:60%;">File Name</th>
				<th style="width:20%;">Size</th>
				<th style="width:10%;"></th>
				<th style="width:10%;"></th>
			</tr>
		</theader>
		
		
		<?php foreach($files as $file){?>
			<tr>
				<td><?= $file["name"] ?></td>
				<td><?= $file["size"] ?></td>
				
				<?php 
				$fileURL = str_replace(".", "__--__",$file["name"]);
				$fileURL = str_replace(" ", "__---__", $fileURL);
				$fileURL = str_replace("/", "__----__", $fileURL);
				?>
				
				<td>
				<form name="downloadform" id="downloadform" role="form" class="form-horizontal" action="storage/download" method="post">
				<input type="text" name="localurl" id="localurl" onblur="document.formlocalurl.localurl.value = this.value;" hidden/>
				<input type="text" name="filename" value="<?=$fileURL?>" hidden/>
				<input  class="btn btn-primary" type="submit" value="<?= StTranslator::Download($lang)?>" />
				</form>
				</td>
				
				<!-- 
				<input  type="button" onclick="location.href='<?="storage/download".$fileURL ?>?>'" class="btn btn-primary"><?= StTranslator::Download($lang) ?>
				 -->
				
				<td><button  type="button" onclick="location.href='storage/deletefile/<?= $fileURL ?>'" class="btn btn-danger"><?= StTranslator::Delete($lang) ?></button></td>
			</tr>
		<?php }?>
	</table>

	<div class="col-lg-12">
		<label>Disk Usage:</label>
		<?= $userUsage ?> 
		<br/>
		<label>Disk Quotas:</label>
		<?= $userQuotas ?> Go
	</div>
	
	</div>
	</div>
	
	
	<div class="col-lg-10 col-lg-offset-1">
	<div class="page-header">
		<h2>
			<?= StTranslator::Upload($lang) ?> <br> <small></small>
		</h2>
	</div>
	
	<!-- 
	<form role="form" id="form1" class="form-horizontal" action="storage/uploadfile" method="post" enctype="multipart/form-data">
		<input class="btn btn-primary" type="file" id="files" name="files[]" multiple />
	    <output id="list"></output>
	</form>
	 -->
	 
	 <form role="form" id="form1" class="form-horizontal" action="storage/uploadfile" method="post" enctype="multipart/form-data">
		<div class="col-lg-2"><label><?= StTranslator::FilePath($lang) ?></label></div>
		<div class="col-lg-8"><input class="form-control" type="text" id="text" name="filename" /></div>
		<div class="col-lg-2"><input class="btn btn-primary" type="submit" id="submitform1"/></div>
	    <output id="list"></output>
	</form>

<script>
/*				
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
                  f.size, ' bytes, last modified: ',
                  f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
                  '<img src="Themes/loading.gif"/></li>');
    }
    document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
    document.forms['form1'].submit();
  }

  document.getElementById('files').addEventListener('change', handleFileSelect, false);
  */
</script>
	
  	<div>
</div>