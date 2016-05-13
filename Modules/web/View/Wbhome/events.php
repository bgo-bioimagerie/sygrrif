<div class="col-xs-12">
    <div class="col-xs-6">
            <h2 ><?php echo WbTranslator::Events($lang) ?></h2>
    </div>
    <div class="col-xs-6" style="text-align: right">
        <h2 > </h2>
        <a href="agenda" ><?php echo WbTranslator::All_Events($lang) ?> > </a>
    </div>
</div>
<div class="col-xs-12" >

    <?php 
    foreach($events as $event){
        ?>
        <div class="col-xs-12">
            <!-- date -->
            <div class="col-xs-1 text-center" style="padding-top: 12px; border: 3px solid #337ab7; border-radius: 50%; width: 70px; height:70px; margin-right: 10px; color:#337ab7; text-transform: uppercase; font-weight: bold;">
                <?php echo date("d M", strtotime($event["date_begin"])) ?>
            </div>
            <span style="text-transform: uppercase;"><?php echo $event["type_name"] ?> </span>
                <p><a href="agenda/events/<?php echo $event["id"] ?>"><?php echo $event["title"] ?></a></p>
        </div>    
            
    <?php
    }
    ?>
    
</div>
