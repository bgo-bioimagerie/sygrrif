<?php $this->title = "SyGRRiF Database account"?>

<?php echo $navBar?>
<?php 
require_once 'Modules/sygrrif/Model/SyTranslator.php';
$lang = $_SESSION["user_settings"];
$lang = $lang["language"];
?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
      
    <form role="form" class="form-horizontal" action="sygrrifusersettings/editcalendarsettings" method="post">
		<div class="page-header">
			<h1>
				<?php echo  SyTranslator::Calendar_Default_view($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Default view</label>
			<div class="col-xs-10">
				<select class="form-control" name="calendarDefaultView">
					<OPTION value="bookday" <?php if($calendarDefaultView == "bookday"){echo "selected=\"selected\""; }?>> <?php echo  SyTranslator::Day($lang) ?> </OPTION>
					<OPTION value="bookweek" <?php if($calendarDefaultView == "bookweek"){echo "selected=\"selected\""; }?>> <?php echo  SyTranslator::Week($lang) ?> </OPTION>
					<OPTION value="bookweekarea" <?php if($calendarDefaultView == "bookweekarea"){echo "selected=\"selected\""; }?>> <?php echo  SyTranslator::Week_Area($lang) ?> </OPTION>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Default resource</label>
			<div class="col-xs-10">
				<select class="form-control" name="calendarDefaultResource">
				<?php foreach($resources as $resourceArea){
					foreach ($resourceArea as $res){
						$selected = "";
						if ($calendarDefaultResource == $res["id"]){
							$selected = "selected=\"selected\"";
						}
						?>
						<OPTION value="<?php echo $res["id"]?>" <?php echo $selected?>> <?php echo  $res["name"] ?> </OPTION>
					<?php 	
					}
				}?>
				</select>
			</div>
		</div>
		
		<br>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  SyTranslator::Save($lang) ?>" />
				<button type="button" onclick="location.href='home'" class="btn btn-default" id="navlink"><?php echo  SyTranslator::Cancel($lang) ?></button>
		</div>
      </form> 
      
      
    </div>
</div>