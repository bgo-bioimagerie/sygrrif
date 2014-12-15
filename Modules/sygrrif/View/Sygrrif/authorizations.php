<?php $this->title = "SyGRRiF Authorizations"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
				Autorisations<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="sygrrif/authorizations/id">ID</a></td>
					<td><a href="sygrrif/authorizations/date">Date</a></td>
					<td><a href="sygrrif/authorizations/userName">Name</a></td>
					<td><a href="sygrrif/authorizations/userFirstname">Firstname</a></td>
					<td><a href="sygrrif/authorizations/unit">Unit</a></td>
					<td><a href="sygrrif/authorizations/visa">Visa</a></td>
					<td><a href="sygrrif/authorizations/ressource">Resource</a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $authorizationTable as $auth ) : ?>
				<?php $authId = $this->clean ( $auth ['id'] ); ?> 
				<tr>
					<td><?= $authId ?></td>
				    <td><?= $this->clean ( $auth ['date'] ); ?></td>
				    <td><?= $this->clean ( $auth ['userName'] ); ?></td>
				    <td><?= $this->clean ( $auth ['userFirstname'] ); ?></td>
				    <td><?= $this->clean ( $auth ['unitName'] ); ?></td>
				    <td><?= $this->clean ( $auth ['visa'] ); ?></td>
				    <td><?= $this->clean ( $auth ['resource'] ); ?></td>
				    <td>
				      <button type='button' onclick="location.href='sygrrif/editauthorization/<?= $authId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
