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
            <img class="first-slide" src="<?php echo $carousel[0]["image_url"] ?>" alt="First slide">
            <div class="container">
                <div class="carousel-caption col-xs-4 col-xs-offset-4">
                    <h1><?php echo $carousel[0]["title"] ?></h1>
                    <p><?php echo $carousel[0]["description"] ?></p>
                    <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[0]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="second-slide" src="<?php echo $carousel[1]["image_url"] ?>" alt="Second slide">
            <div class="container">
                <div class="carousel-caption col-xs-4 col-xs-offset-4">
                    <h1><?php echo $carousel[1]["title"] ?></h1>
                    <p><?php echo $carousel[1]["description"] ?></p>
                    <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[1]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img class="third-slide" src="<?php echo $carousel[2]["image_url"] ?>" alt="Third slide">
            <div class="container">
                <div class="carousel-caption col-xs-4 col-xs-offset-4">
                    <h1><?php echo $carousel[2]["title"] ?></h1>
                    <p><?php echo $carousel[2]["description"] ?></p>
                    <p><a class="btn btn-lg btn-primary" href="<?php echo $carousel[2]["link_url"] ?>" role="button"><?php echo WbTranslator::Go($lang) ?></a></p>
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
