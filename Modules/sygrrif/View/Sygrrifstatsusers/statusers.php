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
				Authorized users <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">Resources Categories</label>
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
		</div>	
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Ok" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="sygrrifstatsusers/userquery"
		method="post" id="statform">
	
		<div class="page-header">
			<h1>
				Active users <br> <small></small>
			</h1>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-4">User status</label>
			<div class="col-xs-8">
					<select class="form-control" name="user_type" id="user_type"
						>
					<OPTION value="1"> User </OPTION>
					<OPTION value="2"> Responsible </OPTION>
					<OPTION value="3"> User and Responsible </OPTION>
				</select>
			</div>
		</div>	
		<div class="col-xs-3 col-xs-offset-9" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Ok" />
				<button type="button" onclick="location.href='sygrrif'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
