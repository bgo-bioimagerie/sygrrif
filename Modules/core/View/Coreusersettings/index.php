<?php $this->title = "SyGRRiF Database account"?>

<?php echo $navBar?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" class="form-horizontal" action="coreusersettings/editsettings" method="post">
		<div class="page-header">
			<h1>
				Language <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Language</label>
			<div class="col-xs-10">
				<select class="form-control" name="language">
					<OPTION value="En" <?php if($language == "En"){echo "selected=\"selected\""; }?>> English </OPTION>
					<OPTION value="Fr" <?php if($language == "Fr"){echo "selected=\"selected\""; }?>> French </OPTION>
				</select>
			</div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
      
      <form role="form" class="form-horizontal" action="coreusersettings/edithomepage" method="post">
		<div class="page-header">
			<h1>
				Home page <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Home Page</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" name="homepage" value="<?= $homePage ?>" />
			</div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
      
    </div>
</div>