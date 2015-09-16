<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>
<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php 
require_once 'Modules/projet/Model/GestionTarif.php';
?>
<?php 
$readonly ="";
 echo $ModifierTarif;
if(!$ModifierTarif){
	$readonly= "readonly";
}
?>
<body>
<div class="container">
<form class="form-horizontal" action="Tarifs/AjoutTarif" method="post" >

<fieldset>

<input class="form-control" id="idt" type="hidden" name="idt" <?php if(isset($Mesdonnees)){?>value="<?= $Mesdonnees['idt']?>"<?php }?> />

			<legend><?=ProjetTranslator::ajoutertarif($lang)?></legend>
			<?php if (isset($Mesdonnees) && $Mesdonnees['idt']!=""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="idt" type="text"  name="idt" value="<?=$this->clean($Mesdonnees['idt']) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
			  	
			
			  	<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::nom($lang)?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="tnom" type="text" name="tnom" <?=$readonly?>  <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['tnom']?>" <?php }?>/>
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::montant($lang)?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="montant" type="text" name="montant" <?=$readonly?>  value="<?php if (isset($Mesdonnees)){?><?=$Mesdonnees['montant']?> " <?php }?>/>
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label for="type" class="col-lg-2 control-label"><?=ProjetTranslator::type($lang)?>:</label><br/>
					 <div class="col-lg-10">
					 <?php if (isset($Mesdonnees)){$d=$Mesdonnees['type']; }?>
       					<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Partenaire" <?php if ($d=='Partenaire') echo 'checked="checked"'; ?> >Partenaire     
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Organisme Publique et ONG" <?php if ($d=='Organisme Publique et ONG') echo 'checked="checked"'; ?>> Organisme Publique et ONG
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Industriels" <?php if ($d=='Industriels') echo 'checked="checked"'; ?>>Industriels
							</label>
						</div>
						
					
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label for="Titre" class="col-lg-2 control-label"><?=ProjetTranslator::valide($lang)?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="validite" type="date" name="validite" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['dureevalidite']?>" <?php }?>/>
					</div>
				</div>
				
					<br/>
					<br/>
				
				<br/>
				<input type="submit" value="<?=ProjetTranslator::enregistrer($lang)?>"  class="btn btn-primary"/>
				
				<?php if (isset($Mesdonnees) && ($Mesdonnees['idt']!="")){?>
		        <button type="button" onclick="location.href='Tarifs/DeleteTarif/<?=$this->clean($Mesdonnees['idt']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
				<?php }?>
		</fieldset>
		</form>
		</div>
		</body>
<?php include 'Modules/core/View/timepicker_script.php';?>