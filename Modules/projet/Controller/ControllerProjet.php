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
			$idform="";
				if($this->request->isParameterNotEmpty('actionid'))
				{
					$idform=$this->request->getParameter("actionid");
				}
		$ajouteradmin=false;
	if ($_SESSION["user_status"]==4){
				$ajouteradmin=true; //readonly
			}
		
		$modelUser = new User();
		$users = $modelUser->getActiveUsers("Name");
		$curentuserid = $this->request->getSession()->getAttribut("id_user");
		$curentuser = $modelUser->userAllInfo($curentuserid);
		
			$modelModif = new neurinfoprojet();
			$Mesdonnees =$modelModif->getNeurinfoModif($idform);
			$invP = $modelModif->getInvesPrinc($idform);
			$invA = $modelModif->getInvesAssoc($idform); 
			$arc =$modelModif->getArc($idform);
			$prgr=$modelModif->getProg($idform);
			$cota=$modelModif->getCot($idform);
			$fina=$modelModif->getFin($idform);
			$Tarif= $modelModif->gettarif();
			$color = $modelModif->getcolor();
			$navBar = $this->navBar();
			$this->generateView ( array (
					'navBar' => $navBar,
					'ModifierFicheProjet'=>$ModifierFicheProjet,
					'Mesdonnees' => $Mesdonnees,
					'invP'=> $invP,
					'invA' => $invA,
					'arc'=>$arc,
					'prgr'=>$prgr,
					'cota'=>$cota,
					'fina'=>$fina,
					'idform'=>$idform,
					'Tarif'=>$Tarif,
					'color'=>$color,
					'curentuser'=>$curentuser,
					'curentuserid'=>$curentuserid,
					'users'=>$users,
					'ajouteradmin'=>$ajouteradmin
					
					
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
		$acronyme = $this->request->getParameter ("acronyme");
		$titre = $this->request->getParameter ("titre");
		$type =$this->request->getParameter ("type" );
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
		//radiologue 
		$rsre=$this->request->getParameter ("rsre" );
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
		
		
		$nbrexam=$this->request->getParameter ("nbrexam" );
		$duree=$this->request->getParameter ("duree" );
		$dureetotale=$this->request->getParameter("dureetotale" );
		$planification=$this->request->getParameter ("planification" );
		$commentaire=$this->request->getParameter ("commentaire" );
		$datedemarage=$this->request->getParameter ("datedemarage" );
		$dureeetude=$this->request->getParameter ("dureeetude" );
		$contrainte=$this->request->getParameter ("contrainte" );
		$rhlme=$this->request->getParameter ("rhlme" );
		$rhlmn=$this->request->getParameter ("rhlmn" );
		$aedsm=$this->request->getParameter ("aedsm" );
		$aaodn=$this->request->getParameter ("aaodn");
		$cspn=$this->request->getParameter ("cspn" );
		$ndlcdn=$this->request->getParameter ("ndlcdn" );
		$caf=$this->request->getParameter("caf");
		//plan de dissémination
		$mddedmedr=$this->request->getParameter ("mddedmedr");
		$mmdde=$this->request->getParameter ("mmdde");
		
		$numerofiche =$this->request->getParameter ("numerofiche");
		$typeactivite=$this->request->getParameter("typeactivite");
		$protocoleinjecte=$this->request->getParameter ("protocoleinjecte" );
		$numerovisite= $this->request->getParameter("numerovisite");
		
		//organisme partenaire
		$opglibelle=$this->request->getParameter ("opglibelle" );
		$opgcoordonee=$this->request->getParameter ("opgcoordonee" );
		//correspondants neurinfo
		$cstns=$this->request->getParameter ("cstns" );
		$cstnt=$this->request->getParameter ("cstnt" );
		
		
		$gamds=$this->request->getParameter ("gamds" );
		$cdanonym=$this->request->getParameter("cdanonym");
		$cdnomin=$this->request->getParameter("cdnomin");
		$miseenplace=$this->request->getParameter("miseenplace");
		$cloture=$this->request->getParameter("cloture");
		$irm= $this->request->getParameter("irm");
		$lastirm= $this->request->getParameter("lastirm");
			$modelProjet= new neurinfoprojet();
		if($idform!='' && $numerofiche!=0){
		$modelProjet->updateliste($idform, $datedemande, $utilisateur, $acronyme, $titre, $type, $numerofiche, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm);
		}
		else{$setDonnee =$modelProjet->setDonnee($datedemande, $utilisateur, $acronyme, $titre, $type, $numerofiche, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm);
		$idformnew=$modelProjet->setDonnee($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm);
		
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
		$insrtPrinc= $modelProjet->insrtPrinc($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche, $idformnew);
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
		
		$insrtAssoc= $modelProjet->insrtAssoc($cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche, $idformnew);
		}
	//attaché recherche clinique
		$arc= $this->request->getParameter("arc");
		$id_arc=$arc ['id_arc'];
		$arcprenom=$arc ["arcprenom"];
		$arcnom=$arc ["arcnom"];
		$arcfonction=$arc["arcfonction"];
		$arcmail=$arc["arcmail"];
		$arctel=$arc["arctel"];
		$cptarc=0;
		for($l=0; $l<count($arcprenom); $l++)
		{
		  if($arcprenom[$l]!="")
		 {
		 	$cptarc++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateArc($id_arc, $cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $numerofiche);
		}
		else{
		
		$insrtArc= $modelProjet->insrtArc($cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $numerofiche, $idformnew);
		}
	
		
		//type de financement 
		$fin = $this->request->getParameter("fin");
		$id_fin=$fin["id"];
		$soinscourant=$fin["soinscourant"];
		$tarif1=$fin["tarif"];
		$tarif2=$this->request->getParameter ("tarif2");
		$comfin=$fin["commentaire"];
		
		$tarif="";
		if($tarif1 !="Autres"){
			$tarif=$tarif1;
		}
		else{
			$tarif= $tarif2;
		}
		$cptfin=0;
	for($o=0; $o<count($soinscourant); $o++)
		{
		  if($soinscourant[$o]!="")
		 {
		 	$cptfin++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateFin($id_fin, $cptfin, $soinscourant, $tarif, $comfin, $numerofiche);
		}
		else{
		
		$insrtFin= $modelProjet->insrtFin($cptfin, $soinscourant, $tarif, $comfin, $numerofiche, $idformnew);
		}
		
		
		
		//programmation/
		$prog = $this->request->getParameter("prog");
		$id_prog = $prog["id"];
		$dxplanning=$prog["dxplanning"];
		$codecouleur=$prog["codecouleur"];
		$comprog=$prog["commentaire"];
		$cptprog=0;
		for($m=0; $m<count($dxplanning); $m++)
		{
		  if($dxplanning[$m]!="")
		 {
		 	$cptprog++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateProg($id_prog, $cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche);
		}
		else{
		
		$insrtProg= $modelProjet->insrtProg($cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche, $idformnew);
		}
		//cotation
		$cot = $this->request->getParameter("cot");
		$id_cot = $cot["id"];
		$intitule=$cot["intitule"];
		$facturable=$cot["facturable"];
		$comcot=$cot["commentaire"];
		$cptcot=0;
	
		for($n=0; $n<count($intitule); $n++)
		{
		  if($intitule[$n]!="")
		 {
		 	$cptcot++;
		 }
		}
		if($numerofiche!=0 && $idform!=""){
			$modelProjet->updateCot($id_cot, $cptcot, $intitule, $facturable, $comcot, $numerofiche);
		}
		else{
		
		$insrtCot= $modelProjet->insrtCot($cptcot, $intitule, $facturable, $comcot, $numerofiche, $idformnew);
		}
		
		
		
		
		$this->redirect("projet", "listeform");
	
	
}	

}

	
