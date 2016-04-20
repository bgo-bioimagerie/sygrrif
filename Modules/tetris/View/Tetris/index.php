<?php $this->title = "SyGRRiF Add Area"?>

<?php echo $navBar?>

<div class="col-xs-12 text-center">

    <iframe style="border: none;" width="600" height="500" src="Modules/tetris/View/Tetris/frame.php"></iframe> 
    
</div>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif;
