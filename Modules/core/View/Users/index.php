<?php $this->title = "SyGRRiF Database users"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
/*
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
        }

        tbody {
            height: 1000px;
            overflow-y: auto;
        }

        thead {
            /* fallback 
        }

        tbody td, thead th {
            /*width: 7.12%;
            float: left;
        }   
        */
</style>

</head>

<?php if($isneurinfo){
include "Modules/projet/View/projetnavbar.php";
}else{
	include "Modules/core/View/Users/usersnavbar.php";
}
?>

<br>
<div class="contatiner">
<?php if($isneurinfo){?>	
	<div class="col-lg-12">
		<div class="page-header">
			<h1>
			<?= CoreTranslator::Users($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
			<div class="col-md-12">
			<form role="form" class="form-horizontal" action="users/searchquery"
				  method="post">
		
			<?php
			if(!isset($searchColumn)){
				$searchColumn = "0";
			}
			if(!isset($searchTxt)){
				$searchTxt = "";
			}
			?>
			<label for="inputEmail" class="control-label col-md-2"><?= CoreTranslator::Search($lang)?></label>
			<div class="col-md-3">
				<select class="form-control" name="searchColumn">
					<?php $selected = "selected=\"selected\""; ?>
					<OPTION value="0" <?php if($searchColumn=="0"){echo $selected;} ?> > Select </OPTION>
					<OPTION value="name" <?php if($searchColumn=="name"){echo $selected;} ?> > <?= CoreTranslator::Name($lang) ?> </OPTION>
					<OPTION value="firstname" <?php if($searchColumn=="firstname"){echo $selected;} ?> > <?= CoreTranslator::Firstname($lang) ?> </OPTION>
					<OPTION value="id_status" <?php if($searchColumn=="id_status"){echo $selected;} ?> > <?= CoreTranslator::Status($lang) ?></OPTION>
			</select>
			</div>
			<div class="col-md-3">
				<input class="form-control" id="searchTxt" type="text" name="searchTxt" value="<?= $searchTxt ?>"
				/>
			</div>
			<div class="col-md-2" id="button-div">
		       	<input type="submit" class="btn btn-primary" value="Rechercher" />
			</div>
      	</form>
		</div>
		
		<div class="col-md-12" style="margin-top: 25px;">
			<br/>
		</div>
	
		<table id="dataTable" class="table table-striped table-bordered" >
			<thead>
				<tr>
					<th class="text-center" style="width:2%">ID</th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Name($lang) ?></th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Firstname($lang) ?></th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Login($lang) ?></tH>
					<th class="text-center" style="width:12.12%"><?= CoreTranslator::Email($lang) ?></th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Phone($lang) ?></tH>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Status($lang) ?></th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Convention($lang)?></th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::User_from($lang) ?> </th>
					<th class="text-center" style="width:7.12%"><?= CoreTranslator::Last_connection($lang) ?></th>
					<th class="text-center" style="width:7.12%"><?=CoreTranslator::typeorganne($lang)?></th>
					<th> Modifier</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ( $usersArray as $user ) : ?> 
				<?php if ($user ['id'] > 1){ ?>
				<tr>
					<?php $userId = $this->clean ( $user ['id'] ); ?>
					<td style="width:2%"><?= $userId ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['name'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['firstname'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['login'] ); ?></td>
				    <td style="width:13.12%"><?= $this->clean ( $user ['email'] ); ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['tel'] ); ?></td>
				    
				    <td style="width:7.12%"><?= $this->clean ( $user ['status'] ); ?></td>
				    <td style="width:7.12%"> 
				    <?php 
				    	$convno = $this->clean ( $user ['convention'] );
				    	if ($convno == 0 || $convno == "non"){
				    		$convTxt = "Non";	
				    	}
				    	else{
				    		$convTxt = "Oui";
				    	}
				    	?>
				    
				      <?= $convTxt ?>
				    
				    </td>
				    <td style="width:7.12%"><?= CoreTranslator::dateFromEn( $this->clean ( $user ['date_created']) , $lang) ?></td>
				    <td style="width:7.12%"><?= CoreTranslator::dateFromEn( $this->clean ( $user ['date_last_login'] ), $lang) ?></td>
				    <td style="width:7.12%"><?= $this->clean ( $user ['typeorgane'] );?></td>
				    <td style="width:2.12%"><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
	
	<?php } else{?>
	<div class="col-lg-12">

		<div class="page-header">
			<h1>
			<?= CoreTranslator::Users($lang) ?>
			<br> <small></small>
			</h1>
		</div>
		
			<div class="col-md-12">
			<form role="form" class="form-horizontal" action="users/searchquery"
				  method="post">
		
			<?php
			if(!isset($searchColumn)){
				$searchColumn = "0";
			}
			if(!isset($searchTxt)){
				$searchTxt = "";
			}
			?>
			<label for="inputEmail" class="control-label col-md-2"><?= CoreTranslator::Search($lang)?></label>
			<div class="col-md-3">
				<select class="form-control" name="searchColumn">
					<?php $selected = "selected=\"selected\""; ?>
					<OPTION value="0" <?php if($searchColumn=="0"){echo $selected;} ?> > Select </OPTION>
					<OPTION value="name" <?php if($searchColumn=="name"){echo $selected;} ?> > <?= CoreTranslator::Name($lang) ?> </OPTION>
					<OPTION value="firstname" <?php if($searchColumn=="firstname"){echo $selected;} ?> > <?= CoreTranslator::Firstname($lang) ?> </OPTION>
					<OPTION value="unit" <?php if($searchColumn=="unit"){echo $selected;} ?> > <?= CoreTranslator::Unit($lang) ?></OPTION>
					<OPTION value="responsible" <?php if($searchColumn=="responsible"){echo $selected;} ?> > <?= CoreTranslator::Responsible($lang) ?></OPTION>
					<OPTION value="id_status" <?php if($searchColumn=="id_status"){echo $selected;} ?> > <?= CoreTranslator::Status($lang) ?></OPTION>
		
	  			</select>
			</div>
			<div class="col-md-3">
				<input class="form-control" id="searchTxt" type="text" name="searchTxt" value="<?= $searchTxt ?>"
				/>
			</div>
			<div class="col-md-2" id="button-div">
		       	<input type="submit" class="btn btn-primary" value="Rechercher" />
			</div>
      	</form>
		</div>
		
		<div class="col-md-12" style="margin-top: 25px;">
			<br/>
		</div>
	
		<table id="dataTable" class="table table-striped table-bordered" >
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
				    	if ($convno == 0 || $user ['date_convention']=="0000-00-00"){
				    		$convTxt = CoreTranslator::Not_signed($lang);	
				    	}
				    	else{
				    		$convTxt = "<p>" . CoreTranslator::Signed_the($lang) . "</p>"
				    				   ."<p>" . CoreTranslator::dateFromEn($this->clean ( $user ['date_convention']), $lang) . "</p>";
				    	}
				    	?>
				    
				      <?= $convTxt ?>
				    </td>
				    <td style="width:7.12%"><?= CoreTranslator::dateFromEn( $this->clean ( $user ['date_created']) , $lang) ?></td>
				    <td style="width:7.12%"><?= CoreTranslator::dateFromEn( $this->clean ( $user ['date_last_login'] ), $lang) ?></td>
				    <td style="width:2.12%"><button onclick="location.href='users/edit/<?= $userId ?>'" class="btn btn-xs btn-primary" id="navlink"><?= CoreTranslator::Edit($lang) ?></button></td>  
	    		</tr>
	    		<?php }endforeach; ?>
				
			</tbody>
		</table>

	</div>
	<?php }?>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
