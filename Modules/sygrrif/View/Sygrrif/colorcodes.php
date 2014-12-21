<?php $this->title = "SyGRRiF Color codes"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Color codes<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrif/colorcode/id">Id</a></td>
					<td><a href="sygrrif/colorcode/name">Name</a></td>
					<td><a href="sygrrif/colorcode/color">Color</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $colorTable as $color ) :
				$colorId = $this->clean ( $color ['id'] ); 
				?> 
				<tr>
					<td><?= $colorId ?></td>
				    <td><?= $this->clean ( $color ['name'] ); ?></td>
				    <td><?= $this->clean ( $color ['color'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editcolorcode/<?= $colorId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
