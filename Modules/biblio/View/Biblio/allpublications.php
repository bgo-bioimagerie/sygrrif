<?php $this->title = "Biblio"?>

<?php echo $navBar?>
<?php include "Modules/biblio/View/navbar.php"; ?>

<br>
<div class="contatiner">

	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
				All Publications<br> <small></small>
			</h1>
		</div>
		
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

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>