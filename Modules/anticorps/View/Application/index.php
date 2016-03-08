<?php $this->title = "Platform-Manager" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<?php include "Modules/anticorps/View/navbar.php"; ?>

<br>
<div class="contatiner">
    <div class="col-md-6 col-md-offset-3">

        <div class="page-header">
            <h1>
                Applications<br> <small></small>
            </h1>
        </div>

        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><a href="application/index/id">Id</a></th>
                    <th><a href="application/index/nom">Nom</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application) : ?> 
                    <tr>
                        <?php $applicationId = $this->clean($application ['id']); ?>
                        <td><?php echo $applicationId ?></td>
                        <td><?php echo $this->clean($application ['name']); ?></td>
                        <td>
                            <button type='button' onclick="location.href = 'application/edit/<?php echo $applicationId ?>'" class="btn btn-xs btn-primary">Edit</button>
                        </td>  
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
    <?php
 endif;
