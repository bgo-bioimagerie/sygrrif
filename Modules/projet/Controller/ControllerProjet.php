<?php
require_once 'Framework/Controller.php';
require_once 'Modules/core/Controller/ControllerSecureNav.php';
require_once 'Modules/projet/Model/neurinfoprojet.php';
require_once 'Modules/core/Model/User.php';


class ControllerProjet extends ControllerSecureNav {

	public function __construct() {
	}

	
//fiche projet avec modification  
	public function index() 
	{
		$ModifierFicheProjet=false;
			if ($_SESSION["user_status"]>=3){
				$ModifierFicheProjet=true; //readonly
			}
			$numerofiche="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$numerofiche=$this->request->getParameter("actionid");
				}
		$modelUser = new User();
		$users = $modelUser->getActiveUsers("Name");
		$curentuserid = $this->request->getSession()->getAttribut("id_user");
		$curentuser = $modelUser->userAllInfo($curentuserid);
		
			$modelModif = new neurinfoprojet();
			$Mesdonnees =$modelModif->getNeurinfoModif($numerofiche);
			$invP = $modelModif->getInvesPrinc($numerofiche);
			$invA = $modelModif->getInvesAssoc($numerofiche); 
			$Tarif= $modelModif->gettarif();
			$color = $modelModif->getcolor();
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'ModifierFicheProjet'=>$ModifierFicheProjet,
					'Mesdonnees' => $Mesdonnees,
					'invP'=> $invP,
					'invA' => $invA,
					'numerofiche'=>$numerofiche,
					'Tarif'=>$Tarif,
					'color'=>$color,
					'curentuser'=>$curentuser,
					'curentuserid'=>$curentuserid,
					'users'=>$users
					
					
			) );
			
		
	}
// supprimer une fiche projet
	public function Deletefiche()
	{
		$idform = '';
		if ($this->request->isParameterNotEmpty ( 'actionid' )) 
		{
			$idform = $this->request->getParameter ( "actionid" );
		}
		
		$model= new neurinfoprojet();
		$model->deletfiche($idform);
		$this->redirect("Projet", "listeform");
}
// Lister les fiches projets avec leur titre et acronyme
	public function listeform()
	{
		$navBar = $this->navBar();
		$modelProjet = new neurinfoprojet;
		$liste = $modelProjet->getListeProjet();
		
			$this->generateView ( array (
				'navBar' => $navBar, 
				'liste'=> $liste,	
			
						
		) );
		
	}

