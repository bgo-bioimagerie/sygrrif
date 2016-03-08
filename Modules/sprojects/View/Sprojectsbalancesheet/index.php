<?php $this->title = "Platform-Manager" ?>

<?php echo $navBar ?>
<?php include "Modules/sprojects/View/navbar.php"; ?>
<br>
<div class="contatiner">
    <div class="col-md-10 col-md-offset-1">
        <?php echo $formHtml ?>
    </div>
</div>

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
<?php endif;
