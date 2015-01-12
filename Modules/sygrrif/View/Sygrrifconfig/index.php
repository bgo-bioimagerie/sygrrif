<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<div class="container">
    	<div class="col-md-10 col-md-offset-1">
    	
    	<div class="page-header">
			<h1>
				SyGRRif configuration <br> <small></small>
			</h1>
		</div>
		
		
		<div class="col-xs-12">
		<div class="page-header">
			<h2>
				Install/Repair database <br> <small></small>
			</h2>
		</div>
		</div>
		
		<form role="form" class="form-horizontal" action="sygrrifconfig"
		method="post">
		
		<?php if (isset($installError)): ?>
        <div class="alert alert-danger" role="alert">
    	<p><?= $installError ?></p>
    	</div>
		<?php endif; ?>
		<?php if (isset($installSuccess)): ?>
        <div class="alert alert-success" role="alert">
    	<p><?= $installSuccess ?></p>
    	</div>
		<?php endif; ?>
		
		<p>
		To install the SyGRRif mudule, click "Install". This will create the 
		SyGRRif tables in the database if they don't exists or repair them
		if they exists
		</p>
		
		<div class="col-xs-10">
			<input class="form-control" type="hidden" name="installquery" value="yes"
				/>
		</div>

		<div class="col-xs-2 col-xs-offset-10" id="button-div">
			<input type="submit" class="btn btn-primary" value="Install" />
		</div>
      </form>
      
      
      <!-- Sygrrif Menu -->
      <div>
		  <div class="page-header">
			<h2>
				Activate/desactivate menus <br> <small></small>
			</h2>
		  </div>
		
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setmenusquery" value="yes"
			 	/>
		    </div>
		  
		    <div class="col-xs-12">
		    	<?php
		    	$sygrrifchecked = "";  
		    	if ($isSygrrifMenu){
		    		$sygrrifchecked = "checked=\"checked\"";
		    	}
		    	?>
        	  <label><input type="checkbox" name="sygrrifdatamenu" value="sygrrif" <?= $sygrrifchecked ?>> sygrrif menu </label>
    	    </div>
    	    <div class="col-xs-12">
		    	<?php
		    	$bookingchecked = "";  
		    	if ($isBookingMenu){
		    		$bookingchecked = "checked=\"checked\"";
		    	}
		    	?>
        	  <label><input type="checkbox" name="bookingmenu" value="booking" <?= $bookingchecked ?>> booking menu </label>
    	    </div>
		  
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
      <!-- set bill template section -->
      <div>
		<div class="page-header">
		  <h2>
			Bill template <br> <small></small>
		  </h2>
		</div>
		
		<?php 
		if (isset($templateMessage)){
			if ($templateMessage != ""){
				if ( strpos($templateMessage,'Error') !== false){
					?>
					<div class="alert alert-danger">
				<?php 
				} 
				else{
				?>	
				    <div class="alert alert-info">
				<?php 
				    
				}?>
					<p><?= $templateMessage ?></p>
					</div>
					<?php 
			}
		}
		?>
			
      <form action="sygrrifconfig" method="post" enctype="multipart/form-data">
      <div class="col-xs-10">
			<input class="form-control" type="hidden" name="templatequery" value="yes"
				/>
	  </div>
      
      <div class="form-group">
          <div class="col-md-10">
          <p>
          Select a xls file that will be used as template 
          to generate the SyGRRif bill</p>
    	
    	  <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
      </div>
      <div class="col-xs-2 col-xs-offset-10" id="button-div">
    	<input class="btn btn-primary" type="submit" value="Upload" name="submit">
      </div>
	  </form>
	  
	  <br></br>	
	  <br></br>
	  <!-- Booking options -->
      <div>
		  <div class="page-header">
			<h2>
				Booking summary options <br> <small></small>
			</h2>
		  </div>
		
		  <?php 
		  if ( isset($bookingOptionMessage) ){
		  	if ($bookingOptionMessage != ""){
		  		?>
		  		<div class="alert alert-info">	  
		  		<p><?= $bookingOptionMessage ?></p>
		  		</div>
		  		<?php 
		  	}
		  }	
		
		  ?>
		  
		  <?php 
		  if (isset($bookingSettings) && $bookingSettings != ""){
		  ?>
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setbookingoptionsquery" value="yes"
			 	/>
		    </div>
		    
		    <!-- recipient name -->
		    <?php 
		    //$tagName = $this->clean($bookingSettings[$i]['tag_name']);
		    $i=0;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient name:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rname">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rname">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rname">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rname">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 

		    <!-- recipient phone - rphone-->
		    <?php 
		    $i=1;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient phone:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rphone">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rphone">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rphone">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rphone">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 
		    
		    
		    <!-- short description - sdesc -->
		    <?php 
		    $i=2;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Short description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_sdesc">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_sdesc">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_sdesc">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_sdesc">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    </div> 
		    
		    <!-- description - desc -->
		    <?php 
		    $i=3;
			$tag_visible = $this->clean($bookingSettings[$i]['is_visible']);			
			$tag_title_visible = $this->clean($bookingSettings[$i]['is_tag_visible']);
			$tag_position = $this->clean($bookingSettings[$i]['display_order']);
			$tag_font = $this->clean($bookingSettings[$i]['font']);
			?>
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_desc">
				<OPTION value="1" <?php if ($tag_visible == 1){echo "selected=\"selected\"";}?>> Visible </OPTION>
				<OPTION value="0" <?php if ($tag_visible == 0){echo "selected=\"selected\"";}?>> Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_desc">
				<OPTION value="1" <?php if ($tag_title_visible == 1){echo "selected=\"selected\"";}?>> Tag Visible </OPTION>
				<OPTION value="0" <?php if ($tag_title_visible == 0){echo "selected=\"selected\"";}?>> Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_desc">
				<?php 
				for ($j = 0 ; $j < count($bookingSettings) ; $j++){
					$selected = "";
					if ($tag_position == $j+1){
						$selected = "selected=\"selected\"";
					}
					?>
					<OPTION value="<?= $j+1 ?>" <?= $selected ?>> position <?= $j+1 ?> </OPTION>
					<?php 				
				}
				?>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_desc">
				<OPTION value="normal" <?php if ($tag_font == "normal"){echo "selected=\"selected\"";}?>> normal </OPTION>
				<OPTION value="bold" <?php if ($tag_font == "bold"){echo "selected=\"selected\"";}?>> bold </OPTION>
				<OPTION value="italic" <?php if ($tag_font == "italic"){echo "selected=\"selected\"";}?>> italic </OPTION>
			</select></div>
		    <br></br>
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
		  <?php 
		  }
		  ?>
      
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>