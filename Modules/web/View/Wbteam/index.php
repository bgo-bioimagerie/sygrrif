<?php $this->title = "Platform-Manager" ?>

<head>    
    <!-- Bootstrap core CSS -->
    <link href="externals/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="col-lg-12" style="background-color: #fff; border-bottom: 1px solid #e1e1e1;">
    <div class="col-lg-offset-1">
        <h4><?php echo WbTranslator::People($lang) ?></h4>
    </div>
</div>
<div class="col-lg-12" style="margin-top: 25px;">
</div> 
<div class="col-lg-10 col-lg-offset-1">

    <?php $count = 0 ?>
    <?php foreach ($people as $p) { ?>

        <?php if ($count == 0) {
            ?>
            <div class="row">
                <?php
            }
            $count++;
            //echo "count = " . $count . "<br/>";
            ?>

            <div class="col-md-4">
                <div class="col-md-4" style="width:100px;">
                    <img src="<?php echo $p["image_url"] ?>" width="100%">
                </div>
                <div class="col-md-8">
                    <b><?php echo $p["name"] ?></b><br/>
                    <?php if ($p["job"] != "") { ?>
                        <div style="text-transform: uppercase; font-size:11px;"><?php echo $p["job"] ?> </div>
                    <?php } ?>
                    <?php if ($p["tel"] != "") { ?>
                        <div style="text-transform: uppercase; font-size:11px;"><?php echo $p["tel"] ?> </div>
                    <?php } ?>
                    <?php if ($p["email"] != "") { ?>
                        <div style="text-transform: uppercase; font-size:11px;"><?php echo $p["email"] ?> </div>
                    <?php } ?>
                    <?php if ($p["misc"] != "") { ?>
                        <div style="text-transform: uppercase; font-size:11px;"><?php echo $p["misc"] ?> </div>
                    <?php } ?>
                </div>
            </div>

            <?php if ($count == 3) {
                ?>
            </div>
            <?php
            $count = 0;
            }
            ?>
    <?php } ?>
</div>

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
    <?php

 endif;
