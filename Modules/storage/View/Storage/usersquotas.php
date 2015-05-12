<?php $this->title = "Storage"?>

<?php echo $navBar?>

<?php
$lang = "En";
if (isset ( $_SESSION ["user_settings"] ["language"] )) {
	$lang = $_SESSION ["user_settings"] ["language"];
}
?>

<?php include "Modules/storage/View/storagenavbar.php"; ?>

<div class="content">
	
	<div class="col-lg-8 col-lg-offset-2">
	
	<div class="page-header">
		<h1>
			<?= StTranslator::Users_quotas($lang) ?> <br> <small></small>
		</h1>
	</div>
	
	
	<table class="table table-striped table-bordered">
		<theader>
			<tr>
				<th ><?= CoreTranslator::Login($lang) ?></th>
				<th ><?= CoreTranslator::Name($lang) ?></th>
				<th ><?= CoreTranslator::Firstname($lang) ?></th>
				<th ><?= StTranslator::Quota($lang) ?></th>
				<th ></th>
			</tr>
		</theader>
		
		
		<?php foreach($usersquotas as $quota){?>
			<tr>
				<td><?= $quota["login"] ?></td>
				<td><?= $quota["name"] ?></td>
				<td><?= $quota["firstname"] ?></td>
				<td><?= $quota["quota"] . " Go" ?></td>
				<td style="width:2.12%"><button onclick="location.href='storage/editquota/<?= $quota["id"] ?>'" class="btn btn-xs btn-primary"><?= CoreTranslator::Edit($lang) ?></button></td>  
	    		
			</tr>
		<?php }?>
	</table>

  	<div>
</div>