<?php $this->title = "Anticorps: Isotypes"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-10 col-md-offset-1">
	
		<div class="page-header">
			<h1>
				Protocoles<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="protocols/index/id">Id</a></th>
					<th><a href="protocols/index/kit">KIT</a></th>
					<th><a href="protocols/index/no_proto">No Proto</a></th>
					<th><a href="protocols/index/proto">Proto</a></th>
					<th><a href="protocols/index/fixative">Fixative</a></th>
					<th><a href="protocols/index/option">Option</a></th>
					<th><a href="protocols/index/enzyme">Enzyme</a></th>
					<th><a href="protocols/index/dem">Dém</a></th>
					<th><a href="protocols/index/acl_inc">AcI Inc</a></th>
					<th><a href="protocols/index/linker">Linker</a></th>
					<th><a href="protocols/index/inc">Inc</a></th>
					<th><a href="protocols/index/acll">acII</a></th>
					<th><a href="protocols/index/inc2">Inc</a></th>
					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $protocols as $protocol ) : ?> 
				<tr>
					<?php $protocolId = $this->clean ( $protocol ['id'] ); ?>
					<td><?= $protocolId ?></td>
				    <td><?= $this->clean ( $protocol ['kit'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['no_proto'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['proto'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['fixative'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['option_'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['enzyme'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['dem'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['acl_inc'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['linker'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['inc'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['acll'] ); ?></td>
				    <td><?= $this->clean ( $protocol ['inc2'] ); ?></td>
				    
				    <td>
				      <button type='button' onclick="location.href='protocols/edit/<?= $protocolId ?>'" class="btn btn-xs btn-primary" id="navlink">Edit</button>
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
