<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/projet/Model/ProjetGenerationpdf.php';
require_once 'Modules/projet/Model/neurinfoprojet.php';

class ControllerGenerationpdf extends Controller{
	public function show()
		{
			$numerofiche="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$numerofiche=$this->request->getParameter("actionid");
				}
		
				$modelProjet = new ProjetGenerationpdf();
				$donnee=$modelProjet->showdonnee($numerofiche);
				return $donnee;
	
		}
		public function invp(){
		$numerofiche="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$numerofiche=$this->request->getParameter("actionid");
				}
			$modelModif = new neurinfoprojet();
			$invP = $modelModif->getInvesPrinc($numerofiche);
			return $invP;
		}
		public function inva(){
		$numerofiche="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$numerofiche=$this->request->getParameter("actionid");
				}
			$modelModif = new neurinfoprojet();
			$invA = $modelModif->getInvesAssoc($numerofiche);
			return $invA;
		}
		
	
	public function index()
	{
	
			require_once 'Modules/projet/Controller/html2pdf/html2pdf.class.php';
			$pdf=new HTML2PDF('P','A4', 'fr');
			$pdf->writeHTML($this->content());
			$pdf->Output('fiche-projet.pdf');
	}
	

	function content()
	{
		ob_start();?>  
	
		<?php $var=$this->show();
		?>
		<?php $inva=$this->inva();?>
		<?php $invp=$this->invp();?>
			<style type="text/css">
				table{ width:100%; color:#717375; font-size:12pt; line-height:6mm; border: 2px solid #eeab69; }
				strong{color:#000;}
				td{width:50%;}
			fieldset
			{
			    background-color: #ffffff;
			    width: 100%;
			    margin: 0 auto 15px auto;
			    padding: 10px;
			    border: 2px solid #eeab69;
			}
			 
			legend 
			{
			    color: #00000000;
			  	margin-left: 175px;
			  	margin-right: 175px;
			  	font-size: 18px;
			    width: 300px;
			    text-align: center;
			    padding: 0;
			    background-color: #ffffff;
			    border: 2px solid #eeab69;
			}
		
				
				
			</style>
			
	<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" >
			<div>
			<img src="externals/logo_neurinfo.jpg" align="right" > </div><h1>Fiche projet N�<?php echo $var['numerofiche']?></h1>
		<table  border=1>
			<tr>
				<td style="color:#0000">Date de la demande:</td>
				<td style="color:#0000">Type du projet:</td></tr>
			<tr>
				<td> <?php echo $var['datedemande']?></td>
				<td><?php echo $var['type']?></td>
			</tr>
		</table>
		<br/>
		<table  border=1 >
			<tr>
				<td style="color:#0000">Titre:</td>
				<td style="color:#0000"> Acronyme:</td>
			</tr>
			<tr>
				<td> <?php echo $var['titre']?></td>
				<td><?php echo $var['acronyme']?></td>
			</tr>
		</table>
		<br/>
		<?php for($i=0; $i<count($invp); $i++){?>
		<fieldset >
			<legend>Investigateur Principal</legend>
			
						<label> <?php echo utf8_encode("Pr�nom")?> </label>
						<p> <?php echo $invp[$i]['ipprenom']?></p> 
							
						<label> Nom </label>
						<p> <?php echo $invp[$i]['ipnom']?> </p>
						
						
						<label> Fonction </label>
						<p> <?php echo $invp[$i]['ipfonction']?> </p>
							
						<label>Email: </label>
						<p> <?php echo $invp[$i]['ipmail']?></p>
							
						<label><?php echo utf8_encode("T�l�phone")?>:</label>
						<p> <?php echo $invp[$i]['iptel']?></p>
					
		</fieldset> <?php }?>
			<?php for($i=0; $i<count($inva); $i++){?>
		<fieldset >
			<legend><?php echo utf8_encode("Investigateur associ�")?></legend>
			
						<label ><?php echo utf8_encode("Pr�nom")?> </label>
						<p> <?php echo $inva[$i]['iaprenom']?></p> 
						<label> Nom </label>
						<p> <?php echo $inva[$i]['ianom']?> </p>
						<label> Fonction </label>
						<p> <?php echo $inva[$i]['iafonction']?></p>
						<label>Email: </label>
						<p> <?php echo $inva[$i]['iamail']?></p>
						<label><?php echo utf8_encode("T�l�phone")?>:</label>
						<p> <?php echo $inva[$i]['iatel']?></p>
					
		</fieldset> <?php }?>
		
		<fieldset >
			<legend>Coordinateur</legend>
				<label><?php echo utf8_encode("Pr�nom")?> :</label>
					<p><?php echo $var['cprenom']?></p>
				<label>Nom:</label>
					<p><?php echo $var['cnom']?></p>
				<label>Fonction:</label>
					<p><?php echo $var['cfonction']?></p>
				<label>Email:</label>
					<p><?php echo $var['cmail']?></p>
				<label> <?php echo utf8_encode("T�l�phone")?>:</label>
					<p><?php echo $var['ctel']?></p>
		</fieldset>
		<fieldset ><legend>Promoteur </legend>
				<label><?php echo utf8_encode("Libell�")?>:</label>
					<p><?php echo $var['promoteur']?></p>
				<label><?php echo utf8_encode("Compl�ment")?>:</label>
					<p><?php echo $var['infos']?></p>
		</fieldset>
		<fieldset ><legend>CRO:</legend>
			<label><?php echo utf8_encode("Libell�")?>:</label>
				<p><?php echo $var['crolibelle']?></p>
			<label>Centre de relecture des images:</label>
				<p><?php echo $var['cri']?></p>
		</fieldset>
		<fieldset ><legend>Organisme partenaire gestionnaire:</legend>
			<label><?php echo utf8_encode("Libell�")?>:</label>
				<p><?php echo $var['opglibelle']?></p>
			<label><?php echo utf8_encode("Coordonn�es du correspondant")?>:</label>
				<p><?php echo $var['opgcoordonee']?></p>
		</fieldset>
		<fieldset ><legend><?php echo utf8_encode("Attach� recherche clinique")?></legend>
			<label><?php echo utf8_encode("Pr�nom")?></label>
				<p><?php echo $var['arcprenom']?></p>
			<label>Nom:</label>
				<p><?php echo $var['arcnom']?></p>
			<label>Fonction:</label>
				<p><?php echo $var['arcfonction']?></p>
			<label>Email:</label>
				<p><?php echo $var['arcmail']?></p>
			<label><?php echo utf8_encode("T�l�phone")?></label>
				<p><?php echo $var['arctel']?></p>
		</fieldset>
		<br/><br/>
		<fieldset >
			<legend><?php echo utf8_encode("Radiologue supervisant le r�alisation des examens:")?></legend>
				<label><?php echo utf8_encode("Nom et pr�nom:")?></label>
					<p><?php echo $var['rsre']?></p>
		</fieldset>
		<fieldset >
			<legend>Correspondant scientifique Neurinfo:</legend>
				<label><?php echo utf8_encode("Nom et pr�nom:")?></label>
					<p><?php echo $var['cstns']?></p>
		</fieldset>
		<fieldset >
			<legend>Correspondant technique Neurinfo:</legend>
				<label><?php echo utf8_encode("Nom et pr�nom:")?></label>
					<p><?php echo $var['cstnt']?></p>
		</fieldset>
		<fieldset ><legend>CPP:</legend>
			<label></label>
				<p><?php echo $var['cpp']?></p>
			<label><?php utf8_encode("CPP num�ro")?></label>
				<p><?php echo $var['cppnumero']?></p>
		</fieldset>
		
			<fieldset>
			<legend><?php echo utf8_encode("R�sum�")?></legend>
				<p><?php echo $var['resume']?></p>
			</fieldset>
			<fieldset>
			<legend>Objectif</legend>
				<p><?php echo $var['objectif']?></p>
			</fieldset>
			<fieldset>
			<legend>Experimentation:</legend>
				<p><?php echo $var['experimentation']?></p></fieldset>
				<fieldset>
			<legend>Protocol Imagerie:</legend>
				<p><?php echo $var['protocolimagerie']?></p></fieldset>
				<fieldset>
			<legend><?php echo utf8_encode("Traitement de donn�es :")?></legend>
				<p><?php echo $var['traitementdonnee']?></p></fieldset>
				<fieldset>
			<legend><?php echo utf8_encode("R�sultats attentdus:")?></legend>
				<p><?php echo $var['resultatattendu']?></p></fieldset>
				<fieldset>
			<legend><?php echo utf8_encode("Publication envisag�:")?></legend>
				<p><?php echo $var['publicationenvisage']?></p></fieldset>
		<fieldset>
			<legend><?php echo utf8_encode("Mots cl�s:")?></legend>
				<p><?php echo $var['motcle']?></p>
		</fieldset>
		<fieldset ><legend><?php echo utf8_encode("Protocole d'�tudes � r�aliser sur la plateforme")?></legend>
		<label><?php echo utf8_encode("T�moins")?></label>
		<p><?php echo $var['temoins']?></p>
		<label>Patients:</label>
		<p><?php echo $var['patient']?></p>
		<label><?php echo utf8_encode("Fant�me:")?></label>
		<p><?php echo $var['fantome']?></p>
		<label>Responsable du recrutement:</label>
		<p><?php echo $var['responsablerecru']?></p>
		<label><?php echo utf8_encode("Protocole inject�:")?></label>
		<p><?php echo $var['protocoleinjecte']?></p>
		<label>Nombre d'examens:</label>
		<p><?php echo $var['nbrexam']?></p>
		<label><?php echo utf8_encode("Dur�e de chaque examen:")?></label>
		<p><?php echo $var['duree']?></p>
		<label><?php echo utf8_encode("Dur�e totale:")?></label>
		<p><?php echo $var['dureetotale']?></p>
		<label>Planification:</label>
		<p><?php echo $var['planification']?></p>
		<label><?php echo utf8_encode("Num�ro de visite:")?></label>
		<p><?php echo $var['numerovisite']?></p>
		<label>Remarque:</label>
		<p><?php echo $var['commentaire']?></p>
		</fieldset>
		<fieldset ><legend>Planification</legend>
		<label><?php echo utf8_encode("Date de d�marrage pr�vue:")?></label>
		<p><?php echo $var['datedemarage']?></p>
		<label><?php echo utf8_encode("Dur�e �tude:")?></label>
		<p><?php echo $var['dureeetude']?></p>
		<label>Contrainte:</label>
		<p><?php echo $var['contrainte']?></p>
		<label>Programmation:</label>
		<p><?php echo $var['programmation']?></p>
		<label>Cotation:</label>
		<p><?php echo $var['cotation']?></p>
		<label>Code Couleur:</label>
		<p><?php echo $var['codecouleur']?></p>
		</fieldset>
		<fieldset >
		<legend><?php echo utf8_encode("Besoins sp�cifiques/Ressources")?></legend>
		<label><?php echo utf8_encode("Ressources humaines, logicielles et mat�rielles externes")?> </label>
		<p><?php echo $var['rhlme']?></p>
		<label><?php echo utf8_encode("Ressources humaines, logicielles et mat�rielles Neurinfo ")?></label>
		<p><?php echo $var['rhlmn']?></p>
		<label><?php echo utf8_encode("L'aide A l'exploitation des donn�es, d'un support m�thodologique")?></label>
		<p><?php echo $var['aedsm']?></p>
		<label><?php echo utf8_encode("Gestion et archivage des donn�es")?></label>
		<p><?php echo $var['gamds']?></p>
		</fieldset>
		<fieldset >
		<legend>Plateforme Neurinfo</legend>
		<label><?php echo utf8_encode("Ad�quation aux objectifs de la plateforme:")?> </label>
		<p><?php echo $var['aaodn']?></p>
		<label><?php echo utf8_encode("Caract�re structurant pour Neurinfo:")?> </label>
		<p><?php echo $var['cspn']?></p>
		<label>Nature de la contribution de Neurinfo:</label>
		<p><?php echo $var['ndlcdn']?></p>
		<label><?php echo utf8_encode("Capacit� d'autofinancement:")?></label>
		<p><?php echo $var['caf']?></p>
		</fieldset>
		<fieldset >
		<legend><?php echo utf8_encode("Plan de diss�mination")?></legend>
		<label><?php echo utf8_encode("Mode de diffusion envisag� des m�thodes et des r�sultats: ")?></label>
		<p><?php echo $var['mddedmedr']?></p>
			<label><?php echo utf8_encode("Mode de mise � disposition des donn�es envisag�s:")?> </label>
		<p><?php echo $var['mmdde']?></p>
				</fieldset>
		<fieldset >
		<legend><?php echo utf8_encode("Co�t Estim�")?></legend>
		<label>Prix: </label>
		<p><?php echo $var['coutestime']?></p>
		
				</fieldset></page>
				
	<?php $content=ob_get_clean();
		return $content;
	}
		
	}



	
