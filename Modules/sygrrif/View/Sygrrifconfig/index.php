<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   
</head>

<div class="container">
    	<div class="col-md-8 col-md-offset-2">
    	
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
      
      
  </div>
</div>    

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>