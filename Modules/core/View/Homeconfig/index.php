<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<?php 
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form role="form" class="form-horizontal" action="homeconfig/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::HomeConfig($lang) ?>
				<br> <small></small>
			</h1>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::title($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="home_title" value="<?php echo  $this->clean($home_title) ?>" />
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::logo($lang) ?></label>
			<div class="col-xs-8">
				<input class="form-control" type="text" name="logo" value="<?php echo  $this->clean($logo) ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Description($lang) ?></label>
			<div class="col-xs-8">
				<textarea class="form-control"  name="home_message" ><?php echo  $home_message ?> </textarea>
			</div>
		</div>
		
		<div class="col-xs-3 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='coreconfig'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
