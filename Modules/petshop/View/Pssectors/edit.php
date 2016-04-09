<?php $this->title = "Pltaform-Manager"?>

<?php echo $navBar?>

<head>
<style>
#button-div{
	padding-top: 20px;
}
</style>
</head>

<?php include "Modules/petshop/View/petshopnavbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-8 col-md-offset-2">
	<form role="form" class="form-horizontal" action="pssectors/editquery"
		method="post">
	
	
		<div class="page-header">
			<h1>
			<?php echo PsTranslator::Edit_sector($lang);?>
			
				<br> <small></small>
			</h1>
		</div>
	
		<div>
		<h3><?php echo PsTranslator::Sector($lang);?><h3>
		</div>
		<input class="form-control" id="id" type="hidden"  name="id" value="<?= $secteur['id']?>" />
	
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-2"><?= CoreTranslator::Name($lang) ?></label>
			<div class="col-xs-10">
				<input class="form-control" id="name" type="text" name="name"
				       value="<?=$secteur['name'] ?>"
				/>
			</div>
		</div>	
		
		<div>
                    <h3><?php echo PsTranslator::Pricing($lang) ?><h3>
		</div>
		
                
                <!--   PRICING    -->
		<div class="form-group">
                    <div class="col-xs-12">
                        <table id="dataTable" class="table table-striped">
                        <thead>
                        <tr>
                            <!-- <td style="min-width:10em;">ID</td>  -->
                            <th><?php echo PsTranslator::AnimalsType($lang) ?></th>    		
                            <?php foreach ($belongings as $bel){ 
                                if($bel["name"] != "--"){
                            ?>
                                <th style="min-width:10em;"><?php echo  $bel["name"] ?></th>
                            <?php 
                                }
                            }
                            ?>		
			</tr>
			</thead>
			<tbody>
                            <?php 
                            foreach ($antypes as $type){
                                if ($type["name"] != "--"){
                            ?>
                                <tr>
                                    <td><?php echo $type["name"] ?></td>
                                    <?php foreach ($belongings as $belonging){ 
                                    if($belonging["name"] != "--"){
                                        
                                        $modelPrincing = new PsPricing();
                                        $priceValue = $modelPrincing->getPrice($secteur['id'], $belonging["id"], $type["id"]);
                                   
                                    ?>
                                        <td><input class="form-control" type="text" name="p_<?php echo $type["id"]?>_<?php echo $belonging["id"]?>" value="<?php echo $priceValue ?>"/></td>
                                    <?php
                                    }
                                }
                                ?>

                                </tr>
                            <?php
                                }
                            }
                            ?>
			</tbody>
                        </table>
                 	
		<div class="col-xs-6 col-xs-offset-6" id="button-div">
		        <input type="submit" class="btn btn-primary" value="<?= CoreTranslator::Save($lang) ?>" />
			<button type="button" onclick="location.href='pssectors'" class="btn btn-default"><?= CoreTranslator::Cancel($lang) ?></button>
				
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
