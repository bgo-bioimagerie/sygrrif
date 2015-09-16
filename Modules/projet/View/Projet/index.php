<?php $this->title = "Fiche-Projet"?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php echo $navBar?>
<?php include "Modules/projet/View/projetnavbar.php"; ?>

<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';

?>

<head>

<style>

form#multiphase > #phase2, #phase3, #phase4, #phase5, #phase6, #phase7, #phase8, #phase9, #phase10, #phase11, #phase12, #phase13, #phase14, #phase15,  #show_all_data{ display:none;}

</style>  

	 <?php 
$readonly ="";
$disabled="";
$ajoutadmin="";
$diadmin="";
if(!$ModifierFicheProjet){
	$readonly= "readonly";
	$disabled="disabled";
}
if(!$ajouteradmin){
	$ajoutadmin="readonly";
	$diadmin="disabled";
}
?>
<script type="text/javascript">
//fonction pour alerter les gens s'ils n'ont pas cocher une des cases radio
    
	    //script pour écrire ce qu'il y'a dans select
	         //--- variables globales ---
	         
                        var myselect=null;
					      window.onload = function () 
					      {        
						      myselect=document.getElementById("acronyme")
							  myselect.onchange=function () 
							  {
									 var index=this.selectedIndex
                                        print (this.options[index].text); 

                               } 
						 } 

                      function print(textIn) 
                      { 	
                            var cont = document.getElementById('new');
                         	var txt=textIn;
                            var un = document.createElement('input');
                            un.type   = 'text';
                            un.value= txt;
                            
                            
                            cont.appendChild(un);
                               
                     } 
                     
 			// afficher une nouvelle partie ou l'untilisateur pourait ajouter une personne ou plusieurs 
  			function ajouterip(i)
  			{
  			 var i2 = i + 1;
  					_('leschamps_'+i).innerHTML+= '<fieldset"><legend><?= ProjetTranslator::ip($lang)?></legend><div class="form-group"><input type="hidden" id="id_ip" name="invesp[id_ip][]"/><label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom"></div> <label class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom"/></div><label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service"> </div><label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label> <div class="col-lg-10"><input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email"></div><label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label><div class="col-lg-10"><input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone"></div></fieldset>';
  					_('leschamps_'+i).innerHTML += (i <=40 ) ? '<span id="leschamps_'+i2+'"><a href="javascript:ajouterip('+i2+')">Ajouter un investigateur Principal</a></span>' : '';
  					
  			}
  			function ajouteria(j)
  			{
  			 var j2 = j + 1;
  					_('champsia_'+j).innerHTML+= '<fieldset"><legend><?= ProjetTranslator::ia($lang)?></legend><div class="form-group"><input type="hidden" id="id_ia" name="invesa[id_ia][]"/><label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="iaprenom" name="invesa[iaprenom][]" placeholder="Prénom"></div> <label class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom"/></div><label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service"> </div><label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label> <div class="col-lg-10"><input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email"></div><label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label><div class="col-lg-10"><input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone"></div></fieldset>';
  					_('champsia_'+j).innerHTML += (j <=40 ) ? '<span id="champsia_'+j2+'"><a href="javascript:ajouteria('+j2+')">Ajouter un investigateur AssociE</a></span>' : '';
  					
  			}
  			function ajouterarc(l)
  			{
  			 var l2 = l + 1;
  					_('arcchamps_'+l).innerHTML+= '<fieldset"><legend><?= ProjetTranslator::arc($lang)?></legend><div class="form-group"><input type="hidden" id="id_arc" name="arc[id_arc][]"/><label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="arcprenom" name="arc[arcprenom][]" placeholder="Prénom"></div> <label class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="arcnom" name="arc[arcnom][]" placeholder="Nom"/></div><label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="arcfonction" name="arc[arcfonction][]" placeholder="Fonction, Service"> </div><label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label> <div class="col-lg-10"><input type="text" class="form-control" id="arcmail" name="arc[arcmail][]" placeholder="Email"></div><label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label><div class="col-lg-10"><input type="text" class="form-control" id="arctel" name="arc[arctel][]" placeholder="Téléphone"></div></fieldset>';
  					_('arcchamps_'+l).innerHTML += (l <=40 ) ? '<span id="arcchamps_'+l2+'"><a href="javascript:ajouterarc('+l2+')">Ajouter un attaché de recherche clinique</a></span>' : '';
  					
  			}
  			function ajouterprogrammation(p)
  			{
  			 var p2 = p + 1;
  					_('champsprog_'+p).innerHTML+= '<h3>Programmation</h3><input class="form-control" type ="hidden" id="id_prog" name="prog[id][]" /><label label for="inputEmail" class="col-lg-4 control-label">  <?= ProjetTranslator::inpp($lang)?>: </label><div class="col-lg-8"><input class="form-control" type ="text" id="programmation" name="prog[dxplanning][]"  <?=$ajoutadmin?>/></div><label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label><div class="col-lg-10"><textarea class="form-control" rows="2" cols="50" name="prog[commentaire][]" <?=$readonly?>> </textarea></div><label label for="inputEmail" class="col-lg-2 control-label">  Code couleur: </label><div class="col-lg-10"><?php if(isset($color)){$var= $color; ?><select class="form-control" name="prog[codecouleur][]" id="codecouleur" <?=$disabled;?>><option>-----</option><?php foreach($var as $col){?><option value="<?php echo $col["name"];?>" > <?php echo $col["name"];?></option><?php } ?> </select>	<?php } ?></div>';
  					_('champsprog_'+p).innerHTML += (p <=40 ) ? '<span id="champsprog_'+p2+'"><a href="javascript:ajouterprogrammation('+p2+')">Dupliquer programmation</a></span>' : '';
  					
  			}
  			
			function ajoutercotation(c){
  	  			var c2= c+ 1;
  	  			_('champscotation_'+c).innerHTML+='<h3>Cotation</h3><input type="hidden" name="cot[id][]"/><label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::inppc($lang)?>: </label><div class="col-lg-10"><input class="form-control" type ="text" id="cotation" name="cot[intitule][]"/></div><label label for="inputEmail" class="col-lg-2 control-label" > Cotation:</label><div class="col-lg-10"><div class="radio" ><label><input type="radio" id="facturable"  name="cot[facturable][]" value="facturable"   <?=$diadmin?>/>Facturable </label><label><input type="radio" id="facturable"  name="cot[facturable][]" value="nonfacturable" <?=$diadmin?>/>Non Facturable </label></div></div><label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label><div class="col-lg-10"><textarea class="form-control" rows="4" cols="50" name="cot[commentaire][]" <?=$readonly?>></textarea></div> ';
  				_('champscotation_'+c).innerHTML+= (c <=40)? '<span id="champscotation_2'+c2+'"><a href="javascript:ajoutercotation('+c2+')">Dupliquer cotation</a></span>': '';
  					
  			}
			function ajouterfinancement(f){
				var f2=f+1;
			_('champsfinancement_'+f).innerHTML+='<h3>Type de financement</h3><input type="hidden" name="fin[id][]" /><label label for="inputEmail" class="col-lg-2 control-label"> Soins courants: </label><div class="col-lg-10"><div class="radio" ><label><input type="radio" id="soincourant"  name="fin[soinscourant][]" value="oui"  <?=$diadmin?>/>Oui   </label><label><input type="radio" id="soincourant"  name="fin[soinscourant][]" value="non" <?=$diadmin?>/>Non </label></div></div><?php if(isset($Tarif)){?><label for="inputEmail" class="col-lg-2 control-label">Prix:</label><div class="col-lg-10" ><?php $vard = $Tarif;?><?php if(isset($Mesdonnees)){$tar=$Mesdonnees['coutestime'];}?><select class="form-control"  name="fin[tarif][]" <?=$diadmin?>> <option>----</option><?php foreach($vard as $d){?><option value="<?php echo $d["montant"];?>  <?=$readonly?> <?php if($tar==$d['montant']) echo 'selected';?>"> <?php echo $d["montant"];?></option><?php } ?>  <option value="Autres">Autres</option></select></div><?php }?><div class="form-group" id="tarif2"><label for="inputEmail" class="col-lg-2 control-label">Entrez votre valeur:</label><div class="col-lg-10"><input type="text" class="form-control" id="coutestime" name="tarif2" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['coutestime']?>" <?php }?> /></div></div><label label for="inputEmail" class="col-lg-2 control-label">Commentaire: </label><div class="col-lg-10"><input class="form-control" type ="text" id="comtypefinancement" name="fin[commentaire][]" <?=$ajoutadmin?>/></div>';
			_('champsfinancement_'+f).innerHTML+= (f<=40)?'<span id="champsfinancement_2'+f2+'"><a href="javascript:ajouterfinancement('+f2+')">Dupliquer type de financement</a></span>':'';
			}	
  			function calcul()
  			{
  			  var nbr= Number(document.getElementById("nbrexam").value);
  			 
              var dur = Number(document.getElementById("duree").value);

              var dt = Number((nbr* dur)/60);
              document.getElementById("dureetotale").value = dt;
  			}
			function _(x)
			{
				return document.getElementById(x);
			}
			 //script pour les phases
			 

			function processPhase1()
			{
				 var radioType = document.getElementsByName("type"); 
				 var checked = false; 
                 for (var cpt = 0 ; (cpt < radioType.length) && !checked ; cpt++) { 
                 checked = checked || radioType[cpt].checked; 
                 } 
                 
				if (!checked) { 
                 alert("Attention Vous n'avez pas selectionné un type"); 
                 } 
                 else{
				_("phase1").style.display= "none";
				_("phase2").style.display= "block";
				_("progressBar").value =14,28;
				_("status").innerHTML ="Etape 2 de 7 ";
                 }
                 window.scrollTo(0,0)
				
			}
			
				function prviewPhase1()
				{
		 			_("phase1").style.display= "block";
					_("phase2").style.display= "none";
					_("status").innerHTML ="Etape 1 de 7 ";
					window.scrollTo(0,0)
				}
			function cacher2(){
				_("phase2").style.display= "none";
			}
			function cacher3(){
				_("phase3").style.display= "none";
			}
			function cacher4(){
				_("phase4").style.display= "none";
			}
			function cacher5(){
				_("phase5").style.display= "none";
			}
			function cacher6(){
				_("phase6").style.display= "none";
			}
			function cacher7(){
				_("phase7").style.display= "none";
			}
			function cacher8(){
				_("show_all_data").style.display= "none";
			}
			function processPhase2()
			{
				 _("phase2").style.display ="none";
				 _("phase3").style.display ="block";
				 _("progressBar").value =28,56;
				 _("status").innerHTML ="Etape 3 de 7 ";
				 window.scrollTo(0,0)
				
			}
				function prviewPhase2()
				{  
					_("phase2").style.display= "block";
					_("phase3").style.display= "none";
					_("progressBar").value =14,28;
					_("status").innerHTML ="Etape 2 de 7 ";
					window.scrollTo(0,0)
				}
			function processPhase3()
			{
				 _("phase3").style.display ="none";
				 _("phase4").style.display ="block";
				 _("progressBar").value =42.84;
				 _("status").innerHTML ="Etape 4 de 7 ";
				 window.scrollTo(0,0)
					
			}
				function prviewPhase3()
				{
		  			_("phase3").style.display= "block";
					_("phase4").style.display= "none";
			 		_("progressBar").value =28,56;
					_("status").innerHTML ="Etape 3 de 7 ";
					window.scrollTo(0,0)
				}
				
			function processPhase4()
			{
				_("phase4").style.display ="none";
				_("phase5").style.display ="block";
				_("progressBar").value =57,12;
				_("status").innerHTML ="Etape 5 de 7 ";
				window.scrollTo(0,0)
					
			}
				 function prviewPhase4()
				 {
					_("phase4").style.display= "block";
					_("phase5").style.display= "none";
					_("progressBar").value =42.84;
					_("status").innerHTML ="Etape 4 de 7 ";
					window.scrollTo(0,0)
				
				}
		
			function processPhase5()
			{
				 
				 _("phase5").style.display ="none";
				 _("phase6").style.display ="block";
				 _("progressBar").value =71,4;
				 _("status").innerHTML ="Etape 6 de 7 ";
                 window.scrollTo(0,0)
			}
				function prviewPhase5()
				{
					_("phase5").style.display ="block";
					_("phase6").style.display ="none";
					_("progressBar").value =57,12;
					_("status").innerHTML ="Etape 5 de 7 ";
					window.scrollTo(0,0)	
				}
				
		   function processPhase6()
		   {
			   $(document).ready(function() {
					 
				    $('#tarif2').hide(); // on cache le champ par défaut
				     
				    $('select[name="tarif"]').change(function() { // lorsqu'on change de valeur dans la liste
				    var valeur = $(this).val(); // valeur sélectionnée
				     
				        if(valeur != '') { // si non vide
				            if(valeur == 'Autres') { // si "Autres"
				                $('#tarif2').show();
				            } else {
				                $('#tarif2').hide();           
				            }
				        }
				    });
				 
				});
				_("phase6").style.display ="none";
			    _("phase7").style.display ="block";
			    _("progressBar").value =85,68;
			    _("status").innerHTML ="Etape 7 de 7 ";
			    window.scrollTo(0,0)
		   }
		
		   		function prviewPhase6()
		   		{
				 _("phase6").style.display ="block";
				 _("phase7").style.display ="none";
				 _("progressBar").value =71,4;
				 _("status").innerHTML ="Etape 6 de 7 ";
				 window.scrollTo(0,0)
				}
		 function processPhase7()
		 {
			 _("phase7").style.display ="none";
			 _("show_all_data").style.display ="block";
			 _("progressBar").value =100;
			 _("status").innerHTML ="Dernière étape ";
			 window.scrollTo(0,0)
		}
			    function prviewPhase7()
			    {
				    _("phase7").style.display ="block";
				    _("show_all_data").style.display ="none";
				    _("progressBar").value =85,68;
				    _("status").innerHTML ="Etape 7 de 7";
				    window.scrollTo(0,0)
				}
		
		
		
	 
			
				
	
			//toute les etapes
			// pour envoyer les données (comme l'utilisation du boutton submit 
		function submitForm()
		{
			_("multiphase").method ="post";
			_("multiphase").action ="projet/ajoutDonneQuery";
			_("multiphase").submit();

		}
		
