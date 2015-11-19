<?php $this->title = "SyGRRiF Color codes"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  SyTranslator::color_codes($lang) ?>
				<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/colorcode/id">ID</a></th>
					<th><a href="sygrrif/colorcode/name"><?php echo  SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/colorcode/color"><?php echo  SyTranslator::Color($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $colorTable as $color ) :
				$colorId = $this->clean ( $color ['id'] ); 
				?> 
				<tr>
					<td><?php echo  $colorId ?></td>
				    <td><?php echo  $this->clean ( $color ['name'] ); ?></td>
				    <td><?php echo  $this->clean ( $color ['color'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editcolorcode/<?php echo  $colorId ?>'" class="btn btn-xs btn-primary"><?php echo  SyTranslator::Edit($lang) ?></button>
				    </td>  
	    		</tr>
	    		<?php endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>
