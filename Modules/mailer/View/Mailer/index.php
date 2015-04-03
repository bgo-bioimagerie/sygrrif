<?php $this->title = "SyGRRiF email"?>
<?php require_once 'Modules/mailer/Model/MailerTranslator.php';?>
<?php require_once 'Modules/sygrrif/Model/SyTranslator.php';?>
<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php echo $navBar?>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
	  <form role="form" action="mailer/send" method="post">
		<div class="page-header"> 
			<h1>
			<?= MailerTranslator::mailler($lang) ?>
			<br> <small></small>
			</h1> 
		</div> 
		<br><br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= MailerTranslator::From($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="from" type="text" name="from" value="<?= $from ?>" readonly
				/>
			</div>
		</div>
		<br><br/>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= MailerTranslator::To($lang) ?></label>
			<div class="col-xs-10">
				<select class="form-control" name="to">
					<OPTION value="all" > all </OPTION>
					<?php foreach ($areasList as $area):?>
					    <?php $areaname = $this->clean( $area['name'] );
					          $areaId = $this->clean( $area['id'] );
					    ?>
						<OPTION value="a_<?= $areaId ?>" > <?= SyTranslator::Area($lang)  . ": " .  $areaname ?> </OPTION>
					<?php endforeach; ?>
					
					<?php foreach ($resourcesList as $resourceArea){?>
						<?php foreach ($resourceArea as $resource){?>
					    <?php $areaname = $this->clean( $resource['name'] );
					          $areaId = $this->clean( $resource['id'] );
					    ?>
						<OPTION value="r_<?= $areaId ?>" > <?= SyTranslator::Resource($lang)  . ": " .  $areaname ?> </OPTION>
					<?php }} ?>
				</select>
			</div>
		</div>
		<br><br />
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= MailerTranslator::Subject($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="subject" type="text" name="subject"
				/>
			</div>
		</div>
		<br><br />
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= MailerTranslator::Content($lang) ?></label>
			<div class="col-xs-10">
				<textarea class="form-control" id="content" type="text" name="content"
				>
				</textarea>
			</div>
		</div>
        <br><br/>
        <div class="form-group">
        <br><br/>
		<div class="col-xs-2 col-xs-offset-10" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= MailerTranslator::Send($lang)?>" />
		</div>
		</div>

	  </form>
	</div>
</div>

<?php include 'Modules/core/View/timepicker_script.php';?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
