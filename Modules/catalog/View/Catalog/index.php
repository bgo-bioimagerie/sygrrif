<?php include('Modules/catalog/View/Catalog/toolbar.php') ?>

<div class="col-md-12">
<br/>
</div>
<div class="col-md-12 my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
	<?php foreach ($entries as $entry){
	?>
		<div class="col-md-8 col-md-offset-2" style="margin-bottom:25px;">
			<div style="float:left; margin-right:12px; width: 150px; height:150px;">
			
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
    	<?php 
    	
    	$imageFile = "data/catalog/" . $entry["image_url"];
    	if (!file_exists($imageFile)){
    		$imageFile = "Modules/catalog/View/images_icon.png";
    	}
    	list($width, $height, $type, $attr) = getimagesize($imageFile);
    	 
    	?>
      <a href="<?php echo $imageFile?>" itemprop="contentUrl" data-size="<?php echo $width?>x<?php echo $height?>">
          <img src="<?php echo $imageFile?>" itemprop="thumbnail" alt="photo" />
      </a>
      <figcaption itemprop="caption description"><?php echo $entry["title"] ?></figcaption>
                                          
    </figure>

 			<!-- <img src="data/catalog/<?php echo $entry['id'] ?>.png" alt="photo" height="150" width="150"/>  -->
 			</div>
			<div >
 			<div style="font-weight: bold;"><?php echo $entry["title"] ?></div>
			<div> <?php echo $entry["short_desc"] ?></div>
			</div>	
		</div>
	<?php
	}?>
</div>

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

          </div>

        </div>

</div>


<script src='externals/photoswipe/js/photoswipe.js'></script>
<script src='externals/photoswipe/js/photoswipe-ui.js'></script>
<script src="externals/photoswipe/js/index.js"></script>

<?php if (isset($msgError)): ?>
<p><?php echo  $msgError ?></p>
<?php endif; ?>

