<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   
</head>



<?php include "Modules/sygrrif/View/navbar.php"; ?>

<div class="container">
	<div class="row">
		<div class='col-sm-6'>
			<div class="form-group">
				<div class='input-group date' id='datetimepicker5'>
					<input type='text' class="form-control" data-date-format="YYYY/MM/DD"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<script src="bootstrap/datepicker/js/moments.js"></script>
		<script src="bootstrap/datepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$('#datetimepicker5').datetimepicker({
					pickTime: false
				});
			});
		</script>
	</div>
</div>
       

<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>