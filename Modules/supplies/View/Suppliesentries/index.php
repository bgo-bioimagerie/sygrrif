<?php $this->title = "Supplies Orders"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
	rel="stylesheet">
</head>

<?php include "Modules/supplies/View/navbar.php"; ?>

<br>
<div class="contatiner">
	<div class="col-md-6 col-md-offset-3">
	
		<div class="page-header">
			<h1>
			<?php echo  SuTranslator::Supplies_Orders($lang) ?>
			<br> <small></small>
			</h1>
		</div>

		<table id="dataTable" class="table table-striped">
			<thead>
				<tr>
					<td><a href="suppliesentries/index/id">ID</a></td>
					<td><a href="suppliesentries/index/id"><?php echo  CoreTranslator::User($lang) ?> </a></td>
					<td><a href="suppliesentries/index/id_status"><?php echo  CoreTranslator::Status($lang)?></a></td>
					<td><a href="suppliesentries/index/date_open"><?php echo  SuTranslator::Opened_date($lang)?></a></td>
					<td><a href="suppliesentries/index/date_close"><?php echo  SuTranslator::Closed_date($lang)?></a></td>
					<td><a href="suppliesentries/index/date_last_modified"><?php echo  SuTranslator::Last_modified_date($lang)?></a></td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $entriesArray as $item ) : 
				
				?> 
				<tr>
					<?php $itemId = $this->clean ( $item ['id'] ); ?>
					<td><?php echo  $itemId ?></td>
				    <td><?php echo  $this->clean ( $item ['user_name'] ); ?></td>
				    <?php 
				    $is_active = $this->clean ( $item ['id_status'] );
				    if ($is_active){$is_active = "Open";}
				    else{$is_active = "Close";}
				    ?>
				    <td><?php echo  $is_active; ?></td>
				    <td><?php echo  CoreTranslator::dateFromEn($this->clean ( $item ['date_open'] ), $lang) ?></td>
				    <td><?php echo  CoreTranslator::dateFromEn($this->clean ( $item ['date_close'] ), $lang); ?></td>
				    <td><?php echo  CoreTranslator::dateFromEn($this->clean ( $item ['date_last_modified'] ), $lang); ?></td>
				    <td>
				      <button type='button' onclick="location.href='suppliesentries/editentries/<?php echo  $itemId ?>'" class="btn btn-xs btn-primary"><?php echo  CoreTranslator::Edit($lang) ?> </button>
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
