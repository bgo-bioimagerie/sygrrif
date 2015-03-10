<?php $this->title = "Anticorps: Edit Isotype"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>

</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<form role="form" class="form-horizontal" action="protocols/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
				<?php if($protocol['id'] != ""){ ?>
					Editer protocole <br> <small></small>
				<?php 
				} else {
				?>	
					Ajouter protocole <br> <small></small>
				<?php } ?>
			</h1>
		</div>
	
		<?php if($protocol['id'] != ""){ ?>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Id</label>
			<div class="col-xs-10">
				<input class="form-control" id="id" type="text" name="id" disabled
				       value="<?= $protocol['id'] ?>"  
				/>
			</div>
		</div>
		<?php } ?>
		
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">KIT</label>
			<div class="col-xs-10">
				<input class="form-control" id="kit" type="text" name="kit"
				       value="<?= $this->clean ( $protocol ['kit'] ); ?>"  
				/>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">No Proto</label>
			<div class="col-xs-10">
				<input class="form-control" id="no_proto" type="text" name="no_proto"
				       value="<?= $this->clean ( $protocol ['no_proto'] ); ?>"  
				/>
			</div>
		</div>
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Proto</label>
			<div class="col-xs-10">
				<input class="form-control" id="proto" type="text" name="proto"
				       value="<?= $this->clean ( $protocol ['proto'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Fixative</label>
			<div class="col-xs-10">
				<input class="form-control" id="fixative" type="text" name="fixative"
				       value="<?= $this->clean ( $protocol ['fixative'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Option</label>
			<div class="col-xs-10">
				<input class="form-control" id="option" type="text" name="option"
				       value="<?= $this->clean ( $protocol ['option_'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">enzyme</label>
			<div class="col-xs-10">
				<input class="form-control" id="enzyme" type="text" name="enzyme"
				       value="<?= $this->clean ( $protocol ['enzyme'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">dém</label>
			<div class="col-xs-10">
				<input class="form-control" id="dem" type="text" name="dem"
				       value="<?= $this->clean ( $protocol ['dem'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">AcI Inc</label>
			<div class="col-xs-10">
				<input class="form-control" id="acl_inc" type="text" name="acl_inc"
				       value="<?= $this->clean ( $protocol ['acl_inc'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Linker</label>
			<div class="col-xs-10">
				<input class="form-control" id="acl_inc" type="text" name="linker"
				       value="<?= $this->clean ( $protocol ['linker'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Inc</label>
			<div class="col-xs-10">
				<input class="form-control" id="inc" type="text" name="inc"
				       value="<?= $this->clean ( $protocol ['inc'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">AcII</label>
			<div class="col-xs-10">
				<input class="form-control" id="acll" type="text" name="acll"
				       value="<?= $this->clean ( $protocol ['acll'] ); ?>"  
				/>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2">Inc</label>
			<div class="col-xs-10">
				<input class="form-control" id="inc2" type="text" name="inc2"
				       value="<?= $this->clean ( $protocol ['inc2'] ); ?>"  
				/>
			</div>
		</div>			    

		<br></br>		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Save" />
				<button type="button" onclick="location.href='protocols'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
