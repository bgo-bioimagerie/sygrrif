<!--
$headerInfo = array("curentTab" => "info", "projectId" => $id);
-->
<div class="col-xs-12">
<p></p>
</div>
<div class="col-xs-12">
    <form name="projectTab" method="get" action="bioseproject/tab/"><br>
    <div class="col-sm-offset-4 col-sm-4 text-center">
        <div class="btn-group" data-toggle="buttons">
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "info"){echo "active";} ?>" type="button" onclick="location.href = 'bioseproject/info/<?php echo $headerInfo["projectId"] ?>'">Description</button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "import"){echo "active";} ?>" type="button" onclick="location.href = 'bioseproject/import/<?php echo $headerInfo["projectId"] ?>'">Import</button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "data"){echo "active";} ?>" type="button" onclick="location.href = 'bioseproject/data/<?php echo $headerInfo["projectId"] ?>'">Data</button> 
            <button class="btn btn-default <?php if($headerInfo["curentTab"] == "process"){echo "active";} ?>" type="button" onclick="location.href = 'bioseproject/process/<?php echo $headerInfo["projectId"] ?>'">Process</button> 
        </div>
    </div>
        </form>

</div>
    
