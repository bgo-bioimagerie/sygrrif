<?php $this->title = "SyGRRiF Authorizations"?>

<?php echo $navBar?>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

if ($authorisations_location == 2){
	include "Modules/core/View/usersnavbar.php";
}
else{
	include "Modules/sygrrif/View/navbar.php"; 
}
?>

<br>
<div class="contatiner">
	<div class="col-md-8 col-md-offset-2">
	
		<div class="page-header">
			<h1> 
			<?php
			$linkcontroller = "authorizations";
			if (isset($isInactive)){
				$linkcontroller = "uauthorizations";
				echo SyTranslator::Unactive_Authorizations($lang);
			}
			else{
				echo SyTranslator::Active_Authorizations($lang);
			}
			
			?>
			<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/id">ID</a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/date"><?php echo  SyTranslator::Date($lang) ?></a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/userName"><?php echo  SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/userFirstname"><?php echo  SyTranslator::Firstname($lang) ?></a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/unit"><?php echo  SyTranslator::Unit($lang) ?></a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/visa"><?php echo  SyTranslator::Visa($lang) ?></a></th>
					<th><a href="sygrrif/<?php echo  $linkcontroller ?>/ressource"><?php echo  SyTranslator::Resource($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $authorizationTable as $auth ) : ?>
				<?php $authId = $this->clean ( $auth ['id'] ); ?> 
				<tr>
					<td><?php echo  $authId ?></td>
				    <td><?php echo  CoreTranslator::dateFromEn($this->clean ( $auth ['date'] ), $lang) ?></td>
				    <td><?php echo  $this->clean ( $auth ['userName'] ); ?></td>
				    <td><?php echo  $this->clean ( $auth ['userFirstname'] ); ?></td>
				    <td><?php echo  $this->clean ( $auth ['unitName'] ); ?></td>
				    <td><?php echo  $this->clean ( $auth ['visa'] ); ?></td>
				    <td><?php echo  $this->clean ( $auth ['resource'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='sygrrif/editauthorization/<?php echo  $authId ?>'" class="btn btn-xs btn-primary" id="navlink"><?php echo  SyTranslator::Edit($lang) ?></button>
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
