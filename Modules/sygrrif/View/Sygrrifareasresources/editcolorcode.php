<?php $this->title = "SyGRRiF Edit Color Code"?>

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
	<form role="form" class="form-horizontal" action="sygrrifareasresources/editcolorcodequery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::Edit_Color_Code($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
		<label for="inputEmail" class="control-label col-xs-4">ID</label>
			<div class="col-xs-8">
			<input class="form-control" id="id" type="text"  name="id" value="<?php echo  $colorcode['id']?>" readonly/>
		</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Name($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?php echo  $colorcode['name'] ?>"  
				/>
			</div>
		</div>
            <?php if (count($sites) > 0){ ?>
                <div class="form-group">
			<label class="control-label col-xs-4"><?php echo  CoreTranslator::Site($lang) ?></label>
			<div class="col-xs-8">
                            <select class="form-control" name="id_site">
                                <?php foreach($sites as $site): 
                                    $selected = "";
                                    if($site["id"] == $area["id_site"]){
                                        $selected = "selected=\"selected\"";
                                    }
                                    ?>
                                    <OPTION value="<?php echo $site["id"] ?>" <?php echo $selected ?> > <?php echo $site["name"] ?> </OPTION>
                                <?php endforeach; ?>
                            </select>
			</div>
                </div>
                <?php } ?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Color_diese($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="color" name="color"
				       value="<?php echo  $colorcode['color'] ?>"  
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Text_color_diese($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="color" name="text_color" value="<?php echo  $colorcode['text'] ?>"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?php echo  SyTranslator::Display_order($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" id="name" type="number" name="display_order"
				       value="<?php echo  $colorcode['display_order'] ?>"  
				/>
			</div>
		</div>
		<br></br>
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='sygrrifareasresources/colorcodes'" class="btn btn-default"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
