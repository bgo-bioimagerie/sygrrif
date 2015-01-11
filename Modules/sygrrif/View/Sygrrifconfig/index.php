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
		  <form role="form" class="form-horizontal" action="sygrrifconfig"
		  method="post">
		  
		    <div class="col-xs-10">
			  <input class="form-control" type="hidden" name="setbookingoptionsquery" value="yes"
			 	/>
		    </div>
		    
		    <!-- recipient name -->
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient name:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rname">
				<OPTION value="0" > Visible </OPTION>
				<OPTION value="1" > Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rname">
				<OPTION value="0" > Tag Visible </OPTION>
				<OPTION value="1" > Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rname">
				<OPTION value="1" > position 1 </OPTION>
				<OPTION value="2" > position 2 </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rname">
				<OPTION value="1" > normal </OPTION>
				<OPTION value="2" > bold </OPTION>
				<OPTION value="3" > italic </OPTION>
			</select></div>
		    </div> 

		    <!-- recipient phone -->
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Recipient phone:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_rphone">
				<OPTION value="0" > Visible </OPTION>
				<OPTION value="1" > Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_rphone">
				<OPTION value="0" > Tag Visible </OPTION>
				<OPTION value="1" > Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_rphone">
				<OPTION value="1" > position 1 </OPTION>
				<OPTION value="2" > position 2 </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_rphone">
				<OPTION value="1" > normal </OPTION>
				<OPTION value="2" > bold </OPTION>
				<OPTION value="3" > italic </OPTION>
			</select></div>
		    </div> 
		    
		    <!-- short description -->
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Short description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_sdesc">
				<OPTION value="0" > Visible </OPTION>
				<OPTION value="1" > Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_sdesc">
				<OPTION value="0" > Tag Visible </OPTION>
				<OPTION value="1" > Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_sdesc">
				<OPTION value="1" > position 1 </OPTION>
				<OPTION value="2" > position 2 </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_sdesc">
				<OPTION value="1" > normal </OPTION>
				<OPTION value="2" > bold </OPTION>
				<OPTION value="3" > italic </OPTION>
			</select></div>
		    </div> 
		    
		    <!-- description -->
		    <div class="col-xs-12">
		    <div class="col-xs-3"><label class="control-label">Description:</label></div>
		    <div class="col-xs-2"><select class="form-control" name="tag_visible_desc">
				<OPTION value="0" > Visible </OPTION>
				<OPTION value="1" > Hiden </OPTION>
			</select></div>
			<div class="col-xs-3"><select class="form-control" name="tag_title_visible_desc">
				<OPTION value="0" > Tag Visible </OPTION>
				<OPTION value="1" > Tag Hiden </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_position_desc">
				<OPTION value="1" > position 1 </OPTION>
				<OPTION value="2" > position 2 </OPTION>
			</select></div>
			<div class="col-xs-2"><select class="form-control" name="tag_font_desc">
				<OPTION value="1" > normal </OPTION>
				<OPTION value="2" > bold </OPTION>
				<OPTION value="3" > italic </OPTION>
			</select></div>
		    
		    <br></br>
		  	<div class="col-xs-2 col-xs-offset-10" id="button-div">
			  <input type="submit" class="btn btn-primary" value="save" />
		    </div>
		  </form>
      </div>
      
      
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>