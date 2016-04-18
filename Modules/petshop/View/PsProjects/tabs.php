<div class="col-xs-12">
<p></p>
</div>
<div class="col-xs-12" style="height: 20px;">
    <?php if (isset($headerInfo["projectName"])){ ?>
<p class="text-center"><?php echo $headerInfo["projectName"] ?> </p>
    <?php } ?>
</div>
<div class="col-xs-12">
    <form name="projectTab" method="get" action="anprojects/tab/"><br>
    <div class="col-sm-offset-3 col-sm-6 text-center">
        <div class="btn-group" data-toggle="buttons">
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "info"){echo "active";} ?>" type="button" onclick="location.href = 'psprojects/info/<?php echo $headerInfo["projectId"] ?>'"><?php echo PsTranslator::Infos($lang) ?></button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "animaladd"){echo "active";} ?>" type="button" onclick="location.href = 'psprojects/animalsadd/<?php echo $headerInfo["projectId"] ?>'"><?php echo PsTranslator::AddAnimals($lang) ?></button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "animalsin"){echo "active";} ?>" type="button" onclick="location.href = 'psprojects/animalsin/<?php echo $headerInfo["projectId"] ?>'"><?php echo PsTranslator::AnimalsIn($lang) ?></button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "animalsout"){echo "active";} ?>" type="button" onclick="location.href = 'psprojects/animalsout/<?php echo $headerInfo["projectId"] ?>'"><?php echo PsTranslator::AnimalsOut($lang) ?></button> 
            <?php $_SESSION["id_anproj"] = $headerInfo["projectId"]; ?>
        </div>
    </div>
    </form>

</div>
    
