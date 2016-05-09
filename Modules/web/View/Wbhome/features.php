   
    
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