<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>

<?php include "Modules/core/View/Users/usersnavbar.php"; ?>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" action="users/addquery" method="post">
		<div class="page-header"> 
			<h1>
			<?php echo  CoreTranslator::Add_User($lang) ?>
			<br> <small></small>
			</h1> 
		</div> 
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name" 
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Firstname($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="firstname" type="text" name="firstname"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="login" class="control-label col-xs-2"><?php echo  CoreTranslator::Login($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="login" type="text" name="login"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="pwd" class="control-label col-xs-2"><?php echo  CoreTranslator::Password($lang) ?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
			</div>
			<label for="pwdc" class="control-label col-xs-2"><?php echo  CoreTranslator::Confirm($lang) ?></label>
			<div class="col-xs-4">
				<input type="password" class="form-control" id="pwdc" name="pwdc" placeholder="Password">
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Email($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="email" type="text" name="email"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Phone($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="phone" type="text" name="phone"
				/>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Unit($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="unit">
					<?php foreach ($unitsList as $unit):?>
					    <?php $unitname = $this->clean( $unit['name'] );
					          $unitId = $this->clean( $unit['id'] );
					    ?>
						<OPTION value="<?php echo  $unitId ?>" > <?php echo  $unitname ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Responsible($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="responsible">   
					<?php foreach ($respsList as $resp):?>
					    <?php   $respId = $this->clean( $resp['id'] );
					    		if ($resp['id'] > 1){
							    	$respSummary = $this->clean( $resp['name'] ) . " " . $this->clean( $resp['firstname'] ) ;
					    		}
					    		else{
					    			$respSummary = "--";
					    		}
						?>
						<OPTION value="<?php echo  $respId ?> " > <?php echo  $respSummary ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"></label>
			<div class="col-xs-10">
			  <div class="checkbox">
			    <label>
			      <input type="checkbox" name="is_responsible" > <?php echo  CoreTranslator::is_responsible($lang) ?>
			    </label>
              </div>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Status($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="status">
					<?php foreach ($statusList as $status):?>
					    <?php $statusname = $this->clean( $status['name'] );
					          $statusid = $this->clean( $status['id'] );
					    ?>
						<OPTION value="<?php echo  $statusid ?>"> <?php echo  CoreTranslator::Translate_status($lang, $statusname) ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<br/>
		
		<input type="hidden" name="convention" value="-1">
		<!-- 
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Convention($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="convention">
					<OPTION value="-1" > auto </OPTION>
					<?php foreach ($conventionsList as $convention):?>
					    <?php $convention = $this->clean( $convention[0] );
					    ?>
						<OPTION value="<?php echo  $convention ?>" > <?php echo  $convention ?> </OPTION>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		 -->
		<br/>
		<div class="form-group ">
		
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_convention($lang) ?></label>
			<div class="col-xs-10">
				<div class='input-group date form_date_<?php echo  $lang ?>'>
					<input type='text' class="form-control" data-date="" name="date_convention"/>
					<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
		    </div>
		</div>
		<br/>
		<div class="form-group ">
			<label for="inputEmail" class="control-label col-xs-2"><?php echo  CoreTranslator::Date_end_contract($lang) ?></label>
				<div class="col-xs-10">
					<div class='input-group date form_date_<?php echo  $lang ?>' id='datetimepicker6'>
						<input type='text' class="form-control" name="date_end_contract"/>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
		</div>		
        <br/>
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?php echo  CoreTranslator::Save($lang)?>" />
				<button type="button" onclick="location.href='users'" class="btn btn-default"><?php echo  CoreTranslator::Cancel($lang) ?></button>
		</div>

	  </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php';?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