//enregistrer et modifier les données de la fiche projet dans la base de données
	public function ajoutDonneQuery(){
	
		$idform=$this->request->getParameter("idform");
		$datedemande=$this->request->getParameter ("datedemande" );
		$utilisateur=$this->request->getParameter("utilisateur");
		$numerofiche =$this->request->getParameter ("numerofiche");
		$type =$this->request->getParameter ("type" );
		$titre = $this->request->getParameter ("titre");
		$acronyme = $this->request->getParameter ("acronyme");
		$typeactivite=$this->request->getParameter("typeactivite");
		$nac = $this->request->getParameter("nac");
		
		
		//coordinateur
		$cprenom= $this->request->getParameter ("cprenom");
		$cnom= $this->request->getParameter ("cnom");
		$cfonction = $this->request->getParameter("cfonction");
		$cmail=$this->request->getParameter ("cmail" );
		$ctel=$this->request->getParameter ("ctel" );
		//promoteur
		$promoteur=$this->request->getParameter ("promoteur" );
		$infos =$this->request->getParameter("infos");
		//CRO
		$crolibelle=$this->request->getParameter ("crolibelle" );
		$cri=$this->request->getParameter ("cri" );
		//organisme partenaire
		$opglibelle=$this->request->getParameter ("opglibelle" );
		$opgcoordonee=$this->request->getParameter ("opgcoordonee" );
		//attaché recherche clinique
		$arcprenom=$this->request->getParameter ("arcprenom" );
		$arcnom=$this->request->getParameter ("arcnom" );
		$arcfonction=$this->request->getParameter ("arcfonction" );
		$arcmail=$this->request->getParameter ("arcmail" );
		$arctel=$this->request->getParameter ("arctel" );
		//radiologue 
		$rsre=$this->request->getParameter ("rsre" );
		//correspondants neurinfo
		$cstns=$this->request->getParameter ("cstns" );
		$cstnt=$this->request->getParameter ("cstnt" );
		//CPP
		$cpp=$this->request->getParameter ("cpp");
		$cppnumero=$this->request->getParameter ("cppnumero" );
		//Description etude
		$resume=$this->request->getParameter ("resume" );
		$objectif=$this->request->getParameter ("objectif" );
		$experimentation=$this->request->getParameter ("experimentation" );
		$protocolimagerie=$this->request->getParameter("protocolimagerie");
		$traitementdonnee=$this->request->getParameter ("traitementdonnee" );
		$resultatattendu=$this->request->getParameter ("resultatattendu" );
		$publicationenvisage=$this->request->getParameter ("publicationenvisage" );
		$motcle=$this->request->getParameter ("motcle" );
		//protocole etude
		$temoins=$this->request->getParameter ("temoins" );
		$patient=$this->request->getParameter ("patient" );
		$fantome=$this->request->getParameter ("fantome" );
		$responsablerecru=$this->request->getParameter ("responsablerecru" );
		$protocoleinjecte=$this->request->getParameter ("protocoleinjecte" );
		
		$nbrexam=$this->request->getParameter ("nbrexam" );
		$duree=$this->request->getParameter ("duree" );
		$dureetotale=$this->request->getParameter("dureetotale" );
		$planification=$this->request->getParameter ("planification" );
		$numerovisite= $this->request->getParameter("numerovisite");
		$commentaire=$this->request->getParameter ("commentaire" );
		$datedemarage=$this->request->getParameter ("datedemarage" );
		$dureeetude=$this->request->getParameter ("dureeetude" );
		$contrainte=$this->request->getParameter ("contrainte" );
			//programmation/cotation
		$programmation=$this->request->getParameter ("programmation" );
		$cotation=$this->request->getParameter ("cotation" );
		$codecouleur= $this->request->getParameter("codecouleur");
		//Besoins spécifique
		$rhlme=$this->request->getParameter ("rhlme" );
		$rhlmn=$this->request->getParameter ("rhlmn" );
		$aedsm=$this->request->getParameter ("aedsm" );
		$gamds=$this->request->getParameter ("gamds" );
		//plateforme neurinfo
		$aaodn=$this->request->getParameter ("aaodn");
		$cspn=$this->request->getParameter ("cspn" );
		$ndlcdn=$this->request->getParameter ("ndlcdn" );
		$caf=$this->request->getParameter("caf");
		//plan de dissémination
		$mddedmedr=$this->request->getParameter ("mddedmedr");
		$mmdde=$this->request->getParameter ("mmdde");
		//cout
		$tarif=$this->request->getParameter ("tarif");
		$tarif2=$this->request->getParameter ("tarif2");
		$coutestime="";
		if($tarif !="Autres"){
			$coutestime=$tarif;
		}
		else{
			$coutestime= $tarif2;
		}
	
		$modelProjet= new neurinfoprojet();
		if($idform!='' && $numerofiche!=0){
		$modelProjet->updateliste($idform, $datedemande, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime);
		}
		else{$setDonnee =$modelProjet->setDonnee($datedemande, $utilisateur, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime);
		}

		
		//investicateur principal
		$invesp=$this->request->getParameter("invesp");
		$id_ip =$invesp['id_ip']; 
		$ipprenom =$invesp['ipprenom'];
		$ipnom= $invesp['ipnom'];
		$ipfonction= $invesp['ipfonction'];
		$ipmail=$invesp['ipmail'];
		$iptel=  $invesp['iptel'];
		$cpt=0;
		for($i=0; $i<count($ipprenom); $i++){
		 
		 if($ipprenom[$i]!="")
		 {
		 	$cpt++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateInvP($id_ip, $cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche);
		}
		else{
		$insrtPrinc= $modelProjet->insrtPrinc($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche);
		}
		
		//investigateur associé
		$invesa=$this->request->getParameter("invesa");
		$iaprenom= $invesa['iaprenom'];
		$id_ia=$invesa['id_ia'];
		$ianom  = $invesa['ianom'];
		$iafonction  = $invesa['iafonction'];
		$iamail = $invesa['iamail'];
		$iatel = $invesa['iatel'];
		$cpta=0;
		
		for($j=0; $j<count($iaprenom); $j++)
		{
		  if($iaprenom[$j]!="")
		 {
		 	$cpta++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateInvIa($id_ia, $cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche);
		}
		else{
		
		$insrtAssoc= $modelProjet->insrtAssoc($cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche);
		}
		
		
		
		$this->redirect("projet", "listeform");
	
	
}	

}

	
