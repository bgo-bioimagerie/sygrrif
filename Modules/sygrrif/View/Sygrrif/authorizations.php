<?php $this->title = "SyGRRiF Authorizations"?>

<?php echo $navBar?>

<?php
$modelCoreConfig = new CoreConfig();
$authorisations_location = $modelCoreConfig->getParam("sy_authorisations_location");

if ($authorisations_location == 2){
	include "Modules/core/View/Users/usersnavbar.php";
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
					<th><a href="sygrrif/<?= $linkcontroller ?>/id">ID</a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/date"><?= SyTranslator::Date($lang) ?></a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/userName"><?= SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/userFirstname"><?= SyTranslator::Firstname($lang) ?></a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/unit"><?= SyTranslator::Unit($lang) ?></a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/visa"><?= SyTranslator::Visa($lang) ?></a></th>
					<th><a href="sygrrif/<?= $linkcontroller ?>/ressource"><?= SyTranslator::Resource($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $authorizationTable as $auth ) : ?>
				<?php $authId = $this->clean ( $auth ['id'] ); ?> 
				<tr>
					<td><?= $authId ?></td>
				    <td><?= CoreTranslator::dateFromEn($this->clean ( $auth ['date'] ), $lang) ?></td>
				    <td><?= $this->clean ( $auth ['userName'] ); ?></td>
				    <td><?= $this->clean ( $auth ['userFirstname'] ); ?></td>
				    <td><?= $this->clean ( $auth ['unitName'] ); ?></td>
				    <td><?= $this->clean ( $auth ['visa'] ); ?></td>
				    <td><?= $this->clean ( $auth ['resource'] ); ?></td>
				    <td class="text-center">
				      <button type='button' onclick="location.href='sygrrif/editauthorization/<?= $authId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= SyTranslator::Edit($lang) ?></button>
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
