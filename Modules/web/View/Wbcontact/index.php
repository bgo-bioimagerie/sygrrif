<?php $this->title = "Platform-Manager"?>

<head>    
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="col-lg-12" style="background-color: #fff; border-bottom: 1px solid #e1e1e1;">
<div class="col-lg-offset-1">
    <h4><?php echo WbTranslator::Contact($lang) ?></h4>
</div>
</div>

<div class="col-lg-12" style="margin-top: 25px;">
</div>     
<div class="col-lg-8 col-lg-offset-2">
	
	<div class="col-lg-6 col-lg-offset-3">
	<p style="color:#515151;">
            <?php echo $content["content"] ?>
        <p>
	</div>
		
	<div class="col-lg-4 col-lg-offset-5">
	<p style="color:#515151;">
	<p>
	<img alt="" src="Themes/peopleb.png" width=24px> <?php echo $content["name"] ?>
	</p>
	<p style="margin-top: -13px;">
	<img alt="" src="Themes/telephoneb.png" width=30px style="margin-left:-3px">  <?php echo $content["tel"] ?> 
	</p>
	<p style="margin-top: -20px;">
	<img alt="" src="Themes/mailb.png" width=36px style="margin-left:-5px"><?php echo $content["email"] ?>
	</p>
	</div>
	</div>	
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
