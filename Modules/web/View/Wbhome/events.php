<?php 
$events = array();
$events[] = array("id" => 1, "date" => time(), "title" => "article test", "short_desc" => "duliuh fhruij hdeu dhuh", "image_url" => "data/core/carousel1.png" );
$events[] = array("id" => 2, "date" => time(), "title" => "article test", "short_desc" => "duliuh fhruij hdeu dhuh", "image_url" => "data/core/carousel1.png" );
$events[] = array("id" => 3, "date" => time(), "title" => "article test", "short_desc" => "duliuh fhruij hdeu dhuh", "image_url" => "data/core/carousel1.png" );
$events[] = array("id" => 4, "date" => time(), "title" => "article test", "short_desc" => "duliuh fhruij hdeu dhuh", "image_url" => "data/core/carousel1.png" );


?>
<div class="col-xs-12">
    <div class="col-xs-6">
            <h2 ><?php echo WbTranslator::Events($lang) ?></h2>
    </div>
    <div class="col-xs-6" style="text-align: right">
        <h2 > </h2>
        <a href="wbarticles/newsarticles/" ><?php echo WbTranslator::All_Events($lang) ?> > </a>
    </div>
</div>
<div class="col-xs-12" >

    <?php 
    foreach($events as $event){
        ?>
        <div class="col-xs-12">
            <!-- date -->
            <div class="col-xs-1 text-center" style="padding-top: 12px; border: 3px solid #337ab7; border-radius: 50%; width: 70px; height:70px; margin-right: 10px; color:#337ab7; text-transform: uppercase; font-weight: bold;">
                <?php echo date("d M", $event["date"]) ?>
            </div>
                SEMINAIRE
                <p><a>Ceci est le titre du séminaire</a></p>
            
        </div>    
            
    <?php
    }
    ?>
    
</div>
