<?php $this->title = "SyGRRiF stats users"?>

<?php echo $navBar?>

<head>
</head>
	
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrifstatsusers/authorizeduserquery"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
			<?= SyTranslator::Authorized_users($lang) ?>
				 <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4"><?= SyTranslator::Resource_categories($lang) ?></label>
			<div class="col-xs-8">
					<select class="form-control" name="resource_id" id="resource_id"
						>
					<?php 
					foreach ($resourcesCategories as $r){
						$rId = $this->clean( $r['id'] );	
						$rName = $this->clean( $r['name'] );
					?>
					<OPTION value="<?= $rId ?>"> <?=$rName?> </OPTION>
					<?php
					}
					?>
				</select>
			</div>
			<div class="checkbox col-xs-8 col-xs-offset-4">
    		<label>
      		<input type="checkbox" name="email"> Email
    		</label>
  </div>
			
		</div>	
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang) ?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?= SyTranslator::Cancel($lang) ?></button>
		</div>
      </form>
	</div>
</div>

<!-- 
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrifstatsusers/userquery"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
				<?= SyTranslator::Active_users($lang) ?> <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">User status</label>
			<div class="col-xs-8">
					<select class="form-control" name="user_type" id="user_type"
						>
					<OPTION value="1"> <?= SyTranslator::User($lang) ?> </OPTION>
					<OPTION value="2"> <?= SyTranslator::Responsible($lang) ?> </OPTION>
					<OPTION value="3"> <?= SyTranslator::User_and_Responsible($lang) ?> </OPTION>
				</select>
			</div>
		</div>	
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= SyTranslator::Ok($lang)?>" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default"><?= SyTranslator::Cancel($lang)?></button>
		</div>
      </form>
	</div>
</div>
 -->
<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
