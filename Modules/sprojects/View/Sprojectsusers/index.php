<?php $this->title = "SyGRRiF Add Area"?>

<?php echo $navBar?>

<head>
</head>


<?php include "Modules/sprojects/View/navbar.php"; ?>



<br>
<div class="contatiner">

	<div class="col-md-10 col-md-offset-1">

		<div class="page-header">
			<h1>
			<?php echo  CoreTranslator::Users($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="comsomusers/index/id">ID</a></td>
					<td><a href="comsomusers/index/name"><?php echo  CoreTranslator::Name($lang) ?></a></td>
					<td><a href="comsomusers/index/firstname"><?php echo  CoreTranslator::Firstname($lang) ?></a></td>
					<td><a href="comsomusers/index/email"><?php echo  CoreTranslator::Email($lang) ?></a></td>
					<td><a href="comsomusers/index/tel"><?php echo  CoreTranslator::Phone($lang) ?></a></td>
					<td><a href="comsomusers/index/id_unit"><?php echo  CoreTranslator::Unit($lang) ?></a></td>
					<td><a href="comsomusers/index/id_responsible"><?php echo  CoreTranslator::Responsible($lang) ?></a></td>
					<td><a href="comsomusers/index/id"><?php echo  CoreTranslator::Is_responsible($lang) ?></a></td>
					<td><a href="comsomusers/index/date_created"><?php echo  CoreTranslator::User_from($lang) ?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $usersArray as $user ) : ?> 
				<?php if ($user ['id'] > 1){ ?>
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td><?php echo  $userId ?></td>
				    <td><?php echo  $this->clean ( $user ['name'] ); ?></td>
				    <td><?php echo  $this->clean ( $user ['firstname'] ); ?></td>
				    <td><?php echo  $this->clean ( $user ['email'] ); ?></td>
				    <td><?php echo  $this->clean ( $user ['tel'] ); ?></td>
				    <td><?php echo  $this->clean ( $user ['unit'] ); ?></td>
				    <td><?php echo  $this->clean ( $user ['fullname'] ); ?></td>
				    <td><?php if($this->clean ( $user ['is_responsible'] )){echo "true";}else{echo "false";} ?></td>
				    <td><?php echo  $this->clean ( $user ['date_created'] ); ?></td>
				    <td><button onclick="location.href='sprojectsusers/edit/<?php echo  $userId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  CoreTranslator::Edit($lang) ?></button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

