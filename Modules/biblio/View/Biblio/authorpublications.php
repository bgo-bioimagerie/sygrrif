<?php $this->title = "Biblio"?>

<?php echo $navBar?>
<?php include "Modules/biblio/View/navbar.php"; ?>

<br>
<div class="contatiner">

	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
				Author Publications<br> <small></small>
			</h1>
		</div>

		<!-- Form -->
		<div class="col-lg-6 col-lg-offset-3">

			<form role="form" class="form-horizontal"
				action="biblio/authorpublications" method="post">
				<div class="form-group">
					<label for="inputEmail" class="control-label col-xs-4">Select an author</label>
					<div class="col-xs-8">
						<select class="form-control" name="author_id">
									<?php
									foreach ( $authors as $author ) {
										$Aid = $this->clean ( $author ['id'] );
										$Aname = $this->clean ( $author ['name'] ) . " " . $this->clean ( $author ['firstname'] );
										$selected = "";
										if ($curentAuthor == $Aid) {
											$selected = "selected=\"selected\"";
										}
											?>
											<OPTION value="<?php echo $Aid?>" <?php echo $selected?>> <?php echo $Aname?> </OPTION>
											<?php
									}
									?>
		 				</select>
					</div>
				</div>
				<div class="col-xs-2 col-xs-offset-10" id="button-div">
					<input type="submit" class="btn btn-primary" value="submit" />
				</div>
			</form>
		
		</div>
		
		<!-- Message -->
		<?php 
		if (isset($message) && $message!="" ){
		?>
		
		<div class="col-lg-12">
		<br></br>
		<?php	if (strpos($message, "Error") === false){?>
			<div class="alert alert-success text-center">	
		<?php 
		}
		else{
		?>
		 	<div class="alert alert-danger text-center">
		<?php 
		}
		?>
		<p><?php echo  $message ?></p>
		</div>
		<?php } ?>

		
		<!-- publication list -->
		<?php if (isset($publications) && !is_null($publications)){?>
		<div class="col-lg-12">
		<?php 
		foreach ($publications as $publi){
			$id = $publi['id']; 
			$desc = $publi['desc'];
			$url = $publi['url'];
			?>
			<div class="row">
			<br></br>
			<!-- view publi -->
			<div class="col-lg-10">
			<?php echo $desc ?>
			</div>
			<?php if ($url != ""){?>
			<div class="col-lg-1">
			<button onclick="location.href='<?php echo $url?>'" class="btn btn-xs btn-default" id="navlink">File</button>
			</div>
			<?php } ?>
			<!-- edit action -->
			<div class="col-lg-1 <?php if ($url == ""){echo "col-lg-offset-1";}?>" >
			<button onclick="location.href='biblio/editpublication/id_<?php echo $id?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
			</div>
			</div>
		<?php	
		}
		?>
		</div>
		<?php
		}
		?>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>