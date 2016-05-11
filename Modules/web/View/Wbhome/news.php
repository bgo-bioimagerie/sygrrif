<?php 

?>
<div class="col-xs-12" >

    <div class="col-xs-12">
    <div class="col-xs-6">
            <h2 ><?php echo WbTranslator::News($lang) ?></h2>
    </div>
    <div class="col-xs-6" style="text-align: right">
        <h2 > </h2>
        <a href="wbarticles/newsarticles/" ><?php echo WbTranslator::All_News($lang) ?> > </a>
    </div>
</div>
    
    <div class="col-xs-12">
    <!-- ADD TUTO LIST -->
    <?php $count = 0;
    $firstLine = true;
    ?>
    <?php foreach ($news as $new) {
        ?>

        <?php
        if (isset($new["id"])) {
            if ($count == 0) {
                $margin = "style=\"margin-top: 25px;\"";
                if ($firstLine) {
                    $margin = "style=\"margin-top: 0px;\"";
                }
                ?>

                <div class="row" <?= $margin ?> >
                    <?php
                }
                ?>

                <div class="col-xs-4" style="border: solid 1px #e1e1e1; border-bottom: solid 3px #e1e1e1; height:325px; width:220px; margin-left: 25px;">
	
                    <div style="margin-left: -15px;">
                        <!-- IMAGE -->
                        <a href="wbarticles/article/<?php echo $new["id"] ?>">
                            <img src="<?php echo $new["image_url"] ?>" alt="image" style="width:218px;height:150px">
                        </a>
                        <p>
                        </p>
                        <!-- TITLE -->
                        <p style="color:#018181; text-transform:uppercase;">
                            <a href="wbarticles/article/<?php echo $new["id"] ?>"><?php echo $new["title"] ?></a>
                        </p>


                        <?php
                        // "c=" . strlen($tutorial["title"])."<br/>";
                        if (strlen($new["title"]) < 20) {
                            echo "<br/>";
                        }
                        ?>

                        <!-- DESC -->
                        <p style="color:#a1a1a1; font-size:12px;">
                            <?php echo $new["short_desc"] ?>
                        </p>

                    </div>
                </div>
                

                <?php
                $count++;
                if ($count == 3) {
                    $count = 0;
                    $firstLine = false;
                    echo "</div>";
                }
                ?>	

    <?php } }?>
    </div>
</div>
