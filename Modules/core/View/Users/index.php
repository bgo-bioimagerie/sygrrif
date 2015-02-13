<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
            /*width: 7.12%;*/
            float: left;
        }   
</style>

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
	
		<table id="dataTable" class="table table-striped" >
			<thead>
				<tr>
					<th class="text-center" style="width:2%"><a href="users/index/id">ID</a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/name"><?= CoreTranslator::Name($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/firstname"><?= CoreTranslator::Firstname($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/login"><?= CoreTranslator::Login($lang) ?></a></tH>
					<th class="text-center" style="width:12.12%"><a href="users/index/email"><?= CoreTranslator::Email($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/tel"><?= CoreTranslator::Phone($lang) ?></a></tH>
					<th class="text-center" style="width:7.12%"><a href="users/index/unit"><?= CoreTranslator::Unit($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/responsible"><?= CoreTranslator::Responsible($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/id_status"><?= CoreTranslator::Status($lang) ?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/is_responsible"><?= CoreTranslator::is_responsible($lang)?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/convention"><?= CoreTranslator::Convention($lang)?></a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/date_created"><?= CoreTranslator::User_from($lang) ?> </a></th>
					<th class="text-center" style="width:7.12%"><a href="users/index/date_last_login"><?= CoreTranslator::Last_connection($lang) ?></a></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $usersArray as $user ) : ?> 
				<?php if ($user ['id'] > 1){ ?>
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td style="width:2%"><?= $userId ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['name'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['firstname'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['login'] ); ?></td>
				    <td style="width:13.12%"><?= $this->clean ( $user ['email'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['tel'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['unit'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['resp_name'] . " " . $user ['resp_firstname'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['status'] ); ?></td>
				    <td style="width:7.12%"><?php if($this->clean ( $user ['is_responsible'] )){echo "true";}else{echo "false";} ?></td>
				    <td style="width:7.12%"> 
				    	<?php 
				    	$convno = $this->clean ( $user ['convention'] );
				    	if ($convno == 0){
				    		$convTxt = "no convention";	
				    	}
				    	else{
				    		$convTxt = "<p> No:" . $convno . "</p>"
				    				   ."<p>" . CoreTranslator::dateFromEn($this->clean ( $user ['date_convention']), $lang) . "</p>";
				    	}
				    	?>
				    
				      <?= $convTxt ?>
				    </td>
				    <td style="width:7.12%"><?= CoreTranslator::dateFromEn( $this->clean ( $user ['date_created']) , $lang) ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['date_last_login'] ); ?></td>
				    <td style="width:2.12%"><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
