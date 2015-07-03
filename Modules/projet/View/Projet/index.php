<?php $this->title = "Fiche-Projet";?>

<?php
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<?php echo $navBar;?>
<?php require_once 'Modules/projet/View/projetnavbar.php';  ?>

<?php 
require_once 'Modules/projet/Model/ProjetTranslator.php';
?>
<?php 
$readonly ="";
$disabled="";

if(!$ModifierFicheProjet){
	$readonly= "readonly";
	$disabled="disabled";
}
?>

<head>

<style>

form#multiphase > #phase2, #phase3, #phase4, #phase5, #phase6, #phase7, #phase8, #phase9, #phase10, #phase11, #phase12, #phase13, #phase14, #phase15,  #show_all_data{ display:none;}

</style>  

	 
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
  					_('leschamps_'+i).innerHTML+= '<fieldset"><legend><?= ProjetTranslator::ip($lang)?></legend><div class="form-group"><input type="hidden" id="id_ip" name="invesp[id_ip][]"/><label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom"><br/></div> <label class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom"/><br/></div><label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service"><br/> </div><label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label> <div class="col-lg-10"><input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email"><br/></div><label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label><div class="col-lg-10"><input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone"></div></fieldset>';
  					_('leschamps_'+i).innerHTML += (i <=40 ) ? '<br /><span id="leschamps_'+i2+'"><a href="javascript:ajouterip('+i2+')">Ajouter un investigateur Principal</a></span>' : '';
  					
  			}
  			function ajouteria(j)
  			{
  			 var j2 = j + 1;
  					_('champsia_'+j).innerHTML+= '<fieldset"><legend><?= ProjetTranslator::ia($lang)?></legend><div class="form-group"><input type="hidden" id="id_ia" name="invesa[id_ia][]"/><label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="iaprenom" name="invesa[iaprenom][]" placeholder="Prénom"><br/></div> <label class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom"/><br/></div><label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label><div class="col-lg-10"><input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service"><br/> </div><label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label> <div class="col-lg-10"><input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email"><br/></div><label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label><div class="col-lg-10"><input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone"></div></fieldset>';
  					_('champsia_'+j).innerHTML += (j <=40 ) ? '<br /><span id="champsia_'+j2+'"><a href="javascript:ajouteria('+j2+')">Ajouter un investigateur AssociE</a></span>' : '';
  					
  			}
  		
  			function calcul()
  			{
  			  var nbr= Number(document.getElementById("nbrexam").value);
  			 
              var dur = Number(document.getElementById("duree").value);

              var dt = Number(nbr* dur);
              document.getElementById("dureetotale").value = dt;
  			}
			function _(x)
			{
				return document.getElementById(x);
			}
			 //script pour les phases
			 

			function processPhase1()
			{
				 var chkZ = 1;
				   for(i=0;i<document.form.numerofiche.value.length;++i)
				     if(document.form.numerofiche.value.charAt(i) < "0"
				     || document.form.numerofiche.value.charAt(i) > "9")
				       chkZ = -1;
				   if(chkZ == -1)
				   {
				     alert("Le Numéro de fiche doit être un nombre!");
				    	return false;
				    }
				
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
				_("progressBar").value =6.6;
				_("status").innerHTML ="Etape 2 de 15 ";
                 }
                 window.scrollTo(0,0)
				
			}
			
				function prviewPhase1()
				{
		 			_("phase1").style.display= "block";
					_("phase2").style.display= "none";
					window.scrollTo(0,0)
				}
	
			function processPhase2()
			{
				 _("phase2").style.display ="none";
				 _("phase3").style.display ="block";
				 _("progressBar").value =13.2;
				 _("status").innerHTML ="Etape 3 de 15 ";
				 window.scrollTo(0,0)
				
			}
				function prviewPhase2()
				{  
					_("phase2").style.display= "block";
					_("phase3").style.display= "none";
					_("progressBar").value =6.6;
					_("status").innerHTML ="Etape 1 de 15 ";
					window.scrollTo(0,0)
				}
			function processPhase3()
			{
				 _("phase3").style.display ="none";
				 _("phase4").style.display ="block";
				 _("progressBar").value =19.8;
				 _("status").innerHTML ="Etape 4 de 15 ";
				 window.scrollTo(0,0)
					
			}
				function prviewPhase3()
				{
		  			_("phase3").style.display= "block";
					_("phase4").style.display= "none";
			 		_("progressBar").value =13.2;
					_("status").innerHTML ="Etape 3 de 15 ";
					window.scrollTo(0,0)
				}
				
			function processPhase4()
			{
				_("phase4").style.display ="none";
				_("phase5").style.display ="block";
				_("progressBar").value =26.4;
				_("status").innerHTML ="Etape 5 de 15 ";
				window.scrollTo(0,0)
					
			}
				 function prviewPhase4()
				 {
					_("phase4").style.display= "block";
					_("phase5").style.display= "none";
					_("progressBar").value =19.8;
					_("status").innerHTML ="Etape 4 de 15 ";
					window.scrollTo(0,0)
				
				}
		
			function processPhase5()
			{
				 var radionac = document.getElementsByName("nac"); 
				 var checked = false; 
                 for (var cpt = 0 ; (cpt < radionac.length) && !checked ; cpt++) { 
                 checked = checked || radionac[cpt].checked; 
                 window.scrollTo(0,0)
                 } 
                 

                 if (!checked) { 
                 alert("Attention Vous n'avez rien selectioné"); 
                 } 
                 else{
				 _("phase5").style.display ="none";
				 _("phase6").style.display ="block";
				 _("progressBar").value =33;
				 _("status").innerHTML ="Etape 6 de 15 ";}
                 window.scrollTo(0,0)
			}
				function prviewPhase5()
				{
					_("phase5").style.display ="block";
					_("phase6").style.display ="none";
					_("progressBar").value =26.4;
					_("status").innerHTML ="Etape 5 de 15 ";
					window.scrollTo(0,0)	
				}
				
		   function processPhase6()
		   {
				_("phase6").style.display ="none";
			    _("phase7").style.display ="block";
			    _("progressBar").value =39.6;
			    _("status").innerHTML ="Etape 7 de 15 ";
			    window.scrollTo(0,0)
		   }
		
		   		function prviewPhase6()
		   		{
				 _("phase6").style.display ="block";
				 _("phase7").style.display ="none";
				 _("progressBar").value =33;
				 _("status").innerHTML ="Etape 6 de 15 ";
				 window.scrollTo(0,0)
				}
		 function processPhase7()
		 {
			 _("phase7").style.display ="none";
			 _("phase8").style.display ="block";
			 _("progressBar").value =46;
			 _("status").innerHTML ="Etape 8 de 15 ";
			 window.scrollTo(0,0)
		}
			    function prviewPhase7()
			    {
				    _("phase7").style.display ="block";
				    _("phase8").style.display ="none";
				    _("progressBar").value =39.6;
				    _("status").innerHTML ="Etape 7 de 15";
				    window.scrollTo(0,0)
				}
		function processPhase8()
		{
			_("phase8").style.display ="none";
			_("phase9").style.display ="block";
			_("progressBar").value =52.8;
			_("status").innerHTML ="Etape 9 de 15 ";
			window.scrollTo(0,0)
		}
				function prviewPhase8()
				{
					 _("phase8").style.display ="block";
				 	 _("phase9").style.display ="none";
				 	 _("progressBar").value =46;
					 _("status").innerHTML ="Etape 8 de 15";
					 window.scrollTo(0,0)
				}
		function processPhase9()
		{
			 var radioCPP = document.getElementsByName("cpp"); 
			 var checked = false; 
             for (var cpt = 0 ; (cpt < radioCPP.length) && !checked ; cpt++) { 
             checked = checked || radioCPP[cpt].checked; 
             } 
             

             if (!checked) { 
             alert("Attention le champs CPP n'est pas coché"); 
             } else{
			_("phase9").style.display ="none";
			_("phase10").style.display ="block";
			_("progressBar").value =59.4;
			_("status").innerHTML ="Etape 10 de 15 ";}
             window.scrollTo(0,0)
		}
			function prviewPhase9()
			{
				 _("phase9").style.display ="block";
				 _("phase10").style.display ="none";
				 _("progressBar").value =52.8;
				 _("status").innerHTML ="Etape 9 de 15 ";
				 window.scrollTo(0,0)
			}
	    function processPhase10()
	    {
		     _("phase10").style.display ="none";
			 _("phase11").style.display ="block";
			 _("progressBar").value =66;
			 _("status").innerHTML ="Etape 11 de 15 ";
			 window.scrollTo(0,0)
		}
			function prviewPhase10()
			{
				_("phase10").style.display ="block";
				_("phase11").style.display ="none";
				_("progressBar").value =59.4;
				_("status").innerHTML ="Etape 10 de 15  ";
				window.scrollTo(0,0)
			}
	   function processPhase11()
	   {	
		 var radioProIn = document.getElementsByName("protocoleinjecte"); 
		 var checked = false; 
         for (var cpt = 0 ; (cpt < radioProIn.length) && !checked ; cpt++) { 
         checked = checked || radioProIn[cpt].checked; 
         } 
         

         if (!checked) { 
         alert("Attention Vous n'avez pas coché un champs"); 
         } else{
		    _("phase11").style.display ="none";
			_("phase12").style.display ="block";
			_("progressBar").value =72.6;
			_("status").innerHTML ="Etape 12 de 15  ";}
         window.scrollTo(0,0)
		}
		
			function prviewPhase11()
			{
				 _("phase11").style.display ="block";
				 _("phase12").style.display ="none";
				 _("progressBar").value =66;
				 _("status").innerHTML ="Etape 12 de 15  ";
				 window.scrollTo(0,0)	
			}
		function processPhase12()
		{
			_("phase12").style.display ="none";
			_("phase13").style.display ="block";
		    _("progressBar").value =79.2;
			_("status").innerHTML ="Etape 13 de 15 ";
			window.scrollTo(0,0)
		}
			function prviewPhase12()
			{
				_("phase12").style.display ="block";
				_("phase13").style.display ="none";
				_("progressBar").value =72.6;
				_("status").innerHTML ="Etape 12 de 15 ";
				window.scrollTo(0,0)	
			}
		function processPhase13()
		{
			 var radiogamds = document.getElementsByName("gamds"); 
			 var checked = false; 
	         for (var cpt = 0 ; (cpt < radiogamds.length) && !checked ; cpt++) { 
	         checked = checked || radiogamds[cpt].checked; 
	         } 
	         

	         if (!checked) { 
	         alert("Attention Vous n'avez pas coché un champs"); 
	         } else{
			_("phase13").style.display ="none";
			_("phase14").style.display ="block";
			_("progressBar").value =85.8;
			_("status").innerHTML ="Etape 14 de 15 ";
	         }
	         window.scrollTo(0,0)
	 		}
			function prviewPhase13()
			{
				_("phase13").style.display ="block";
				_("phase14").style.display ="none";
				_("progressBar").value =79.2;
				_("status").innerHTML ="Etape 13 de 15  ";
				window.scrollTo(0,0)	
			}
		function processPhase14()
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
			_("phase14").style.display ="none";
			_("phase15").style.display ="block";
			_("progressBar").value =92.4;
			_("status").innerHTML ="Etape 15 de 15  ";
			window.scrollTo(0,0)	
		}
				function prviewPhase14()
				{
					
					_("phase14").style.display ="block";
					_("phase15").style.display ="none";
					_("progressBar").value =85.8;
					_("status").innerHTML ="Etape 14 de 15  ";
					window.scrollTo(0,0)
				}
		function processPhase15()
		{
			
			_("phase15").style.display ="none";
			_("show_all_data").style.display="block";
			_("progressBar").value =100;
		    _("status").innerHTML ="Data overview ";
		    window.scrollTo(0,0)		
		}
		function prviewPhase15()
		{
			
			_("phase15").style.display ="block";
			_("show_all_data").style.display ="none";
			_("progressBar").value =92.4;
			_("status").innerHTML ="Phase 15 of 15 ";
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

<div class="container">
	<div id="header"> 
		<h1>
			<?= ProjetTranslator::formulaireProjet($lang) ?>
			<br> <small></small>
		</h1> 
	 
   	</div>
<body>

	<div class="progress progress-striped active">
  		<div  class="progress-bar" style="width: 45%"></div>
	</div>
	<progress id="progressBar" value="0" max ="100" style="width:515px;"> </progress>
	
	<div id="status"  class="well well-sm">
  	    Etape 1 de 15
  </div>
	
<form  enctype='multipart/form-data' id="multiphase" name="form" onsubmit="return false"  class="form-horizontal">
<input class="form-control" id="idform" type="hidden" name="idform" />
	<fieldset id="phase1">
		<legend>Projet</legend>
			<?php if (isset($Mesdonnees)  && $numerofiche!=""){
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
			  	<label label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::datedemande($lang) ?> :</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="datedemande" type="date" name="datedemande" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['datedemande']?>" <?php }?> />
					</div>
			</div>
					<br/>
					   <div class="form-group"> 
			<label for="inputEmail" class="col-lg-2 control-label">Rempli par:</label>
				<div class="col-xs-10">
					<?php //pour le nom de l'utilisateur
					//verfier si l'utilisateur est un admin 
						$allowedBookForOther = true;
						if ( $this->clean($curentuser['id_status']) < 3){
						$allowedBookForOther = false;
						}
						$recipientID = 0;
					if(isset($Mesdonnees)){
						//verifie si les données sont envoyés si oui on prend l'id de l'utilisateur 
						$recipientID = $this->clean($Mesdonnees["idutil"]);
					}
					if ($allowedBookForOther==false && isset($Mesdonnees) && $recipientID != $this->clean($curentuser['id'])){
						//si ce n'est pas un administrateur et si les données sont envoyées et si l'utilisateur change alors affichage sans modification
						?>
						<select class="form-control" name="utilisateur" disabled="disabled">
						<?php
							foreach ($users as $user){
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $recipientID){
									?>
									<OPTION value="<?= $userId ?>"> <?= $userName?> </OPTION>
									<?php
								} 
							}?>
						</select>
						
						<?php } else{
					?>
					
					<select class="form-control" name="utilisateur">
						<?php
						if ($allowedBookForOther){
							$recipientID = $this->clean($Mesdonnees["idutil"]);
							if ($recipientID == "" && $recipientID == 0){
								$recipientID = $this->clean($curentuser['id']); 
							} 
							foreach ($users as $user){
								$userId = $this->clean($user['id']);
								$userName = $this->clean($user['name']) . " " . $this->clean($user['firstname']);
								$selected = "";
								if ($userId == $recipientID){
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
		</div>
					
				<div class="form-group">
					<label label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::numerofiche($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="numerofiche" type="text" name="numerofiche" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['numerofiche']?>" <?php }?>/>
					</div>
				</div> 
					<br/>
				<div class="form-group">
				<?php if (isset($Mesdonnees)){$d=$Mesdonnees['type']; }?>
					<label for="type" class="col-lg-2 control-label"><?= ProjetTranslator::type($lang) ?>:</label><br/>
					 <div class="col-lg-10">
       					<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Pilote" <?=$readonly?>  <?php if ($d=='Pilote') echo 'checked="checked"'; ?> ><?= ProjetTranslator::pilote($lang) ?>    
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Méthodologique" <?=$readonly?><?php if ($d=='Méthodologique') echo 'checked="checked"'; ?>> <?= ProjetTranslator::methodo($lang) ?>
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Recherche Clinique"  <?=$readonly?> <?php if ($d=='Recherche Clinique') echo 'checked="checked"'; ?>><?= ProjetTranslator::rechercheclini($lang) ?> 
							</label>
						</div>
						<div class="radio">
       						<label>
								<input type="radio" id="type"  name="type" value="Multicentrique" <?=$readonly?> <?php if ($d=='Multicentrique') echo 'checked="checked"'; ?>><?= ProjetTranslator::multicen($lang) ?> 
							</label>
						</div>
					
					</div>
				</div>
					<br/>
				<div class="form-group">
					<label for="Titre" class="col-lg-2 control-label"><?= ProjetTranslator::titre($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<input class="form-control" id="titre" type="text" name="titre" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['titre']?>" <?php }?>/>
					</div>
				</div>
				
					<br/>
					<br/>
				<div class="form-group">
					<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::Acronyme($lang)?>:</label><br/>
					<div class="col-lg-10" >
						<input class="form-control" id="acronyme" type="text" name="acronyme" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['acronyme']?>" <?php }?>/>	
					</div>
				<br/>
				</div>
				<br/>
				<div class="form-group">
					<label for="select" class="col-lg-2 control-label"><?= ProjetTranslator::typeactivite($lang) ?>:</label><br/>
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
					</div>
					<br/>
					
				<br/>
				<button class="btn btn-primary"onclick="processPhase1()" class="btn btn-primary">Continuer </button>
		</fieldset>
		<br/>
		
		<fieldset id="phase2">
			<?php  if(isset($invP) && $numerofiche!=""){
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
					<br/>
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom" <?=$readonly?> value="<?=$invP[$i]['ipprenom']?>" > 
							<br/>
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom" <?=$readonly?>  value="<?=$invP[$i]['ipnom']?>" >
							<br/>
						</div>
						<br/>
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service" <?=$readonly?> value="<?=$invP[$i]['ipfonction']?>" >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email" <?=$readonly?>  value="<?=$invP[$i]['ipmail']?>">
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone" <?=$readonly?> value="<?=$invP[$i]['iptel']?>">
						</div>
								
				</div>
				
					
					<br/><?php }}?>
					<div id="leschamps">
		
					<legend><?= ProjetTranslator::ip($lang) ?></legend>
					<div class="form-group">
					<input type="hidden" name="invesp[id_ip][]" id="id_ip"/>
					
					<br/>
					
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipprenom" name="invesp[ipprenom][]" placeholder="Prénom" <?=$readonly?>  > 
							<br/>
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipnom" name="invesp[ipnom][]" placeholder="Nom" <?=$readonly?> >
							<br/>
						</div>
						<br/>
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipfonction" name="invesp[ipfonction][]" placeholder="Fonction, Service" <?=$readonly?>  >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ipmail" name="invesp[ipmail][]" placeholder="Email" <?=$readonly?> >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iptel" name="invesp[iptel][]" placeholder="Téléphone" <?=$readonly?> >
						</div>
								
				</div>
				
					<span id="leschamps_2"><a href="javascript:ajouterip(2)">Ajouter un investigateur Principal</a></span>
					</div>	
					<br/>
					
			<ul class="pager">
			
 					 <li><button class="btn btn-info"onclick="prviewPhase1()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase2()">Suivant</button></li>
				 </ul>
		</fieldset>
		<fieldset id="phase3">
			<?php  if(isset($invA) && $numerofiche!=""){
		for($k=0; $k<count($invA); $k++){
			
			 ?>
		
			<legend><?= ProjetTranslator::ia($lang) ?></legend>
			<div class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">ID</label>
				<div class="col-lg-10">
				<input class="form-control" id="id_ia" type="text"  name="invesp[id_ia][]"  value="<?=$this->clean($invA[$k]['id_ia']) ?>" readonly/>
				</div>
					</div>
					<div class="form-group">
					<br/>
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iaprenom" name="invesa[iaprenom][]" placeholder="Prénom" <?=$readonly?> value="<?=$invA[$k]['iaprenom']?>" > 
							<br/>
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom" <?=$readonly?>  value="<?=$invA[$k]['ianom']?>" >
							<br/>
						</div>
						<br/>
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service" <?=$readonly?> value="<?=$invA[$k]['iafonction']?>" >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email" <?=$readonly?>  value="<?=$invA[$k]['iamail']?>">
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone" <?=$readonly?> value="<?=$invA[$k]['iatel']?>">
						</div>
								
				</div>
				
					
					<br/><?php }}?>
					<div id="champsia">
		
					<legend><?= ProjetTranslator::ia($lang) ?></legend>
					<div class="form-group">
				<input type="hidden" name="invesa[id_ia][]" id="id_ia"  />
					
					<br/>
						<label  for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iparenom" name="invesa[iaprenom][]" placeholder="Prénom" <?=$readonly?>  > 
							<br/>
						</div>
						<label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator::nom($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="ianom" name="invesa[ianom][]" placeholder="Nom" <?=$readonly?>   >
							<br/>
						</div>
						<br/>
						<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iafonction" name="invesa[iafonction][]" placeholder="Fonction, Service" <?=$readonly?>  >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iamail" name="invesa[iamail][]" placeholder="Email" <?=$readonly?> >
							<br/>
						</div>
						<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>:</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="iatel" name="invesa[iatel][]" placeholder="Téléphone" <?=$readonly?> >
						</div>
								
				</div>
				
					<span id="champsia_2"><a href="javascript:ajouteria(2)">Ajouter un investigateur Associé</a></span>
					</div>	
					<br/>
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase2()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase3()">Suivant</button></li>
				 </ul>
		</fieldset>
		
		<br/>
		
			
		  <br/>
			
		<fieldset id="phase4">
			<legend><?= ProjetTranslator::coord($lang) ?></legend>
				<div class="form-group">
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::prenom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cprenom" name="cprenom" placeholder="Prénom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cprenom']?>" <?php }?>> 
						<br/>
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::nom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cnom" name="cnom" placeholder="Nom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cnom']?>" <?php }?>>
						<br/>
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cfonction" name="cfonction" placeholder="Fonction, Service" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cfonction']?>" <?php }?>>
						<br/>
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::mail($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cmail" name="cmail" placeholder="Email" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cmail']?>" <?php }?>>
					<br/>
					</div>
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::tel($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="ctel" name="ctel" placeholder="Téléphone" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['ctel']?>" <?php }?>>
					</div>
				</div>
				<br/>
		
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase3()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase4()">Suivant</button></li>
				 </ul>
				
			
			<br/>
		</fieldset>
		<br/>
		
		
		<fieldset id='phase5'>
        	<legend>Promoteur</legend>
        		<div class="form-group">
        		<label class="col-lg-2 control-label">Nom et Prénom: </label>
            		<div class="col-lg-10" >
						<input type="text" class="form-control"   id="promoteur" name="promoteur" placeholder="Promoteur" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['promoteur']?>" <?php }?>/>
					</div>
				</div>
				<br/>
				<div class="form-group">
					<label class="col-lg-2 control-label">Commentaire: </label>
					<div class="col-lg-10" >
						<input type="text" class="form-control"   id="infos" name="infos" placeholder="Infos Complémentaire" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['infos']?>" <?php }?>/>
					</div>
				</div>	
				<div class="form-group">
						<label for="select" class="col-lg-2 control-label">Choisissez:</label><br/>
						<div class="col-lg-10" >
						<?php if (isset($Mesdonnees) ){$n= $Mesdonnees['nac']; }?>
							<input type="radio" id="type"  name="nac" value="Neuro" <?php if ($n=='Neuro'){echo 'checked=ckecked';}?> / >Neuro     
							<input type="radio" id="type"  name="nac" value="Abdo"  <?php if ($n=='Abdo') echo 'checked="checked"'; ?>/> Abdo
							<input type="radio" id="type"  name="nac" value="Cardio"  <?php if ($n=='Cardio') echo 'checked="checked"'; ?>/>Cardio
						</div>
						<br/>
					</div>
				
				<br/>	
	            <ul class="pager">
 					 <li><button class="btn btn-info" onclick="prviewPhase4()">Précédent </button></li>
					 <li><button class="btn btn-info" onclick="processPhase5()">Suivant</button></li>
				 </ul>
        </fieldset>
	
		
		<br/>
		<fieldset id="phase6">
			<legend>CRO</legend><br/>
				<div class="form-group">
					<label class="col-lg-2 control-label"><?= ProjetTranslator::libelle($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="crolibelle" name="crolibelle" placeholder="<?= ProjetTranslator::libelle($lang) ?>" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['crolibelle']?>" <?php }?>>
						<br/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::cri($lang) ?>: </label> <br/>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="cri" name="cri" placeholder="<?= ProjetTranslator::cri($lang) ?>" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cri']?>" <?php }?> >
					</div>
				</div>
				
				<br/><br/>
				<div class="alert alert-dismissible alert-info">
  			<button type="button" class="close" data-dismiss="alert">×</button>
  				<strong>Infos</strong>  <br/> CRO: Centre d'organisation et de recherche.
			</div>
			<h3><?= ProjetTranslator::opg($lang) ?></h3><br/>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::libelle($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="opglibelle" name="opglibelle" placeholder="<?= ProjetTranslator::libelle($lang) ?>" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['opglibelle']?>" <?php }?>>
						<br/>
					</div>
					<label class="col-lg-4 control-label"> <?= ProjetTranslator::contactcores($lang) ?>: </label> 
					<div class="col-lg-8">
						<input type="text" class="form-control" id="opgcoordonnee" name="opgcoordonee" placeholder="<?= ProjetTranslator::nomprenom($lang)?>"  <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['opgcoordonee']?>" <?php }?> >
					</div>
				</div>
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase5()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase6()">Suivant</button></li>
		</ul>	
		</fieldset >
		<br/><br/> <br/>
		
		<fieldset id="phase7">
		<legend><?= ProjetTranslator::arc($lang) ?>:</legend>
				<div class="form-group">
					<label class="col-lg-2 control-label"> <?= ProjetTranslator::prenom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="arcprenom" name="arcprenom" placeholder="Prénom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['arcprenom']?>" <?php }?>>
						<br/>
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::nom($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="arcnom" name="arcnom" placeholder="Nom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['arcnom']?>" <?php }?>>
						<br/>
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::fonction($lang) ?>: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="arcfonction" name="arcfonction" placeholder="Fonction, Service" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['arcfonction']?>" <?php }?>>
					<br/>
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::mail($lang) ?>: </label>
					<div class="col-lg-10">
					<input type="text" class="form-control" id="arcmail" name="arcmail" placeholder="Email" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['arcmail']?>" <?php }?>>
					<br/>
					</div>
					<label class="col-lg-2 control-label">  <?= ProjetTranslator::tel($lang) ?>: </label>
					<div class="col-lg-10">
					<input type="text" class="form-control" id="arctel" name="arctel" placeholder="Téléphone" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['arctel']?>" <?php }?>>
					</div>
				</div>
			
		<br/>
		<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase6()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase7()">Suivant</button></li>
				 </ul>
			
		</fieldset>
		<br/>
		
		<fieldset id="phase8">
				<legend><?= ProjetTranslator::rsre($lang) ?></legend>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?= ProjetTranslator::nomprenom($lang) ?>: </label>
				<div class="col-lg-8">
					<input type="text" class="form-control" id="rsre" name="rsre" placeholder="Nom et Prénom" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rsre']?>" <?php }?>>
					<br/>
				</div>
			</div>	
			<br/>
				<div class="form-group">
			<label  for="inputEmail" class="col-lg-10 control-label"><?= ProjetTranslator::cstn($lang)?> </label> <br/></div>
			<div class="form-group">
					<label  for="inputEmail" class="col-lg-4 control-label"> <?= ProjetTranslator::nomprenoms($lang) ?>: </label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="cstns" name="cstns" placeholder="Nom et Prénom" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cstns']?>" <?php }?>>
						<br/>
					</div>
				</div>
				<br/>
		
				<div class="form-group">
			
					<label  for="inputEmail" class="col-lg-4 control-label"> <?= ProjetTranslator::nomprenomt($lang) ?>: </label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="cstnt" name="cstnt" placeholder="Nom et Prénom" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cstnt']?>" <?php }?> >
						<br/>
					</div>
				</div>
	 <br/>
	 		
				<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase7()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase8()">Suivant</button></li>
				 </ul>	
		</fieldset>
		<br/>
		
		<fieldset id="phase9">
		
				<legend><?= ProjetTranslator::cpp($lang) ?></legend>
				<div class="form-group">
					<div class="col-lg-10">
					<?php if(isset($Mesdonnees)){$c=$Mesdonnees['cpp'];}?>
					<div class="radio">
         				 <label>
							<input type="radio" id="cpp"  name="cpp" value="A soumettre"  <?php if ($c=='A soumettre') echo 'checked="checked"'; ?>/><?= ProjetTranslator::soumettre($lang) ?>
						</label>
						</div>
					<div class="radio">
         				 <label>
						<input type="radio" id="cpp"  name="cpp" value="Soumis"  <?php if ($c=='Soumis') echo 'checked="checked"'; ?>/><?= ProjetTranslator::soumis($lang) ?>
						</label>
					</div>
					<div class="radio">
         				 <label>	
						<input type="radio" id="cpp"  name="cpp" value="Accepté"  <?php if ($c=='Accepté') echo 'checked="checked"'; ?>/><?= ProjetTranslator::accepte($lang) ?>
					</label>
					</div>
					<br/>
					</div>
					<br/>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label"><?= ProjetTranslator::cppnumero($lang) ?>:</label>
					<div class="col-lg-10">
						<input type="text"  class="form-control" name="cppnumero" id="cppnumero" placeholder="CPP Numéro" <?=$readonly?>/ <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cppnumero']?>" <?php }?>>
					</div>
	
				</div>
			<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase8()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase9()">Suivant</button></li>
				 </ul>
				
		</fieldset>
		<br/>
		
		<fieldset id="phase10">
		<legend><?= ProjetTranslator::descriptionetude($lang) ?></legend>
				<div class="form-group">
					<label for="textArea" class="col-lg-2 control-label"><?= ProjetTranslator::resume($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="20" cols="50" name="resume" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['resume']); }?> </textarea>
					</div>
				</div>
				<br/>
				<div class="form-group">
					<label for="Objectif" class="col-lg-2 control-label"><?= ProjetTranslator::objectif($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="objectif" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['objectif']); }?> </textarea>
					</div>
				</div>
				<br/>
				<div class="form-group">
					<label for="Expérimentation" class="col-lg-2 control-label" ><?= ProjetTranslator::experimentation($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="10" cols="50" name="experimentation" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['experimentation']); }?> </textarea>
					</div>
				</div>
				<br/>
				<div class="form-group">
					<label for="" class="col-lg-2 control-label" >Protocole d'imagerie:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="protocolimagerie" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['protocolimagerie']); }?> </textarea>
					</div>
					</div>
					<br/>
				<div class="form-group">
					<label for="Traitement des données" class="col-lg-2 control-label" ><?= ProjetTranslator::traitementdonnee($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="traitementdonnee" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['traitementdonnee']); }?> </textarea>
					</div>
					</div>
					<br/>
				<div class="form-group">
					<label for="Résultats attendus" class="col-lg-2 control-label"><?= ProjetTranslator::resultatattendu($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea  class="form-control" rows="4" cols="50" name="resultatattendu" <?=$readonly?>><?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['resultatattendu']); }?> </textarea>
					</div> 
					</div>
					<br/>
				<div class="form-group">
					<label for="Publications envisagées" class="col-lg-2 control-label"><?= ProjetTranslator::publicationenvisage($lang) ?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="publicationenvisage" <?=$readonly?>> <?php if (isset($Mesdonnees)){echo $this->clean($Mesdonnees['publicationenvisage']);}?> </textarea>
					</div>
				</div>
				<br/>
			   <div class="form-group">
					<label for="Mots-clés" class="col-lg-2 control-label"><?= ProjetTranslator::motcle($lang)?>:</label><br/>
					<div class="col-lg-10">
						<textarea class="form-control" rows="4" cols="50" name="motcle" <?=$readonly?>><?php if (isset($Mesdonnees)){ echo $this->clean($Mesdonnees['motcle']); }?> </textarea>
					</div>
			   </div>
		<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase9()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase10()">Suivant</button></li>
				 </ul>
		</fieldset>
		<br/>
		<fieldset id="phase11">
			<legend><?= ProjetTranslator::perpn($lang)?></legend>
				<div class="form-group ">
					<h3> <?= ProjetTranslator::tnsp($lang)?></h3><br/>
		   			<label class="col-lg-2 control-label"> <?= ProjetTranslator::temoins($lang)?>: </label> 
					<div class="col-lg-10">
						<input class="form-control" type="text" id="temoins" name="temoins" <?=$readonly?>/>
					</div>
					<label class="col-lg-2 control-label" > <?= ProjetTranslator::patient($lang)?>:</label>
					<div class="col-lg-10">
						<input class="form-control" type ="text" id="patient" name="patient" <?=$readonly?> /> 
					</div>
					<label class="col-lg-2 control-label"> <?=ProjetTranslator::fantome($lang)?>:</label>
					<div class="col-lg-10">
						<input  class="form-control" type="text" id="fontome" name="fantome" <?=$readonly?>/>
		    		</div>
		   		</div>
		  	 <br/>
		  	 <h3> Protocole</h3>
		 	<div class="form-group ">
				<label for="Responsable de recrutement" class="col-lg-2 control-label"><?=ProjetTranslator::responsablerecrutement($lang)?>:</label><br/>
				<div class="col-lg-10">
		    		<input type='text' class="form-control" name="responsablerecru" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['responsablerecru']?>" <?php }?>/>
				</div>
			</div>
	    	<br/>
	    	<div  class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::protocoleinjecte($lang)?>:</label>
				<div class="col-lg-10">
				<?php if (isset($Mesdonnees)){$pi=$Mesdonnees['protocoleinjecte'];}?>
				 <div class="radio">
          			<label>
						<input type="radio" id="protocoleinjecte" name="protocoleinjecte" value="oui"  <?php if ($pi=='oui') echo 'checked="checked"'; ?> > <?= ProjetTranslator::oui($lang)?>
					</label>
				</div>
				 <div class="radio">
         			 <label>
						<input type="radio" id="protocoleinjecte" name="protocoleinjecte" value="non"  <?php if ($pi=='non') echo 'checked="checked"'; ?>> <?= ProjetTranslator::non($lang)?>
					</label>
				</div>
				</div>
			</div>
			<br/> 
			
	    	
			<div  class="form-group " name="cj">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::nombredexam($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="nbrexam" onblur="calcul()" name="nbrexam" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['nbrexam']?>" <?php }?> >
				</div>
			
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::dureeexam($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="duree" onblur="calcul()" name="duree"  <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['duree']?>" <?php }?>>
				</div>
			
		
			
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::dureetotale($lang)?> :</label>
				<div class="col-lg-10">
				
					<input class="form-control" type="text"  id="dureetotale" onblur="calcul()" name="dureetotale" value="" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['dureetotale']?>" <?php }?>>
				</div>
			</div>
			<br/> 
			<div class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator::planificationprevisinnelle($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="planification" name="planification"  <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['planification']?>" <?php }?> >
				</div>
			</div>
			<br/>
			<div  class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> Numéro de visite: </label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="numerovisite" name="numerovisite" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['numerovisite']?>" <?php }?> >
				</div>
			</div>
			<br/>
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
				<div class="col-lg-10">
					<input class="form-control" type="date" id="datedemarage" name="datedemarage" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['datedemarage']?>" <?php }?>>
				</div>
			</div>
			<br/>
			<div class="form-group " > 
				<label label for="inputEmail" class="col-lg-2 control-label"><?= ProjetTranslator:: dureeetudeprevu($lang)?>:</label>
				<div class="col-lg-10">
					<input class="form-control" type="text" id="dureeetude" name="dureeetude" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['dureeetude']?>" <?php }?>>
				</div>
			</div>
			<br/>
			<div class="form-group ">
				<label label for="inputEmail" class="col-lg-2 control-label"> <?= ProjetTranslator:: contraint($lang)?>:</label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="contrainte" name="contrainte" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['contrainte']?>" <?php }?>>		
					</div>
				</div>
		<br/>
				<br/>
				<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase10()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase11()">Suivant</button></li>
				 </ul>
			
		</fieldset>
		<br/>
		
		<fieldset id="phase12">
			<legend><?= ProjetTranslator::progcota($lang)?></legend>
			<div class="form-group ">
				<br/>
				<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::inpp($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="programmation" name="programmation" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['programmation']?>" <?php }?>>
				<br/>
				</div>
			</div>
				<br/>
			<div class="form-group ">
			<br/>
				<label label for="inputEmail" class="col-lg-2 control-label">  <?= ProjetTranslator::inppc($lang)?>: </label>
				<div class="col-lg-10">
					<input class="form-control" type ="text" id="cotation" name="cotation" <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cotation']?>" <?php }?>/>
				<br>
				</div>
			</div>
		
			<div class="form-group ">
			<br/>
				<label label for="inputEmail" class="col-lg-2 control-label">  Code couleur: </label>
				<div class="col-lg-10">
					<?php if(isset($color)){
					$var= $color; ?>
					
					<select class="form-control" name="codecouleur" id="codecouleur" <?=$disabled;?>>
							<option>-----</option>
							<?php foreach($var as $col){?>
							<option value="<?php echo $col["name"];?>" > <?php echo $col["name"];?></option>
							<?php } ?> 
					</select>	
					<?php } ?>			
				</div>
				
			</div>
				
			
		<br/>
		
				<br/>
				<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase11()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase12()">Suivant</button></li>
				 </ul>
					
		</fieldset>
		<br/>
		
		<fieldset id="phase13">
				<legend>Besoins spécifique / ressources</legend>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Ressources humaines logicielles et matérielles externes:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="rhlme" name="rhlme" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rhlme']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Ressources humaines logicielles et matérielles Neurinfo:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="rhlmn" name="rhlmn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['rhlmn']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Aide à l'exploitation des données, support méthodologique:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="aedsm" name="aedsm" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['aedsm']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Gestion archivage mode de sauvegarde Shanoir:</label>
					<div class="col-lg-10"> 
					<?php if(isset($Mesdonnees)){$g=$Mesdonnees['gamds'];}?>
					<div class="radio">
       					<label>
							<input type="radio" id="gamds"  name="gamds" value="oui"  <?php if ($g=='oui') echo 'checked="checked"'; ?>/>Oui     
						</label>
					</div>	
					<div class="radio">
       					<label>
							<input type="radio" id="gamds"  name="gamds" value="non" <?php if ($g=='non') echo 'checked="checked"'; ?> />Non     
						</label>
					</div>			
						
					</div>
				</div>
				<br/>
		<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase12()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase13()">Suivant</button></li>
				 </ul>
			
	</fieldset>
	
	<fieldset id="phase14">

		<legend>Plateforme Neurinfo</legend>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Adéquation aux objectifs de Neurinfo:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="aaodn" name="aaodn" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['aaodn']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Caractère structurant pour Neurinfo:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="cspn" name="cspn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['cspn']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label">Nature de la contribution de Neurinfo:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="ndlcdn" name="ndlcdn" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['ndlcdn']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label"> Capacité d'autofinancement:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="caf" name="caf" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['caf']?>" <?php }?>/>
					</div>
				</div>
				<br/>
		
		
				<br/>
				<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase13()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase14()">Suivant</button></li>
				 </ul>
				
		</fieldset>
		<br/>
		<fieldset id="phase15">
		<legend> Plan de dissémination</legend>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label" > Mode de diffusion envisagé des méthodes et des résultats:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="mddedmedr" name="mddedmedr" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['mddedmedr']?>" <?php }?>/>
					</div>
				</div>
				<div class="form-group">
					<label label for="inputEmail" class="col-lg-2 control-label" > Mode de mise à disposition des données envisagés:</label>
					<div class="col-lg-10"> 
						<input class="form-control" type="text" id="mmdde" name="mmdde" <?=$readonly?><?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['mmdde']?>" <?php }?>/>
					</div>
				</div>
		<?php if(isset($Tarif)){?>
		<div class="form-group">
			<label for="inputEmail" class="col-lg-2 control-label">Prix</label>
			<div class="col-lg-10" >
					<?php $vard = $Tarif;?>
					<?php if(isset($Mesdonnees)){$tar=$Mesdonnees['coutestime'];}?>
					<select class="form-control"  name="tarif"> 
						<option>----</option>
						<?php foreach($vard as $d){?>
							<option value="<?php echo $d["montant"];?>  <?=$readonly?> <?php if($tar==$d['montant']) echo 'selected';?>"> <?php echo $d["montant"];?></option>
							<?php } ?>  
					    <option value="Autres">Autres</option>
							
						</select>
						
					</div>
				<?php }?>
		</div>
		<div class="form-group" id="tarif2">
		<label for="inputEmail" class="col-lg-2 control-label">Entrez votre valeur:</label>
		<div class="col-lg-10">
				<input type="text" class="form-control" id="coutestime" name="tarif2" <?=$readonly?> <?php if (isset($Mesdonnees)){?> value="<?=$Mesdonnees['coutestime']?>" <?php }?> />
		</div>
		</div>
				
				<br/>
		
				<ul class="pager">
 					 <li><button class="btn btn-info"onclick="prviewPhase14()">Précédent </button></li>
					 <li><button class="btn btn-info"onclick="processPhase15()">Suivant</button></li>
				 </ul>
			
		
		</fieldset>
		
		
		
		<div class="form-group" id="show_all_data">
			<div class="col-lg-10">
				<p> Veuillez enregistrer les données</p>
		 		<button class="btn btn-primary" onclick="submitForm()"> <?= ProjetTranslator::enregistrer($lang) ?> </button>
		 		<button class="btn btn-primary" onclick="prviewPhase15()">Retour </button>
		 		<?php if (isset($Mesdonnees) && ($Mesdonnees['idform']!="")){?>
		        <button type="button" onclick="location.href='Projet/Deletefiche/<?=$this->clean($Mesdonnees['idform']) ?>'" class="btn btn-danger" id="navlink">Delete</button>
				<?php }?>
			</div>
		</div>
	</div> 
</form>
</body>	
</div>

</html>
<br/> <br/>
<?php include 'Modules/core/View/timepicker_script.php';?>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
