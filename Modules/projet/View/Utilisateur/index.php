<?php $this->title = "SyGRRiF Users"?>

<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>
<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';
?>
<?php 
require_once 'Modules/projet/Model/Utilisateur.php';
?>
<?php 
$readonly ="";
$disabled="";
if(!$ModifierUser){
	$readonly= "readonly";

}
?>
<body>
<div class="container">
<form class="form-horizontal" action="Utilisateur/AjoutUser" method="post" >
<input type="hidden" name="id" id="id" />
<fieldset>
			<legend>Ajouter un utilisateur</legend>
			  	<div class="form-group">
			<?php if (isset($duser) && $duser['id']!=""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="id" type="text"  name="id" value="<?=$this->clean($duser['id']) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
			  	
					<label label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::nom($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="nom" type="text" name="nom" <?=$readonly?><?php if(isset($duser)){?>value="<?=$duser['nom']?>"<?php }?> />
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::prenom($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="prenom" type="text" name="prenom" <?=$readonly?> <?php if(isset($duser)){?>value="<?=$duser['prenom']?>"<?php }?>/>
					</div>
				</div>
					<br/>
					<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label">Identifiant:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="identifiant" type="text" name="identifiant" <?=$readonly?> <?php if(isset($duser)){?>value="<?=$duser['identifiant']?>"<?php }?>/>
					</div>
				</div>
					<br/>
					<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label">Mot de passe:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="mdp" type="password" name="mdp" <?=$readonly?>/>
					</div>
				</div>
					<br/>
					<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::mail($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="courrier" type="text" name="courrier" <?=$readonly?><?php if(isset($duser)){?>value="<?=$duser['courrier']?>"<?php }?>/>
					</div>
				</div>
					<br/>
					<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::tel($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="tel" type="text" name="tel" <?=$readonly?><?php if(isset($duser)){?>value="<?=$duser['tel']?>"<?php }?>/>
					</div>
				</div>
					<br/>
					
				<div class="form-group">
					<label for="type" class="col-lg-2 control-label">Status:</label><br/>
					 <div class="col-lg-10">
					 <?php if(isset($duser)){$du=$duser['status'];}?>
       					<div class="radio">
       						<label>
								<input type="radio" id="status"  name="status" value="visiteur" <?php if ($du=='visiteur'){echo 'checked="checked"';}?>>Visiteur     
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="status"  name="status" value="utilisateur"<?php if ($du=='utilisateur'){echo 'checked="checked"';}?>>Utilisateur
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="status"  name="status" value="manager" <?php if ($du=='manager'){echo 'checked="checked"';}?>>Manager
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="status"  name="status" value="admin" <?php if ($du=='administrateur'){echo 'checked="checked"';}?> >Administrateur
							</label>
						</div>
					
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label for="Titre" class="col-lg-2 control-label">Charte:</label><br/>
					<div class="col-lg-10">
					<?php if(isset($duser)){$tc=$duser['charte'];}?>
					<div class="radio">
       						<label>
								<input type="radio" id="charte"  name="charte" value="oui" <?php if($tc='oui'){echo 'checked=checked';}?>>Oui
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="charte"  name="charte" value="non"  <?php if($tc='non'){echo 'checked=checked';}?> >Non
							</label>
						</div>					</div>
				</div>
				
					<br/>
					<br/>
				
				<br/>
				<input type="submit" class="btn btn-primary"/>
				<?php if (isset($duser) && $duser['id']!=""){?>
		        <button type="button" onclick="location.href='utilisateur/DeleteUser/<?=$this->clean($duser['id']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
				<?php }?>
			
		</fieldset>
		</form>
		</div>
		</body>
<?php include 'Modules/core/View/timepicker_script.php';?>