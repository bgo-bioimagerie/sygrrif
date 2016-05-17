<?php $this->title = "SyGRRiF add a resources category"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="sygrrifareasresources/addresourcescategoryquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Add_a_resources_category($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				/>
			</div>
		</div>
                <?php if (count($sites) > 0){ ?>
                <br/>
                <div class="form-group">
			<label class="control-label col-xs-2"><?php echo  CoreTranslator::Site($lang) ?></label>
			<div class="col-xs-10">
                            <select class="form-control" name="id_site">
                                <?php foreach($sites as $site): 
                                    
                                    ?>
                                    <OPTION value="<?php echo $site["id"] ?>" > <?php echo $site["name"] ?> </OPTION>
                                <?php endforeach; ?>
                            </select>
			</div>
                </div>
                <?php } ?>
		<br/>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Add($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources/resourcescategory'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
