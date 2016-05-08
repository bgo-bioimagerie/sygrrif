<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<div class="col-xs-12" style="background-color: #e9eaed;">
    <p></p>
</div>
<div class="col-xs-12" style="background-color: #e9eaed;">
    <?php include 'Modules/networking/View/navbar.php'; ?>
    <div class="col-md-10">
        <div class="col-md-12">
            
            <button type="button" class="btn btn-default btn-lg" onclick="window.location.href='ntgroups/edit/0'">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo NtTranslator::Add_Group($lang) ?>
            </button>
            <p></p>
        </div>
        
        <div class="col-md-12">
        <!-- ADD TUTO LIST -->
        <?php $count = 0;
	  $firstLine = true; ?>
        <?php foreach($groups as $group ){
		
	?>
	
	<?php 
	if (isset($group["id"])){
	if($count == 0){
		$margin = "style=\"margin-top: 25px;\"";
		if ($firstLine){
			$margin = "style=\"margin-top: 0px;\"";
		}
		?>
		
		<div class="row" <?= $margin ?> >
		<?php 
	}
	?>
	
	<div class="col-xs-3" style="background-color: #fff; height:300px; width:220px; margin-left: 25px; border:1px solid #ccc; border-radius: 5px;">
			
		 <div style="margin-left: -15px; padding: 12px;">
			<!-- IMAGE -->
			<a href="ntgroups/edit/<?= $group["id"] ?>">
			<img src="<?php echo $group["image_url"] ?>" alt="image" style="width:193px;height:150px">
			</a>
			<p>
			</p>
			<!-- TITLE -->
			<p style="color:#018181; text-transform:uppercase;">
			<a href="ntgroups/edit/<?php echo $group["id"] ?>"><?= $group["name"] ?></a>
			</p>
			
			
			<?php 
			// "c=" . strlen($tutorial["title"])."<br/>";
			if (strlen($group["name"])<20){
				echo "<br/>";
			}?>
					
			<!-- DESC -->
			<p style="color:#000; font-size:12px;">
			<?php echo  $group["description"] ?>
			</p>
			
		 
		 	</p>
		
		 </div>
	</div>
	<div class="col-xs-1" style="width:20px;">
	</div>
		
				<?php
		$count++;
		if($count == 3){
			$count = 0;
			$firstLine = false;
			echo "</div>";
		} 
		
		?>	
<?php
}
	}?>
</div>
</div>
        
     </div>    
        
        
    </div>    
    
</div>
<div class="col-xs-12" style="background-color: #e9eaed; height:2000px;">
    <p></p>
</div>


<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;

