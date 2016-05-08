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
    <link href="./Themes/caroussel/carousel.css" rel="stylesheet">
</head>

   <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="<?php echo $carousel[0]["image_url"]?>" alt="First slide">
          <div class="container">
            <div class="carousel-caption col-xs-4 col-xs-offset-4">
              <h1><?php echo $carousel[0]["title"]?></h1>
              <p><?php echo $carousel[0]["description"]?></p>
              <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[0]["link_url"]?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="<?php echo $carousel[1]["image_url"]?>" alt="Second slide">
          <div class="container">
            <div class="carousel-caption col-xs-4 col-xs-offset-4">
              <h1><?php echo $carousel[1]["title"]?></h1>
              <p><?php echo $carousel[1]["description"]?></p>
              <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[1]["link_url"]?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="<?php echo $carousel[2]["image_url"]?>" alt="Third slide">
          <div class="container">
            <div class="carousel-caption col-xs-4 col-xs-offset-4">
              <h1><?php echo $carousel[2]["title"]?></h1>
              <p><?php echo $carousel[2]["description"]?></p>
              <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[2]["link_url"]?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <?php 
    if ($viewFeatures){
        ?>
    
    
    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img src="<?php echo $features[0]["image_url"] ?>" alt="Generic placeholder image" width="100" height="100">
          <h2><?php echo $features[0]["title"] ?></h2>
          <p><?php echo $features[0]["description"] ?></p>
          <p><a class="btn btn-default" href="<?php echo $features[0]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="<?php echo $features[1]["image_url"] ?>" alt="Generic placeholder image" width="155" height="100">
          <h2><?php echo $features[1]["title"] ?></h2>
          <p><?php echo $features[1]["description"] ?></p>
          <br/>
          <p><a class="btn btn-default" href="<?php echo $features[1]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="<?php echo $features[2]["image_url"] ?>" alt="Generic placeholder image" width="100" height="100">
          <h2><?php echo $features[2]["title"] ?></h2>
          <p><?php echo $features[2]["description"] ?></p>
          <p><a class="btn btn-default" href="<?php echo $features[2]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

    </div>
    <?php } ?>

    


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Haut de page</a></p>
        <p>2015 Bio-Imagerie <a href="http://www.biogenouest.org">Biogenouest</a>.</p>
      </footer>

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
  

</body>


<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>

