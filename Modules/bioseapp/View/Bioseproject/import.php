<?php $this->title = "sprojects" ?>

<?php echo $navBar ?>
<?php include "Modules/bioseapp/View/Bioseproject/tabs.php"; ?>

<head>
    <style type="text/css">
	
			.example {
				float: left;
				margin: 15px;
			}
			
			.demo {
                               /*
				width: 200px;
                                */
				height: 400px;
			
                                border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				/*padding: 5px;*/
			}
			
		</style>
		<script src="externals/jqueryfileTree/jquery.js" type="text/javascript"></script>
		<script src="externals/jqueryfileTree/jquery.easing.js" type="text/javascript"></script>
		<script src="externals/jqueryfileTree/jqueryFileTree.js" type="text/javascript"></script>
		<link href="externals/jqueryfileTree/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
		
		<script type="text/javascript">
			
			$(document).ready( function() {
				
				$('#fileTreeDemo_1').fileTree({ root: '', script: 'Modules/bioseapp/View/Bioseproject/treeView.php' }, function(file) { 
					//alert(file);
                                        var x = document.getElementById("mySelect");
                                        var option = document.createElement("option");
                                        option.text = file;
                                        x.add(option);
				});
                                });
                </script>
                
                <script type="text/javascript">
                function DeleteProbs() {
                    var x = document.getElementById("mySelect");
                    for (var i = 0; i < x.options.length; i++) {
                        if (x.options[i].selected) {
                            x.options[i].remove();
                        }
                    }
}
                </script>

</head>
<div class="col-md-12">
    <form role="form" class="form-horizontal" action="bioseproject/importquery"
          method="post">

        <div class="page-header col-md-12">
            <div class="col-xs-10">
                <h1>
                    <?php
                    echo BiTranslator::Import($lang);
                    $buttonName = BiTranslator::Import($lang);
                    //$projectID = $this->clean($project["id"]);
                    ?>	
                </h1>
            </div>
        </div>

        <div class="col-xs-8 col-xs-offset-2">
            <div class="page-header">
                <h3>
                    <?php echo BiTranslator::Indexation($lang) ?>
                    <br> <small></small>
                </h3>
            </div>
        </div>

        <?php foreach($tags as $tag){
            ?>
            <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4"><?php echo $tag["key"]?></label>
                <div class="col-xs-6">
                    <select class="form-control" name="<?php echo $tag["key"]?>">
                            <?php
                            $tagVals = explode(";", $tag["content"]);
                            foreach ($tagVals as $tagVal) {
                                ?>
                                <option value="<?php echo $tagVal ?>" > <?php echo $tagVal ?> </option>
                          <?php } ?>
                        </select>
                    </div>
                </div>
        <?php
        }
        ?>
        
         <div class="col-xs-10 col-xs-offset-2">
        <div class="page-header">
            <h3>
                    <?php echo BiTranslator::Data($lang) ?>
                <br> <small></small>
            </h3>
        </div>
        </div>
        
        <div class="col-xs-4 col-xs-offset-2">
            <p style="text-align: center;"><?php echo BiTranslator::DataOnServer($lang) ?></p>
            <div class="col-xs-12">
			<div id="fileTreeDemo_1" class="demo"></div>
            </div>
        </div>
        <div class="col-xs-2">
            <p style="height: 200px;"></p>
            <p style="text-align:center;"><span class="glyphicon glyphicon-arrow-right"></span></p>
            </div>
        <div class="col-xs-4">
            <p style="text-align: center;"><?php echo BiTranslator::SelectedData($lang) ?></p>
                    <select id="mySelect" class="form-control" name="selected_data[]" style="height: 400px;" size="10" multiple="multiple">
                                            
                    </select>
            <button type="button" class="btn btn-default" onclick="DeleteProbs();">Delete selected data</button>
		</div>
        
        <div class="col-xs-1 col-xs-offset-11" id="button-div">
            <input type="submit" class="btn btn-primary" value="<?php echo $buttonName ?>" />
        </div>
    </form>
</div>


<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
<?php endif;
