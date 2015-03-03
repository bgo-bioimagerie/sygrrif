<?php $this->title = "SyGRRiF Authorizations"?>

<?php echo $navBar?>
<?php include "Modules/sygrrif/View/navbar.php"; ?>

<head>

<style>
        table {
            width: 100%;
        }

        thead, tbody, tr, td, th { display: block; }

        tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        thead th {
            height: 30px;

            /*text-align: left;*/
        }

        tbody {
            height: 1000px;
            overflow-y: auto;
        }

        thead {
            /* fallback */
        }

        tbody td, thead th {
            width: 12.5%;
            float: left;
        }   
</style>

</head>

<br>
<div class="contatiner">
	<div class="col-md-8 col-md-offset-2">
	
		<div class="page-header">
			<h1> <?= SyTranslator::Active_Authorizations($lang) ?>
			<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<th><a href="sygrrif/authorizations/id">ID</a></th>
					<th><a href="sygrrif/authorizations/date"><?= SyTranslator::Date($lang) ?></a></th>
					<th><a href="sygrrif/authorizations/userName"><?= SyTranslator::Name($lang) ?></a></th>
					<th><a href="sygrrif/authorizations/userFirstname"><?= SyTranslator::Firstname($lang) ?></a></th>
					<th><a href="sygrrif/authorizations/unit"><?= SyTranslator::Unit($lang) ?></a></th>
					<th><a href="sygrrif/authorizations/visa"><?= SyTranslator::Visa($lang) ?></a></th>
					<th><a href="sygrrif/authorizations/ressource"><?= SyTranslator::Resource($lang) ?></a></th>
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
				    <td>
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
