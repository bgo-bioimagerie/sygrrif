<?php $this->title = "SyGRRiF Database account"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="coreusersettings/editsettings" method="post">
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Language($lang) ?>
				<br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Language($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="language">
					<OPTION value="En" <?php if($language == "En"){echo "selected=\"selected\""; }?>> English </OPTION>
					<OPTION value="Fr" <?php if($language == "Fr"){echo "selected=\"selected\""; }?>> French </OPTION>
				</select>
			</div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
      
      <form role="form" class="form-horizontal" action="coreusersettings/edithomepage" method="post">
		<div class="page-header">
			<h1>
				<?php echo  CoreTranslator::Home_page($lang)?> <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Home_page($lang)?></label>
			<div class="col-xs-10">
				<input type="text" class="form-control" name="homepage" value="<?php echo  $homePage ?>" />
			</div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
      
    </div>
</div>