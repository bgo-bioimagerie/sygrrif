<?php $this->title = "Platform-Manager" ?>

<head>
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    #topnavbar{
  		height:80px;
  		margin-bottom:-0px;
	}
    </style>
</head>

<style>
ul {
    list-style-type: none;
    padding: 0px;
    margin-left: 30px;
}

ul li {
}

#keylink{
	color:#000000;
}
</style>

<div class="col-lg-12" style="background-color: #fff; border-bottom: 1px solid #e1e1e1;">
<div class="col-lg-offset-1">
<h4>Tutoriels</h4>
</div>
</div>

<div style="height: 75px;">

</div>

<div class="col-lg-12">

<!-- MENU -->
<?php if ($menuInfo["id"] > 0){ ?>
    <div class="col-lg-2 col-lg-offset-1" style="background-color:#f1f1f1">

    <h5 id="nav_title">
    <?php echo $menuInfo["title"] ?>
    </h5>
    <ul>
        <?php foreach ($menuItems as $item){ ?>
            <li><a id="nav_link" href="<?php echo $item["url"] ?>"> <?php echo $item["title"] ?> </a></li>
        <?php } ?>
    </ul>
    </div>

<?php } ?>

<?php if ($menuInfo["id"] > 0){ ?>
    <div class="col-lg-9">
<?php }else{ ?>
    <div class="col-lg-12">
<?php } ?>
    
<!-- ADD TUTO LIST -->
<?php $count = 0; ?>
<?php foreach($articles as $article ){
	?>
	<?php 
	if (isset($article["id"])){
	if($count == 0){
		?>
		<div class="row" style="margin-top: 25px;" >
		<?php 
	}
	?>
	
	<div class="col-xs-3" style="border: solid 1px #e1e1e1; border-bottom: solid 3px #e1e1e1; height:300px; width:220px; margin-left: 25px;">
		
		<!-- 
		<div style="border: solid 1px #e1e1e1; border-bottom: solid 3px #e1e1e1; height:300px; width:220px;">
		 --> 	
		 <div style="margin-left: -15px;">
			<!-- IMAGE -->
			<a href="wbarticles/article/<?= $article["id"] ?>">
			<img src="<?= $article["image_url"] ?>" alt="image" style="width:218px;height:150px">
			</a>
			<!-- TITLE -->
			<p style="color:#018181; text-transform:uppercase;">
			<a href="wbarticles/article/<?= $article["id"] ?>"><?= $article["title"] ?></a>
			</p>
			
			
			<?php 
			// "c=" . strlen($tutorial["title"])."<br/>";
			if (strlen($article["title"])<20){
				echo "<br/>";
			}?>
			
			<!-- DESC -->
			<p style="color:#515151;">
			<?php echo $article["short_desc"] ?>
			</p>
			
			
		<!-- 
		</div>
		-->
		 </div>
	</div>
	<div class="col-xs-1" style="width:20px;">
	</div>
		
				<?php
		$count++;
		if($count == 3){
			$count = 0;
			echo "</div>";
		} 
		
		?>	
<?php
}
	}?>
</div>
</div>


<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>

