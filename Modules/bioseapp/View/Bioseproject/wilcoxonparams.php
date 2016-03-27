<div class="col-xs-12" style="background-color: #dddddd; height:30px; align-items: center;">
            <h4>Inputs</h4>  
        </div>
        <div class="col-xs-12" style="margin-top: 12px;">
            <div class="form-group">
			<label class="control-label col-xs-4">Distribution 1</label>
			<div class="col-xs-8">
				<select class="form-control" name="input_image">
					<?php foreach($projColumns as $projCol){
						$id = $this->clean($projCol["id"]);
						$name = $this->clean($projCol["fullname"]);
						?>
						<OPTION value="<?php echo  $id ?>" > <?php echo  $name ?> </OPTION>
						<?php 
					}?>
  				</select>
			</div>
		</div>
            
            <div class="form-group">
			<label class="control-label col-xs-4">Conditions</label>
                        <div class="col-xs-8">
                             <div class="form-inline">
                                 <div class="col-xs-1">
                                    <input class="form-control" style="margin-top: 0px;" type="radio" name="condition" value="all" checked>
                                </div>
                                <div class="col-xs-11 form-control" style="border:none;">
                                    Process all lines
                                </div>
                             </div>
                        </div>
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-8">
                            
                            <?php foreach($projTagsColumns as $tagCol){
                                
                                ?>
                                <div class="form-inline">
                                    <div class="col-xs-1">
                                        <input class="form-control" style="margin-top: 0px;" type="radio" name="condition" value="<?php echo $tagCol["id"] ?>"> 
                                    </div>
                                    <div class="col-xs-3 form-control" style="border:none;">
                                        <?php echo $tagCol["name"] ?>:
                                    </div>
                                    <div class="col-xs-8"> 
                                    <select class="form-control" name="input_condition">
					<?php 
                                        $contents = explode(";", $tagCol["content"]);
                                        foreach($contents as $content){
						?>
						<OPTION value="<?php echo  $content ?>" > <?php echo  $content ?> </OPTION>
						<?php 
					}?>
                                    </select>
                                    </div>
                              </div>
                                <?php
                                }
                                ?>
                              
                        </div>
                        
            </div>
        </div>

<div class="col-xs-12" style="border-top: 1px solid #dddddd; margin-top: 15px;">
    
</div>

        <div class="col-xs-12" style="margin-top: 12px;">
            <div class="form-group">
			<label class="control-label col-xs-4">Distribution 2</label>
			<div class="col-xs-8">
				<select class="form-control" name="input_image">
					<?php foreach($projColumns as $projCol){
						$id = $this->clean($projCol["id"]);
						$name = $this->clean($projCol["fullname"]);
						?>
						<OPTION value="<?php echo  $id ?>" > <?php echo  $name ?> </OPTION>
						<?php 
					}?>
  				</select>
			</div>
		</div>
            
            <div class="form-group">
			<label class="control-label col-xs-4">Conditions</label>
                        <div class="col-xs-8">
                             <div class="form-inline">
                                 <div class="col-xs-1">
                                    <input class="form-control" style="margin-top: 0px;" type="radio" name="condition" value="all" checked>
                                </div>
                                <div class="col-xs-11 form-control" style="border:none;">
                                    Process all lines
                                </div>
                             </div>
                        </div>
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-8">
                            
                            <?php foreach($projTagsColumns as $tagCol){
                                
                                ?>
                                <div class="form-inline">
                                    <div class="col-xs-1">
                                        <input class="form-control" style="margin-top: 0px;" type="radio" name="condition" value="<?php echo $tagCol["id"] ?>"> 
                                    </div>
                                    <div class="col-xs-3 form-control" style="border:none;">
                                        <?php echo $tagCol["name"] ?>:
                                    </div>
                                    <div class="col-xs-8"> 
                                    <select class="form-control" name="input_condition">
					<?php 
                                        $contents = explode(";", $tagCol["content"]);
                                        foreach($contents as $content){
						?>
						<OPTION value="<?php echo  $content ?>" > <?php echo  $content ?> </OPTION>
						<?php 
					}?>
                                    </select>
                                    </div>
                              </div>
                                <?php
                                }
                                ?>
                              
                        </div>
                        
            </div>
        </div>
        
        <!-- PARAMETERS -->