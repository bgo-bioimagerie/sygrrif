<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>

<style type="text/css">
    .box{
        display: none;
    }
</style>

</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="users/exportresponsablequery" method="post">
		<div class="page-header">
			<h1>
			<?= CoreTranslator::ExportResponsibles($lang) ?>
				<br> <small></small>
			</h1>
		</div>
				<br>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= CoreTranslator::Responsible($lang) ?></label>
			<div class="col-xs-8">
				<select class="form-control" name="id_type">
					<OPTION value="0"  > <?= CoreTranslator::All($lang) ?> </OPTION>
					<OPTION value="1"  > <?= CoreTranslator::Active($lang) ?> </OPTION>
					<OPTION value="2"  > <?= CoreTranslator::Unactive($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		<br />
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang)?>" />
				<button type="button" onclick="location.href='users'" class="btn btn-default"><?= CoreTranslator::Cancel($lang)?></button>
		</div>
		
      </form>