</script>
     
</head>


<body>

<div class="container">
	<div class="left">
<div text-left><button class="btn btn-primary btn-xs" onclick="processPhase1()"> +2</button><button class="btn btn-primary btn-xs" onclick="cacher2()"> -2 </button>
	<button class="btn btn-primary btn-xs" onclick="processPhase2()">+3 </button><button class="btn btn-primary btn-xs" onclick="cacher3()"> -3</button>
	<button class="btn btn-primary btn-xs" onclick="processPhase3()">+4</button><button class="btn btn-primary btn-xs" onclick="cacher4()"> -4</button>
	<button class="btn btn-primary btn-xs" onclick="processPhase4()">+5</button><button class="btn btn-primary btn-xs" onclick="cacher5()"> -5</button>	
	<button class="btn btn-primary btn-xs" onclick="processPhase5()">+6</button><button class="btn btn-primary btn-xs" onclick="cacher6()"> -6</button>	
	<button class="btn btn-primary btn-xs" onclick="processPhase6()">+7</button><button class="btn btn-primary btn-xs" onclick="cacher7()"> -7</button>	
	<button class="btn btn-primary btn-xs" onclick="processPhase7()">+8</button><button class="btn btn-primary btn-xs" onclick="cacher8()"> -8</button>	
</div>
	<div id="header"> 
		<h1>
			<?= ProjetTranslator::formulaireProjet($lang) ?>
		 <small></small>
		</h1> 
	</div>
	<progress id="progressBar" value="0" max ="100" style="width:515px;"> </progress>
		<div id="status"  class="well well-sm">
				 Etape 1 de 8
 		</div>
