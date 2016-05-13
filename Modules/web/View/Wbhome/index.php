<?php $this->title = "Platform Manager" ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="./Themes/caroussel/ie-emulation-modes-warning.js"></script>
    
    <?php if ($carouselFullWidth == true){ ?>
        <link href="./Themes/caroussel/carouselfullwidth.css" rel="stylesheet">
    <?php }
    else{ ?>
        <link href="./Themes/caroussel/carousel.css" rel="stylesheet">    
    <?php } ?>
</head>

    <?php include("Modules/web/View/Wbhome/carousel.php") ?> 

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <?php if ($viewFeatures){ ?>
        <?php include("Modules/web/View/Wbhome/features.php") ?>
    <?php } ?>
    
    <div class="row" >
        <?php if ($viewEvents) { ?>
        <div class="col-md-4" >
            <?php include("Modules/web/View/Wbhome/events.php") ?>
        </div>
        <?php } ?>
        <?php if ($viewNews) { ?>
            <div class="col-md-8" >
                <?php include("Modules/web/View/Wbhome/news.php") ?>
            </div>
        <?php } ?>
    </div>
    
    <div class="col-md-12">
    <div style="width: 100%; padding-top:25px;">
      <!-- FOOTER -->
      <footer style="background-color: #fff; width:100%; min-height:250px; border-top: 1px double #E1E1E1">
        <p class="pull-right"><a href="#"><?php echo WbTranslator::TopPage($lang) ?></a></p>
        <p><?php echo $copyright ?></a>.</p>
      </footer>
    </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./Themes/caroussel/jquery.min.js"></script>
    <script src="./Themes/caroussel/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="./Themes/caroussel/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Themes/caroussel/ie10-viewport-bug-workaround.js"></script>


<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>

