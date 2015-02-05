<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/core/View/Users/usersnavbar.php"; ?>

<br>
<div class="contatiner">

	<div class="col-lg-12">

		<div class="page-header">
			<h1>
			<?= CoreTranslator::Users($lang) ?>
			<br> <small></small>
			</h1>
		</div>
	
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td class="text-center"><a href="users/index/id">ID</a></td>
					<td class="text-center"><a href="users/index/name"><?= CoreTranslator::Name($lang) ?></a></td>
					<td class="text-center"><a href="users/index/firstname"><?= CoreTranslator::Firstname($lang) ?></a></td>
					<td class="text-center"><a href="users/index/login"><?= CoreTranslator::Login($lang) ?></a></td>
					<td class="text-center"><a href="users/index/email"><?= CoreTranslator::Email($lang) ?></a></td>
					<td class="text-center"><a href="users/index/tel"><?= CoreTranslator::Phone($lang) ?></a></td>
					<td class="text-center"><a href="users/index/id_unit"><?= CoreTranslator::Unit($lang) ?></a></td>
					<td class="text-center"><a href="users/index/id_responsible"><?= CoreTranslator::Responsible($lang) ?></a></td>
					<td class="text-center"><a href="users/index/id_status"><?= CoreTranslator::Status($lang) ?></a></td>
					<td class="text-center"><a href="users/index/id"><?= CoreTranslator::is_responsible($lang)?></a></td>
					<td class="text-center"><a href="users/index/convention"><?= CoreTranslator::Convention($lang)?></a></td>
					<td class="text-center"><a href="users/index/date_created"><?= CoreTranslator::User_from($lang) ?> </a></td>
					<td class="text-center"><a href="users/index/date_last_login"><?= CoreTranslator::Last_connection($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $usersArray as $user ) : ?> 
				<?php if ($user ['id'] > 1){ ?>
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td><?= $userId ?></td>
				    <td><?= $this->clean ( $user ['name'] ); ?></td>
				    <td><?= $this->clean ( $user ['firstname'] ); ?></td>
				    <td><?= $this->clean ( $user ['login'] ); ?></td>
				    <td><?= $this->clean ( $user ['email'] ); ?></td>
				    <td><?= $this->clean ( $user ['tel'] ); ?></td>
				    <td><?= $this->clean ( $user ['unit'] ); ?></td>
				    <td><?= $this->clean ( $user ['fullname'] ); ?></td>
				    <td><?= $this->clean ( $user ['status'] ); ?></td>
				    <td><?php if($this->clean ( $user ['is_responsible'] )){echo "true";}else{echo "false";} ?></td>
				    <td> 
				    	<?php 
				    	$convno = $this->clean ( $user ['convention'] );
				    	if ($convno == 0){
				    		$convTxt = "no convention";	
				    	}
				    	else{
				    		$convTxt = "<p> No:" . $convno . "</p>"
				    				   ."<p>" . $this->clean ( $user ['date_convention'] ) . "</p>";
				    	}
				    	?>
				    
				      <?= $convTxt ?>
				    </td>
				    <td><?= $this->clean ( $user ['date_created'] ); ?></td>
				    <td><?= $this->clean ( $user ['date_last_login'] ); ?></td>
				    <td><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