<form enctype='multipart/form-data' id="multiphase" name="form" onsubmit="return false" class="form-horizontal">
<input class="form-control" id="idform" type="hidden" name="idform" />
	<fieldset id="phase1">
		<legend>Projet</legend>
			<?php if (isset($Mesdonnees) && $idform!=""){
			?>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="idform" type="text"  name="idform" value="<?=$this->clean($Mesdonnees['idform']) ?>" readonly/>
				</div>
			</div>

			<?php 		
		}
		?>
	
			
			  <div class="form-group">
			  	<label label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::datedemande($lang) ?> :</label>
					<div class="col-lg-10">
						<input class="form-control" id="datedemande" type="date" name="datedemande" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['datedemande']?>" <?php }?> />
					</div>
			
			<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::remplipar($lang)?>:</label>
				<div class="col-xs-10">
					<?php //pour le nom de l'utilisateur
					//verfier si l'utilisateur est un admin 
						$allowedBookForOther = true;
						if ( $this->clean($curentuser['id_status']) < 2)
						{
						$allowedBookForOther = false;
						}
						$recipientID = 0;
						if(isset($Mesdonnees))
						{
							//verifie si les données sont envoyés si oui on prend l'id de l'utilisateur 
							$recipientID = $this->clean($Mesdonnees["idutil"]);
						}
						if ($allowedBookForOther==false && $recipientID != $this->clean($curentuser['id']))
						{
						//si ce n'est pas un administrateur et si les données sont envoyées et si l'utilisateur change alors affichage sans modification
						?>
						<select class="form-control" name="utilisateur" disabled>
						<?php
							foreach ($users as $user)
							{
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $recipientID)
								{
									?>
									<OPTION value="<?= $userId ?>"> <?= $userName?> </OPTION>
									<?php
								} 
							}?>
						</select>
						
						
						<?php }

							elseif (($Mesdonnees["idform"])!="")
						{
						//si ce n'est pas un administrateur et si les données sont envoyées et si l'utilisateur change alors affichage sans modification
						?>
						<select class="form-control" name="utilisateur" >
							<?php
								if ($allowedBookForOther)
								{
									$recipientID = $this->clean($Mesdonnees["idutil"]);
									if ($recipientID == "" && $recipientID == 0)
									{
										$recipientID = $this->clean($curentuser['id']); 
									} 
								foreach ($users as $user)
								{
									$userId = $this->clean($user['id']);
									$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
									$selected = "";
									if ($userId == $recipientID)
									{
										$selected = "selected=\"selected\"";
									}
								?>
								<OPTION value="<?= $userId ?>" <?= $selected ?>> <?= $userName?> </OPTION>
								<?php 
								}
							}
						else{
							?>
							<OPTION value="<?= $this->clean($curentuser['id']) ?>"> <?=$this->clean($curentuser['name']) . " " . $this->clean($curentuser['firstname'])?> </OPTION>
							<?php
							}?>
						</select>
						
						
						<?php }
						
						
						else
							{
					?>
								<select class="form-control" name="utilisateur" >
								<?php
								if ($allowedBookForOther)
								{
									$recipientID = $this->clean($Mesdonnees["idutil"]);
									if ($recipientID == "" && $recipientID == 0)
									{
										$recipientID = $this->clean($curentuser['id']); 
									} 
								foreach ($users as $user)
								{
									$userId = $this->clean($user['id']);
									$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
									$selected = "";
									if ($userId == $recipientID)
									{
										$selected = "selected=\"selected\"";
									}
								?>
								<OPTION value="<?= $userId ?>" <?= $selected ?>> <?= $userName?> </OPTION>
								<?php 
								}
							}
						else{
							?>
							<OPTION value="<?= $this->clean($curentuser['id']) ?>"> <?=$this->clean($curentuser['name']) . " " . $this->clean($curentuser['firstname'])?> </OPTION>
							<?php
							}
					}
					// fin pour le nom d'utilisateur ?>
				</select>
			
				
			</div>
		
					<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::Acronyme($lang)?>:</label>
					<div class="col-lg-10" >
						<input class="form-control" id="acronyme" type="text" name="acronyme" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['acronyme']?>" <?php }?>/>	
					</div>
				
				
					<label for="Titre" class="col-lg-2 control-label"><?= ProjetTranslator::titre($lang) ?>:</label>
					<div class="col-lg-10">
						<input class="form-control" id="titre" type="text" name="titre" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['titre']?>" <?php }?>/>
					</div>
					</div>
				<div class="form-group">
				<?php if (isset($Mesdonnees)){$d=$Mesdonnees['type']; }?>
					<label for="type" class="col-lg-2 control-label"><?= ProjetTranslator::type($lang) ?>:</label>
					 <div class="col-lg-10">
       					<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Pilote" <?=$readonly?>  <?php if ($d=='Pilote') echo 'checked="checked"'; ?> ><?= ProjetTranslator::pilote($lang) ?>    
							</label>
							<label>
								<input type="radio" id="type"  name="type" value="Méthodologique" <?=$readonly?><?php if ($d=='Méthodologique') echo 'checked="checked"'; ?>> <?= ProjetTranslator::methodo($lang) ?>
							</label>
							<label>
								<input type="radio" id="type"  name="type" value="Recherche Clinique"  <?=$readonly?> <?php if ($d=='Recherche Clinique') echo 'checked="checked"'; ?>><?= ProjetTranslator::rechercheclini($lang) ?> 
							</label>
							<label>
								<input type="radio" id="type"  name="type" value="Multicentrique" <?=$readonly?> <?php if ($d=='Multicentrique') echo 'checked="checked"'; ?>><?= ProjetTranslator::multicen($lang) ?> 
							</label>
						</div>
						</div>
					</div>
					
				<div class="form-group">
						<label for="select" class="col-lg-2 control-label"><?=ProjetTranslator::typeorgane($lang)?>:</label>
						<div class="col-lg-10" >
						<?php if (isset($Mesdonnees) ){$n= $Mesdonnees['nac']; }?>
							<input type="radio" id="type"  name="nac" value="Neuro" <?php if ($n=='Neuro'){echo 'checked=ckecked';}?> / >Neuro     
							<input type="radio" id="type"  name="nac" value="Abdo"  <?php if ($n=='Abdo') echo 'checked="checked"'; ?>/> Abdo
							<input type="radio" id="type"  name="nac" value="Cardio"  <?php if ($n=='Cardio') echo 'checked="checked"'; ?>/>Cardio
						</div>
						
					</div>
			
				<button class="btn btn-primary"onclick="processPhase1()" class="btn btn-primary"><?=ProjetTranslator::contunier($lang)?> </button>
		</fieldset>
		
		
		<fieldset id="phase2">
			<?php  if(isset($invP) && $idform!=""){
		for($i=0; $i<count($invP); $i++){
			
			 ?>
			 
		<legend><?= ProjetTranslator::ip($lang) ?></legend>
				<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="id_ip" type="text"  name="invesp[id_ip][]" value="<?=$this->clean($invP[$i]['id_ip']) ?>" readonly/>
				</div>
					</div>
					<div class="form-group">
					
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom" <?=$readonly?> value="<?=$invP[$i]['ipprenom']?>" > 
							
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom" <?=$readonly?>  value="<?=$invP[$i]['ipnom']?>" >
						
						</div>
					
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service" <?=$readonly?> value="<?=$invP[$i]['ipfonction']?>" >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email" <?=$readonly?>  value="<?=$invP[$i]['ipmail']?>">
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone" <?=$readonly?> value="<?=$invP[$i]['iptel']?>">
						</div>
								
				</div>
				
					<?php }}?>
					<div id="leschamps">
		
					<legend><?= ProjetTranslator::ip($lang) ?></legend>
					<div class="form-group">
					<input type="hidden" name="invesp[id_ip][]" id="id_ip"/>
					
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom" <?=$readonly?>  > 
						
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom" <?=$readonly?> >
							
						</div>
						
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service" <?=$readonly?>  >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email" <?=$readonly?> >
						
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone" <?=$readonly?> >
						</div>
						</div>
				<span id="leschamps_2"><a href="javascript:ajouterip(2)"><?=ProjetTranslator::addinvp($lang)?></a></span>
					</div>
						
					<?php  if(isset($invA) && $idform!=""){
					for($k=0; $k<count($invA); $k++){?>
		
			<legend><?= ProjetTranslator::ia($lang) ?></legend>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="id_ia" type="text"  name="invesp[id_ia][]"  value="<?=$this->clean($invA[$k]['id_ia']) ?>" readonly/>
				</div>
					</div>
					<div class="form-group">
					
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iaprenom" name="invesa[iaprenom][]" placeholder="Prénom" <?=$readonly?> value="<?=$invA[$k]['iaprenom']?>" > 
						
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom" <?=$readonly?>  value="<?=$invA[$k]['ianom']?>" >
							
						</div>
						
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service" <?=$readonly?> value="<?=$invA[$k]['iafonction']?>" >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email" <?=$readonly?>  value="<?=$invA[$k]['iamail']?>">
						
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone" <?=$readonly?> value="<?=$invA[$k]['iatel']?>">
						</div>
								
				</div>
				
					
					<?php }}?>
					<div id="champsia">
		
					<legend><?= ProjetTranslator::ia($lang) ?></legend>
					<div class="form-group">
				<input type="hidden" name="invesa[id_ia][]" id="id_ia"  />
					
					
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iparenom" name="invesa[iaprenom][]" placeholder="Prénom" <?=$readonly?>  > 
							
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom" <?=$readonly?>   >
							
						</div>
					
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service" <?=$readonly?>  >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email" <?=$readonly?> >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-4">
							<input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone" <?=$readonly?> >
						</div>
								
				</div>
				
					<span id="champsia_2"><a href="javascript:ajouteria(2)"><?=ProjetTranslator::addinva($lang)?></a></span>
					</div>	
					
					
			<ul class="pager">
					 <li><button class="btn btn-info"onclick="prviewPhase1()"><?=ProjetTranslator::precedent($lang)?></button></li>
					 <li><button class="btn btn-info"onclick="processPhase2()"><?=ProjetTranslator::suivant($lang)?></button></li>
				 </ul>
		</fieldset>
		<fieldset id="phase3">
		<legend><?= ProjetTranslator::coord($lang) ?></legend>
				<div class="form-group">
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::prenom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cprenom" name="cprenom" placeholder="Prénom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cprenom']?>" <?php }?>> 
					
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::nom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cnom" name="cnom" placeholder="Nom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cnom']?>" <?php }?>>
						
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cfonction" name="cfonction" placeholder="Fonction, Service" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cfonction']?>" <?php }?>>
						
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cmail" name="cmail" placeholder="Email" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cmail']?>" <?php }?>>
				
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="ctel" name="ctel" placeholder="Téléphone" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['ctel']?>" <?php }?>>
					</div>
				</div>
				<legend>Promoteur</legend>
        		<div class="form-group">
        		<label class="col-lg-2 control-label"><?=ProjetTranslator::nometpr($lang)?>: </label>
            		<div class="col-lg-10" >
						<input type="text" class="form-control"   id="promoteur" name="promoteur" placeholder="Promoteur" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['promoteur']?>" <?php }?>/>
					</div>
				
					<label class="col-lg-2 control-label"><?=ProjetTranslator::commenprog($lang)?>: </label>
					<div class="col-lg-10" >
						<input type="text" class="form-control"   id="infos" name="infos" placeholder="Infos Complémentaire" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['infos']?>" <?php }?>/>
					</div>
				</div>	
				<legend>CRO</legend>
				<div class="form-group">
					<label class="col-lg-2 control-label"><?= ProjetTranslator::libelle($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="crolibelle" name="crolibelle" placeholder="<?= ProjetTranslator::libelle($lang) ?>" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['crolibelle']?>" <?php }?>>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::cri($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cri" name="cri" placeholder="<?= ProjetTranslator::cri($lang) ?>" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cri']?>" <?php }?> >
					</div>
				</div>
				
				
				<div class="alert alert-dismissible alert-info">
  			<button type="button" class="close" data-dismiss="alert">×</button>
  				<strong>Infos</strong>   CRO: Centre d'organisation et de recherche.
			</div>
			
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase2()"><?=ProjetTranslator::precedent($lang)?></button></li>
					 <li><button class="btn btn-info"onclick="processPhase3()"><?=ProjetTranslator::suivant($lang)?></button></li>
				 </ul>
		</fieldset>
		
		
	
			
		<fieldset id="phase4">
			<?php  if(isset($arc) && $idform!=""){
		for($l=0; $l<count($arc); $l++){?>
		<legend><?= ProjetTranslator::arc($lang) ?>:</legend>
		<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="id_arc" type="text"  name="arc[id_arc][]" value="<?=$this->clean($arc[$l]['id_arc']) ?>" readonly/>
				</div>
					</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="arcprenom" name="arc[arcprenom][]" placeholder="Prénom" <?=$readonly?>  value="<?=$arc[$l]['arcprenom']?>" >
					
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::nom($lang) ?>: </label>
					<div class="col-lg-4">
						<input type="text" class="form-control" id="arcnom" name="arc[arcnom][]" placeholder="Nom" <?=$readonly?>  value="<?=$arc[$l]['arcnom']?>" >
					
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="arcfonction" name="arc[arcfonction][]" placeholder="Fonction, Service" <?=$readonly?> value="<?=$arc[$l]['arcfonction']?>" >
					
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::mail($lang) ?>: </label>
					<div class="col-lg-4">
					<input type="text" class="form-control" id="arcmail" name="arc[arcmail][]" placeholder="Email" <?=$readonly?> value="<?=$arc[$l]['arcmail']?>" >
				
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::tel($lang) ?>: </label>
					<div class="col-lg-4">
					<input type="text" class="form-control" id="arctel" name="arc[arctel][]" placeholder="Téléphone" <?=$readonly?> value="<?=$arc[$l]['arctel']?>" >
					</div>
				</div>
			
		<?php }}?>
			
					<div id="arcchamps">
		
					<legend><?= ProjetTranslator::arc($lang) ?></legend>
					<div class="form-group">
					<input type="hidden" name="arc[id_arc][]" id="id_arc"/>
					
					<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="arcprenom" name="arc[arcprenom][]" placeholder="Prénom" <?=$readonly?>  > 
						
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="arcnom" name="arc[arcnom][]" placeholder="Nom" <?=$readonly?> >
							
						</div>
						
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="arcfonction" name="arc[arcfonction][]" placeholder="Fonction, Service" <?=$readonly?>  >
							
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="arcmail" name="arc[arcmail][]" placeholder="Email" <?=$readonly?> >
						
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="arctel" name="arc[arctel][]" placeholder="Téléphone" <?=$readonly?> >
						</div>
								
				</div>
				
					<span id="arcchamps_2"><a href="javascript:ajouterarc(2)"><?=ProjetTranslator::attrechcli($lang)?></a></span>
					</div>	
					<h3> <?= ProjetTranslator::rsre($lang) ?></h3>
			<div class="form-group">
				<label class="col-lg-2 control-label"><?= ProjetTranslator::nomprenom($lang) ?>: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="rsre" name="rsre" placeholder="Nom et Prénom" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rsre']?>" <?php }?>>
				</div>
			</div>	
			<h3><?= ProjetTranslator::cpp($lang) ?></h3>
				<div class="form-group">
				<label class="col-lg-2 control-label"></label>
					<div class="col-lg-10">
					<?php if(isset($Mesdonnees)){$c=$Mesdonnees['cpp'];}?>
					<div class="radio">
         				 <label>
							<input type="radio" id="cpp"  name="cpp" value="A soumettre"  <?php if ($c=='A soumettre') echo 'checked="checked"'; ?>/><?= ProjetTranslator::soumettre($lang) ?>
						</label>
					
         				 <label>
						<input type="radio" id="cpp"  name="cpp" value="Soumis"  <?php if ($c=='Soumis') echo 'checked="checked"'; ?>/><?= ProjetTranslator::soumis($lang) ?>
						</label>
					
         				 <label>	
						<input type="radio" id="cpp"  name="cpp" value="Accepté"  <?php if ($c=='Accepté') echo 'checked="checked"'; ?>/><?= ProjetTranslator::accepte($lang) ?>
					</label>
					</div>
					
					</div>
					
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"><?= ProjetTranslator::cppnumero($lang) ?>:</label>
					<div class="col-lg-10">
						<input type="text"  class="form-control" name="cppnumero" id="cppnumero" placeholder="CPP Numéro" <?=$readonly?>/ <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cppnumero']?>" <?php }?>>
					</div>
	
				</div>
				
		
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase3()"><?=ProjetTranslator::precedent($lang)?> </button></li>
					 <li><button class="btn btn-info"onclick="processPhase4()"><?=ProjetTranslator::suivant($lang)?></button></li>
				 </ul>
				
			
		
		</fieldset>
		
		
		
		<fieldset id='phase5'>
		<legend><?= ProjetTranslator::descriptionetude($lang) ?></legend>
				<div class="form-group">
					<label for="textArea" class="col-lg-2 control-label"><?= ProjetTranslator::resume($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="10" cols="50" name="resume" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['resume']); }?> </textarea>
					</div>
				</div>
			
				<div class="form-group">
					<label for="Objectif" class="col-lg-2 control-label"><?= ProjetTranslator::objectif($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="objectif" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['objectif']); }?> </textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label for="Expérimentation" class="col-lg-2 control-label" ><?= ProjetTranslator::experimentation($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="experimentation" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['experimentation']); }?> </textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label for="" class="col-lg-2 control-label" >Protocole d'imagerie:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="protocolimagerie" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['protocolimagerie']); }?> </textarea>
					</div>
					</div>
					
				<div class="form-group">
					<label for="Traitement des données" class="col-lg-2 control-label" ><?= ProjetTranslator::traitementdonnee($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="traitementdonnee" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['traitementdonnee']); }?> </textarea>
					</div>
					</div>
				
				<div class="form-group">
					<label for="Résultats attendus" class="col-lg-2 control-label"><?= ProjetTranslator::resultatattendu($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea  class="form-control" rows="4" cols="50" name="resultatattendu" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['resultatattendu']); }?> </textarea>
					</div> 
					</div>
					
				<div class="form-group">
					<label for="Publications envisagées" class="col-lg-2 control-label"><?= ProjetTranslator::publicationenvisage($lang) ?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="publicationenvisage" <?=$readonly?>> <?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['publicationenvisage']);}?> </textarea>
					</div>
				</div>
				
			   <div class="form-group">
					<label for="Mots-clés" class="col-lg-2 control-label"><?= ProjetTranslator::motcle($lang)?>:</label>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="motcle" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['motcle']); }?> </textarea>
					</div>
			   </div>
        	
				  <ul class="pager">
 					 <li><button class="btn btn-info" onclick="prviewPhase4()"><?=ProjetTranslator::precedent($lang)?> </button></li>
					 <li><button class="btn btn-info" onclick="processPhase5()"><?=ProjetTranslator::suivant($lang)?></button></li>
				 </ul>
        </fieldset>
	
		
		<fieldset id="phase6">
		<legend><?= ProjetTranslator::perpn($lang)?></legend>
				<div class="form-group ">
					<h3> <?= ProjetTranslator::tnsp($lang)?></h3><br/>
		   			<label class="col-lg-2 control-label"> <?= ProjetTranslator::temoins($lang)?>: </label> 
					<div class="col-lg-4">
						<input class="form-control" type="text" id="temoins" name="temoins" <?=$readonly?>/>
					</div>
					<label class="col-lg-2 control-label" > <?= ProjetTranslator::patient($lang)?>:</label>
					<div class="col-lg-4">
						<input class="form-control" type ="text" id="patient" name="patient" <?=$readonly?> /> 
					</div>
					<label class="col-lg-2 control-label"> <?=ProjetTranslator::fantome($lang)?>:</label>
					<div class="col-lg-10">
						<input  class="form-control" type="text" id="fontome" name="fantome" <?=$readonly?>/>
		    		</div>
		   		</div>
		  	
		  	 <h3> Protocole</h3>
		 	<div class="form-group ">
				<label for="Responsable de recrutement" class="col-lg-2 control-label"><?=ProjetTranslator::responsablerecrutement($lang)?>:</label>
				<div class="col-lg-10">
		    		<input type='text' class="form-control" name="responsablerecru" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['responsablerecru']?>" <?php }?>/>
				</div>
			</div>
	    	
	    	
			
			<div  class="form-group " name="cj">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::nombredexam($lang)?>: </label>
				<div class="col-lg-4">
					<input class="form-control" type="text" id="nbrexam" onblur="calcul()" name="nbrexam" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['nbrexam']?>" <?php }?> >
				</div>
			
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::dureeexam($lang)?>: </label>
				<div class="col-lg-4">
					<input class="form-control" type="text" id="duree" onblur="calcul()" name="duree"  <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['duree']?>" <?php }?>>
				</div>
			</div>
			<div class="form-group">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::dureetotale($lang)?> :</label>
				<div class="col-lg-10">
				
					<input class="form-control" type="text"  id="dureetotale" onblur="calcul()" name="dureetotale"  <?=$readonly?>  <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['dureetotale']?>" <?php }?>>
				</div>
			</div>
			
			<div class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::planificationprevisinnelle($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="planification" name="planification"  <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['planification']?>" <?php }?> >
				</div>
			</div>
		
			
			
			<div class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::informationcomplementaire($lang)?> :</label>
				<div class="col-lg-10">
					
					<textarea class="form-control" rows="4" cols="50" name="commentaire" <?=$readonly?> ><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['commentaire']); }?> </textarea>
				</div>
			</div>
				<div class="form-group ">
				<h3>Planification</h3>
		 	<br/>
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator:: datedemarageprevu($lang)?>:</label>
				<div class="col-lg-4">
					<input class="form-control" type="date" id="datedemarage" name="datedemarage" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['datedemarage']?>" <?php }?>>
				</div>
			
				<label label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator:: dureeetudeprevu($lang)?>:</label>
				<div class="col-lg-4">
					<input class="form-control" type="text" id="dureeetude" name="dureeetude" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['dureeetude']?>" <?php }?>>
				</div>
			</div>
			
			<div class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator:: contraint($lang)?>:</label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="contrainte" name="contrainte" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['contrainte']?>" <?php }?>>		
					</div>
				</div>
		
			
			
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase5()"><?=ProjetTranslator::precedent($lang)?></button></li>
					 <li><button class="btn btn-info"onclick="processPhase6()"><?=ProjetTranslator::suivant($lang)?></button></li>
		</ul>	
		</fieldset >
	
		
		<fieldset id="phase7">
			<legend><?=ProjetTranslator::besoinspecif($lang)?></legend>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-6 control-label"> <?=ProjetTranslator::ressouHLME($lang)?>:</label>
					<div class="col-lg-6"> 
						<input class="form-control" type="text" id="rhlme" name="rhlme" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rhlme']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-6 control-label"> <?=ProjetTranslator::ressouHLMN($lang)?></label>
					<div class="col-lg-6"> 
						<input class="form-control" type="text" id="rhlmn" name="rhlmn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rhlmn']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-6 control-label"> <?=ProjetTranslator::aedsm($lang)?></label>
					<div class="col-lg-6"> 
						<input class="form-control" type="text" id="aedsm" name="aedsm" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['aedsm']?>" <?php }?>/>
					</div>
				</div>
			
				
				<h3>Plateforme Neurinfo</h3>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-4 control-label"><?=ProjetTranslator::aaon($lang)?></label>
					<div class="col-lg-8"> 
						<input class="form-control" type="text" id="aaodn" name="aaodn" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['aaodn']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-4 control-label"> <?=ProjetTranslator::cstn($lang)?></label>
					<div class="col-lg-8"> 
						<input class="form-control" type="text" id="cspn" name="cspn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cspn']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-4 control-label"><?=ProjetTranslator::ncdn($lang)?>:</label>
					<div class="col-lg-8"> 
						<input class="form-control" type="text" id="ndlcdn" name="ndlcdn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['ndlcdn']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-4 control-label"> <?=ProjetTranslator::cauto($lang)?></label>
					<div class="col-lg-8"> 
						<input class="form-control" type="text" id="caf" name="caf" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['caf']?>" <?php }?>/>
					</div>
				</div>
				<h3> <?=ProjetTranslator::plandiss($lang)?></h3>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-6 control-label" ><?=ProjetTranslator::mddedmr($lang)?></label>
					<div class="col-lg-6"> 
						<input class="form-control" type="text" id="mddedmedr" name="mddedmedr" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['mddedmedr']?>" <?php }?>/>
					</div>
				
					<label label for="inputEmail" class="col-lg-6 control-label" > <?=ProjetTranslator::mmdde($lang)?>:</label>
					<div class="col-lg-6"> 
						<input class="form-control" type="text" id="mmdde" name="mmdde" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['mmdde']?>" <?php }?>/>
					</div>
				</div>
		
				
					
		<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase6()"><?=ProjetTranslator::precedent($lang)?> </button></li>
					 <li><button class="btn btn-info"onclick="processPhase7()"><?=ProjetTranslator::suivant($lang)?></button></li>
				 </ul>
			
		</fieldset>
		
					
	
		<fieldset id="show_all_data">
				
			
	<legend><?=ProjetTranslator::part($lang)?></legend>
		<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::numerofiche($lang) ?>:</label>
					<div class="col-lg-10">
						<input class="form-control" id="numerofiche" type="text" name="numerofiche" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['numerofiche']?>" <?php }?>/>
					</div>
			
					<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::typeactivite($lang) ?>:</label>
					<div class="col-lg-10">
						<select class="form-control" id="typeactivite" name="typeactivite"  <?=$disabled?>>
							<?php if(isset($Mesdonnees)){ $t=$Mesdonnees['typeactivite'];}?>
							<option <?php if ($t=='--------') echo 'selected'; ?>>--------</option>
							<option  <?php if ($t=='Promotion Partenaires CHU-RENNES') echo 'selected'; ?>>Promotion Partenaires CHU-RENNES</option>
							<option  <?php if ($t=='Promotion Partenaires CRLCC-Inria-UR1') echo 'selected'; ?>>Promotion Partenaires CRLCC-Inria-UR1</option>
							<option <?php if ($t=='Promotions industrielles') echo 'selected';?>>Promotions industrielles</option>
							<option  <?php if ($t=='Promotions institutionnelles Partenaire') echo 'selected'; ?>>Promotions institutionnelles Partenaire</option>
							<option  <?php if ($t=='Promotions institutionnelles non Partenaire') echo 'selected'; ?>>Promotions institutionnelles non Partenaire</option>
							<option  <?php if ($t=='Projets scientifiques-fiche pilote financé') echo 'selected'; ?>>Projets scientifiques-fiche pilote financé</option>
							<option  <?php if ($t=='Projets scientifiques-fiche pilote non financé') echo 'selected'; ?>>Projets scientifiques-fiche pilote non financé</option>
							<option  <?php if ($t=='Projets scientifiques-hors fiche pilote') echo 'selected'; ?>>Projets scientifiques-hors fiche pilote</option>
							<option  <?php if ($t=='Activité clinique') echo 'selected'; ?>>Activité clinique</option>
							<option  <?php if ($t=='Qualité') echo 'selected'; ?>>Qualité</option>
							<option  <?php if ($t=='Formation') echo 'selected'; ?>>Formation</option>
							<option  <?php if ($t=='Visites') echo 'selected'; ?>>Visites</option>
								
						</select> 
						
					</div>
			
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::protocoleinjecte($lang)?>:</label>
				<div class="col-lg-10">
				<?php if (isset($Mesdonnees)){$pi=$Mesdonnees['protocoleinjecte'];}?>
				 <div class="radio">
          			<label>
						<input type="radio" id="protocoleinjecte" name="protocoleinjecte" value="oui"  <?php if ($pi=='oui') echo 'checked="checked"'; ?> > <?= ProjetTranslator::oui($lang)?>
					</label>
				
         			 <label>
						<input type="radio" id="protocoleinjecte" name="protocoleinjecte" value="non"  <?php if ($pi=='non') echo 'checked="checked"'; ?>> <?= ProjetTranslator::non($lang)?>
					</label>
				</div>
				</div>
				<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::numerovisite($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="numerovisite" name="numerovisite" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['numerovisite']?>" <?php }?> >
				</div>
			
			</div>
			<?php if(isset($fina)){
			for($o=0; $o<count($fina); $o++){?>
				<h3><?=ProjetTranslator::typefin($lang)?></h3>
			<div class="form-group ">
				<input type="hidden" name="fin[id][]" value="<?=$fina[$n]['id']?>" />
				<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::soins($lang)?> </label>
				<div class="col-lg-10">
				<?php $tfa=$fina[$o]["soinscourant"]?>
						<div class="radio" >
       					<label>
							<input type="radio" id="soincourant"  name="fin[soinscourant][]" value="oui" <?php if($tfa=="oui") echo 'checked="checked"';?> <?=$diadmin?>/><?=ProjetTranslator::oui($lang)?>
						</label>
					
       					<label>
							<input type="radio" id="soincourant"  name="fin[soinscourant][]" value="non" <?php if ($tfa=='non') echo 'checked="checked"'; ?> <?=$diadmin?>/><?=ProjetTranslator::non($lang)?> 
						</label>
					</div>	
				</div>
				<?php if(isset($Tarif)){?>
			<label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::prix($lang)?>:</label>
			<div class="col-lg-10" >
					<?php $vard = $Tarif;?>
					<?php if(isset($Tarif)){$tar=$fina[$o]['tarif'];}?>
					<select class="form-control"  name="fin[tarif][]" <?=$diadmin?>> 
						<option>----</option>
						<?php foreach($vard as $d){?>
							<option value="<?php echo $d["tarif"];?>  <?=$readonly?> <?php if($tar==$d['tarif']) echo 'selected';?>"> <?php echo $d["tarif"];?></option>
							<?php } ?>  
					    <option value="Autres">Autres</option>
							
						</select>
						
					</div>
				<?php }?>
				<div class="form-group" id="tarif2">
		<label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::entre($lang)?>:</label>
		<div class="col-lg-10">
				<input type="text" class="form-control" id="coutestime" name="tarif2" <?=$readonly?>  />
		</div>
		</div>
				
				<label label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::commenprog($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="comtypefinancement" name="fin[commentaire][]" <?=$ajoutadmin?>  value="<?=$fina[$o]['commentaire']?>"/>
				
				</div>
				</div>
			<?php }
			}?>
			
			<div class="form-group" id="champsfinancement">
			<h3><?=ProjetTranslator::typefin($lang)?></h3>
				<input type="hidden" name="fin[id][]" />
				<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::soins($lang)?> </label>
				<div class="col-lg-10">
						<div class="radio" >
       					<label>
							<input type="radio" id="soincourant"  name="fin[soinscourant][]" value="oui"  <?=$diadmin?>/><?=ProjetTranslator::oui($lang)?>  
						</label>
					
       					<label>
							<input type="radio" id="soincourant"  name="fin[soinscourant][]" value="non" <?=$diadmin?>/><?=ProjetTranslator::non($lang)?> 
						</label>
					</div>	
				</div>
			
		
		<?php if(isset($Tarif)){?>
			<label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::prix($lang)?>:</label>
			<div class="col-lg-10" >
					<?php $vard = $Tarif;?>
				
					<select class="form-control"  name="fin[tarif][]" <?=$diadmin?>> 
						<option>----</option>
						<?php foreach($Tarif as $d){?>
							<option value="<?php echo $d["tarif"];?>"  <?=$readonly?>> </option>
							<?php } ?>  
					    <option value="Autres">Autres</option>
							
						</select>
						
					</div>
				<?php  }?>
				<div class="form-group" id="tarif2">
		<label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::entre($lang)?></label>
		<div class="col-lg-10">
				<input type="text" class="form-control" id="coutestime" name="tarif2" <?=$ajoutadmin?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['coutestime']?>" <?php }?> />
		</div>
		</div>
				
				<label label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::commenprog($lang)?> </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="comtypefinancement" name="fin[commentaire][]" <?=$ajoutadmin?>/>
				
				</div>
				<span id="champsfinancement_2"><a href="javascript:ajouterfinancement(2)"><?=ProjetTranslator::duptyfin($lang)?></a></span>
				</div>
		
			<div class="form-group ">
			
				<h3><?= ProjetTranslator::opg($lang) ?></h3><br/>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::libelle($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="opglibelle" name="opglibelle" placeholder="<?= ProjetTranslator::libelle($lang) ?>" <?=$ajoutadmin?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['opglibelle']?>" <?php }?>>
						
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::contactcores($lang) ?>: </label> 
					<div class="col-lg-10">
						<input type="text" class="form-control" id="opgcoordonnee" name="opgcoordonee" placeholder="<?= ProjetTranslator::nomprenom($lang)?>"  <?=$ajoutadmin?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['opgcoordonee']?>" <?php }?> >
					</div>
				</div>
				
					<h3><?= ProjetTranslator::cstn($lang)?> </h3> 
			
					<label  for="inputEmail" class="col-lg-4 control-label"> <?= ProjetTranslator::nomprenoms($lang) ?>: </label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="cstns" name="cstns" placeholder="Nom et Prénom" <?=$ajoutadmin?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cstns']?>" <?php }?>>
						
					</div>
					<label  for="inputEmail" class="col-lg-4 control-label"> <?= ProjetTranslator::nomprenomt($lang) ?>: </label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="cstnt" name="cstnt" placeholder="Nom et Prénom" <?=$ajoutadmin?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cstnt']?>" <?php }?> >
						
					</div>
				</div>
				<?php if(isset($prgr) and $idform=""){
				for($n=0; $n<count($prgr); $n++){?>
					<div class="form-group">
				<h3>Programmation</h3>
				
					<input class="form-control" type ="hidden" id="id_prog" name="prog[id][]" value="<?=$prgr[$n]['id']?>"/>
				
				
				<label label for="inputEmail" class="col-lg-4 control-label">  <?= ProjetTranslator::inpp($lang)?>: </label>
				<div class="col-lg-8">
					<input class="form-control" type ="text" id="programmation" name="prog[dxplanning][]" <?=$ajoutadmin?> value="<?=$prgr[$n]['dxplanning']?>" />
				
				</div>
				
				<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label>
				<div class="col-lg-10">
						<textarea class="form-control" rows="2" cols="50" name="prog[commentaire][]" <?=$ajoutadmin?>><?php echo $this->clean($prgr[$n]['commentaire']); ?> </textarea>
				</div>
				<label label for="inputEmail" class="col-lg-2 control-label">  Code couleur: </label>
				<div class="col-lg-10">
					<?php if(isset($color)){
					$var= $color; ?>
					
					<select class="form-control" name="prog[codecouleur][]" id="codecouleur" <?=$disabled;?>>
							<option>-----</option>
							<?php foreach($var as $col){?>
							<option value="<?php echo $col["name"];?>" > <?php echo $col["name"];?></option>
							<?php } ?> 
					</select>	
					<?php } ?>			
				</div>
				</div>
				<?php }
				} ?>
				<div class="form-group" id="champsprog">
				<h3>Programmation</h3>
				
			
					<input class="form-control" type ="hidden" id="id_prog" name="prog[id][]" <?=$ajoutadmin?>/>
				
			
				<label label for="inputEmail" class="col-lg-6 control-label">  <?= ProjetTranslator::inpp($lang)?>: </label>
				<div class="col-lg-6">
					<input class="form-control" type ="text" id="programmation" name="prog[dxplanning][]"  <?=$ajoutadmin?>/>
				
				</div>
				
				<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label>
				<div class="col-lg-10">
						<textarea class="form-control" rows="2" cols="50" name="prog[commentaire][]" <?=$ajoutadmin?>> </textarea>
				</div>
				<label label for="inputEmail" class="col-lg-2 control-label">  Code couleur: </label>
				<div class="col-lg-10">
					<?php if(isset($color)){
					$var= $color; ?>
					
					<select class="form-control" name="prog[codecouleur][]" id="codecouleur" <?=$disabled;?>>
							<option>-----</option>
							<?php foreach($var as $col){?>
							<option value="<?php echo $col["name"];?>" > <?php echo $col["name"];?></option>
							<?php } ?> 
					</select>	
					<?php } ?>			
				</div>
				<span id="champsprog_2"><a href="javascript:ajouterprogrammation(2)"><?=ProjetTranslator::dupprog($lang)?></a></span>
				</div>
			<?php if(isset($cota) and $idform!=""){
			for($m; $m<count($cota); $m++){?>
				<div class="form-group">
		<h3><?=ProjetTranslator::cotation($lang)?></h3>
		<input type="hidden" name="cot[id][]" value="<?=$cot[$m]['id']?>"/>
		<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::inppc($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="cotation" name="cot[intitule][]"  <?=$ajoutadmin?>  <?=$readonly?> value="<?=$cota[$m]['intitule']?>" > />
				</div>
				
					<label label for="inputEmail" class="col-lg-2 control-label" ><?=ProjetTranslator::cotation($lang)?>:</label>
					<div class="col-lg-10"> 
					<?php $g=$cota[$m]['facturable'];?>
					<div class="radio" >
       					<label>
							<input type="radio" id="facturable"  name="cot[facturable][]" value="facturable"  <?php if ($g=='facturable') echo 'checked="checked"'; ?> <?=$diadmin?>/><?=ProjetTranslator::facturable($lang)?>    
						</label>
					
       					<label>
							<input type="radio" id="facturable"  name="cot[facturable][]" value="nonfacturable" <?php if ($g=='nonfacturable') echo 'checked="checked"'; ?> <?=$diadmin?>/><?=ProjetTranslator::nnfacturable($lang)?> 
						</label>
					</div>			
						
					</div>
					<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label>
				<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="cot[commentaire][]" <?=$ajoutadmin?>><?php echo $this->clean ($cota[$m]['commentaire']);?></textarea>
				</div>
			
				</div>
			<?php }
			}?>
		<div class="form-group" id="champscotation">
		<h3><?=ProjetTranslator::cotation($lang)?></h3>
		<input type="hidden" name="cot[id][]"/>
		<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::inppc($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="cotation" name="cot[intitule][]"  <?=$ajoutadmin?>/>
				</div>
				
					<label label for="inputEmail" class="col-lg-2 control-label" > <?=ProjetTranslator::cotation($lang)?></label>
					<div class="col-lg-10"> 
					<?php if(isset($Mesdonnees)){$g=$Mesdonnees['facturable'];}?>
					<div class="radio" >
       					<label>
							<input type="radio" id="facturable"  name="cot[facturable][]" value="facturable"  <?php if ($g=='facturable') echo 'checked="checked"'; ?> <?=$diadmin?>/><?=ProjetTranslator::facturable($lang)?>     
						</label>
					
       					<label>
							<input type="radio" id="facturable"  name="cot[facturable][]" value="nonfacturable" <?php if ($g=='nonfacturable') echo 'checked="checked"'; ?> <?=$diadmin?>/><?=ProjetTranslator::nnfacturable($lang)?>    
						</label>
					</div>			
						
					</div>
					<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::commenprog($lang)?>: </label>
				<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="cot[commentaire][]" <?=$ajoutadmin?>>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['ComPro']); }?> </textarea>
				</div>
			<span id="champscotation_2"><a href="javascript:ajoutercotation(2)"><?=ProjetTranslator::dupcot($lang)?></a></span>
				</div>
				<h3><?=ProjetTranslator::sauvdon($lang)?></h3>
			<div class="form-group">
					<label label for="inputEmail" class="col-lg-4 control-label"> <?=ProjetTranslator::gesarchsha($lang)?>:</label>
					<div class="col-lg-8"> 
					<?php if(isset($Mesdonnees)){$g=$Mesdonnees['gamds'];}?>
					<div class="radio">
       					<label>
							<input type="radio" id="gamds"  name="gamds" value="oui" checked="checked"  <?php if ($g=='oui') echo 'checked="checked"'; ?>/><?=ProjetTranslator::oui($lang)?>     
						</label>
					
       					<label>
							<input type="radio" id="gamds"  name="gamds" value="non" <?php if ($g=='non') echo 'checked="checked"'; ?> /><?=ProjetTranslator::non($lang)?>    
						</label>
					</div>			
						
					</div>
					<label label for="inputEmail" class="col-lg-4 control-label"> <?=ProjetTranslator::cdany($lang)?>:</label>
					<div class="col-lg-8"> 
					<?php if(isset($Mesdonnees)){$cdan=$Mesdonnees['cdanonym'];}?>
					<div class="radio">
       					<label>
							<input type="radio" id="cdanonym"  name="cdanonym" value="oui" checked="checked"<?php if ($cdan=='oui') echo 'checked="checked"'; ?>/><?=ProjetTranslator::oui($lang)?>    
						</label>
					
       					<label>
							<input type="radio" id="cdanonym"  name="cdanonym" value="non" <?php if ($cdan=='non') echo 'checked="checked"'; ?> /><?=ProjetTranslator::non($lang)?>   
						</label>
					</div>			
						
					</div>
					<label label for="inputEmail" class="col-lg-4 control-label"><?=ProjetTranslator::cdnom($lang)?>:</label>
					<div class="col-lg-8"> 
					<?php if(isset($Mesdonnees)){$cdn=$Mesdonnees['cdnomin'];}?>
					<div class="radio">
       					<label>
							<input type="radio" id="cdnomin"  name="cdnomin" value="oui" checked="checked" <?php if ($cdn=='oui') echo 'checked="checked"'; ?>/>Oui     
						</label>
					
       					<label>
							<input type="radio" id="cdnomin"  name="cdnomin" value="non" <?php if ($cdn=='non') echo 'checked="checked"'; ?> />Non     
						</label>
					</div>			
						
					</div>
				</div>
				<h3><?=ProjetTranslator::calrea($lang)?></h3>
		<div class="group-form">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::datmise($lang)?>:</label>
					<div class="col-lg-4"> 
					<input class="form-control" type="date" id="miseenplace" name="miseenplace" <?=$diadmin?> <?php if(isset($Mesdonnees)){?>value="<?=$Mesdonnees["miseenplace"] ?>"<?php }?> />
					</div>
					<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::dclot($lang)?></label>
					<div class="col-lg-4"> 
						<input class="form-control" type="date" id="cloture" name="cloture" <?=$diadmin?> <?php if(isset($Mesdonnees)){?>value="<?=$Mesdonnees["cloture"] ?>"<?php }?>/>
					</div>
					<label label for="inputEmail" class="col-lg-2 control-label"> <?=ProjetTranslator::irm($lang)?></label>
					<div class="col-lg-4"> 
						<input class="form-control" type="date" id="irm" name="irm" <?=$diadmin?> <?php if(isset($Mesdonnees)){?>value="<?=$Mesdonnees["irm"] ?>"<?php }?> />
					</div>
					<label label for="inputEmail" class="col-lg-2 control-label"><?=ProjetTranslator::derirm($lang)?></label>
					<div class="col-lg-4"> 
						<input class="form-control" type="date" id="lastirm" name="lastirm" <?=$diadmin?> <?php if(isset($Mesdonnees)){?>value="<?=$Mesdonnees["lastirm"] ?>"<?php }?>/>
					</div>
				
				</div>
				<p> <?=ProjetTranslator::veuill($lang)?></p>
		 		<button class="btn btn-primary" onclick="submitForm()"> <?= ProjetTranslator::enregistrer($lang) ?> </button>
		 		<button class="btn btn-primary" onclick="prviewPhase7()()"><?=ProjetTranslator::retour($lang)?> </button>
		 		<?php if (isset($Mesdonnees) && ($Mesdonnees['idform']!="")){?>
		        <button type="button" onclick="location.href='Projet/Deletefiche/<?=$this->clean($Mesdonnees['idform']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
				<?php }?>
		
		</fieldset>
		
		

</form>
</div> 
</body>	


</html>

<?php include 'Modules/core/View/timepicker_script.php';?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
