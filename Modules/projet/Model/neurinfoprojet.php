<?php

require_once 'Framework/Model.php';


class neurinfoprojet extends Model {

	
	/**
	 * Create the unit table
	 *
	 * @return PDOStatement
	 */
	public function createTable(){
			
	$sql = "
		CREATE TABLE IF NOT EXISTS `neurinfo` (
	  
	  `titre` varchar(30) NOT NULL,
	  `acronyme` varchar(30) NOT NULL
	  );";
		$pdo = $this->runRequest($sql);
		return $pdo;
		$sql = "
		CREATE TABLE IF NOT EXISTS `invesprinc` (
	  
	  `ipprenom` varchar(30) NOT NULL,
	  `ipnom` varchar(30) NOT NULL
	  );";
		$pdo = $this->runRequest($sql);
		return $pdo;
		$sql = "
		CREATE TABLE IF NOT EXISTS `invesassoc` (
	  
	  `iaprenom` varchar(30) NOT NULL,
	  `ianom` varchar(30) NOT NULL
	  );";
		$pdo = $this->runRequest($sql);
		return $pdo;
	}

	//envoyé a la liste form
	public function getListeProjet(){
		$sql = "select idform, titre, acronyme, numerofiche from neurinfo order by idform;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	//fonction pour editreservation 
	public function getProjet(){
		$sql="select * from neurinfo;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
		
	}
	public function getinfores(){
		$sql="select * from reservation";
		$data= $this->runRequest($sql);
		return $data->fetchAll();
	}
// selectionner les prix depuis la fiche projet
	public function gettarif()
{
	$sql="select * from projet_tarif";
	$data = $this->runRequest($sql);
		return $data->fetchAll();
		
}

// selectionner les couleurs depuis la table dans la base de données sy_color_codes
public function getcolor()
{
	$sql="select * from sy_color_codes";
	$data = $this->runRequest($sql);
		return $data->fetchAll();
}
	//information pour le calendrier
public function calreservation($rid) {
		$sql = "select * from reservation r, core_users u where u.id=? AND r.recipient_id=u.id";
		$user = $this->runRequest ( $sql, array (
				$rid 
		) );
		$userquery = null;
		if ($user->rowCount () == 1)
			return $user->fetch (); // get the first line of the result
		else
			throw new Exception ( "Cannot find the user using the given parameters" );
	}

	//envoyé à l'index info dans la base neurinfo pour pouvoir modifier
	public function getNeurinfoModif($idform){
		$sql="select * from neurinfo where idform=?";
		$req= $this->runRequest($sql, array($idform));
		return $req->fetch();
	}
//Selectionné les informations depuis investigateur principal
  public function getInvesPrinc($idform){
    	$sql="select * from invesprinc where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
    
    //prendre les données des investigateurs associés
 public function getInvesAssoc($idform){
    	$sql="select * from invesassoc where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
public function getArc($idform){
    	$sql="select * from neurinfoArc where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
public function getProg($idform){
    	$sql="select * from programmation where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
public function getCot($idform){
    	$sql="select * from cotation where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
public function getFin($idform){
    	$sql="select * from projet_type_financement where idform=?";
    	$req=$this->runRequest($sql, array($idform));
    	return $req->fetchAll();
    }
//Supprimer la fiche projet 
    public function deletfiche($idform){
    	$sql="DELETE FROM neurinfo WHERE idform = ?";
		$req = $this->runRequest($sql, array($idform));
    }
//inserer les données depuis la fiche projet
	public function	setDonnee($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm)
		{
			return $this->addDonnee($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm);
			
		}

	private function addDonnee($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm){
		
		$sql = "insert into neurinfo(datedemande, utilisateur, acronyme, titre, type, nac, cprenom, cnom, cfonction, cmail, ctel, promoteur, infos, crolibelle, cri, rsre, cpp, cppnumero, resume, objectif, experimentation, protocolimagerie, traitementdonnee, resultatattendu, publicationenvisage, motcle, temoins, patient, fantome, responsablerecru, nbrexam, duree, dureetotale, planification, commentaire, datedemarage, dureeetude, contrainte, rhlme, rhlmn, aedsm, aaodn, cspn, ndlcdn, caf, mddedmedr, mmdde, numerofiche, typeactivite, protocoleinjecte, numerovisite, opglibelle, opgcoordonee, cstns, cstnt, gamds, cdanonym, cdnomin, miseenplace, cloture, irm, lastirm)" 
				. " values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm));		
		return $this->getDatabase()->lastInsertId();
	
	}
		
		
	
//Inserer les coordonnées des investigateurs principal 
	public function insrtPrinc($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche, $idformnew)
	{
		for($i=0; $i<$cpt; $i++)
		{
			$this->addinvP($cpt, $ipprenom[$i], $ipnom[$i], $ipfonction[$i], $ipmail[$i], $iptel[$i], $numerofiche, $idformnew );
		}
			
	}
	public function addinvP($cpt, $vp, $vn, $vf, $vm, $vt, $nv, $idf)
	{
		$sql="insert into invesprinc (cpt, ipprenom, ipnom, ipfonction, ipmail, iptel, numerofiche, idform) values(?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cpt, $vp, $vn, $vf, $vm, $vt, $nv, $idf));
	}
	public function updateInvP($id_ip, $cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche){
	for($i=0; $i<$cpt; $i++)
		{
			$this->UpInp($id_ip[$i], $cpt, $ipprenom[$i], $ipnom[$i], $ipfonction[$i], $ipmail[$i], $iptel[$i], $numerofiche);
		}
	}
	public function UpInP($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche, $id_ip){
		$sql="update invesprinc set cpt=?, ipprenom=?, ipnom=?, ipfonction=?, ipmail=?, iptel=? where numerofiche=? AND id_ip=?";
		$this->runRequest($sql, array($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche, $id_ip));
	}

		
	
//prendre le numero de la fiche depuis linvestigateur principale pour pouvoir afficher ce qu'il y'a dans al table et puis modifier 

	public function getNum($idform){
		$sql = "select numerofiche from neurinfo where idform=?;";
		$req = $this->runRequest($sql, array($idform));
		return $req->fetch();
	}
	
//Inserver les coordonnées des investigateurs associés 
	public function insrtAssoc($cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche, $idformnew)
	{
		for($k=0; $k<$cpta; $k++)
		{
			$this->addinvA($cpta, $iaprenom[$k], $ianom[$k], $iafonction[$k], $iamail[$k], $iatel[$k], $numerofiche, $idformnew);
		}
	}
public function addinvA($cpt, $vp, $vn, $vf, $vm, $vt, $nf, $idf)
	{
		$sql="insert into invesassoc(cpta, iaprenom, ianom, iafonction, iamail, iatel, numerofiche, idform) values(?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cpt, $vp, $vn, $vf, $vm, $vt, $nf, $idf));
		
	}
public function updateInvIa($id_ia, $cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche)
	{
	for($i=0; $i<$cpta; $i++)
		{
			$this->UpInvA($id_ia[$i], $cpta, $iaprenom[$i], $ianom[$i], $iafonction[$i], $iamail[$i], $iatel[$i], $numerofiche);
		}
	}
public function UpInvA($id_ia, $cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche){
		$sql="update invesassoc set cpta=?, iaprenom=?, ianom=?, iafonction=?, iamail=?, iatel=? where id_ia=? and numerofiche=?";
		$this->runRequest($sql, array($cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $id_ia, $numerofiche));
	}
	//Inserer un attaché de recherche clinique
public function insrtArc($cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $numerofiche, $idformnew)
	{
		for($n=0; $n<$cptarc; $n++)
		{
			$this->addArc($cptarc, $arcprenom[$n], $arcnom[$n], $arcfonction[$n], $arcmail[$n], $arctel[$n], $numerofiche, $idformnew);
		}
	}
	
public function addArc($cpt, $vp, $vn, $vf, $vm, $vt, $nf, $idf)
	{
		$sql="insert into neurinfoArc(cptarc, arcprenom, arcnom, arcfonction, arcmail, arctel, numerofiche, idform) values(?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cpt, $vp, $vn, $vf, $vm, $vt, $nf, $idf));
		
	}
public function updateArc($id_arc, $cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $numerofiche)
	{
	for($i=0; $i<$cptarc; $i++)
		{
			$this->Uparc($id_arc[$i], $cptarc, $arcprenom[$i], $arcnom[$i], $arcfonction[$i], $arcmail[$i], $arctel[$i], $numerofiche);
		}
	}
public function Uparc($id_arc, $cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $numerofiche){
		$sql="update neurinfoArc set cptarc=?, arcprenom=?, arcnom=?, arcfonction=?, arcmail=?, arctel=? where id_arc=? and numerofiche=?";
		$this->runRequest($sql, array($cptarc, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $id_arc, $numerofiche));
	}

	//programmation 
	
public function insrtProg($cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche, $idformnew)
	{
		for($n=0; $n<$cptprog; $n++)
		{
			$this->addProg($cptprog, $dxplanning[$n], $codecouleur[$n], $comprog[$n], $numerofiche, $idformnew);
		}
	}
	
public function addProg($cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche, $idformnew)
	{
		$sql="insert into programmation(cptprog, dxplanning, codecouleur, comprog, numerofiche, idform) values(?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche, $idformnew));
		
	}
public function updateProg($id_prog, $cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche)
	{
	for($i=0; $i<$cptprog; $i++)
		{
			$this->Upprog($id_prog[$i], $cptprog, $dxplanning[$i], $codecouleur[$i], $comprog[$i], $numerofiche);
		}
	}
public function Upprog($id_prog, $cptprog, $dxplanning, $codecouleur, $comprog, $numerofiche){
		$sql="update programmation set cptprog=?, dxplanning=?, codecouleur=?, comprog=? where id_arc=? and numerofiche=?";
		$this->runRequest($sql, array($cptprog, $dxplanning, $codecouleur, $comprog, $id_prog, $numerofiche));
	}
	
	//cotation
	public function insrtCot($cptcot, $intitule, $facturable, $comcot, $numerofiche, $idformnew)
	{
		for($n=0; $n<$cptcot; $n++)
		{
			$this->addcot($cptcot, $intitule[$n], $facturable[$n], $comcot[$n], $numerofiche, $idformnew);
		}
	}
	
public function addcot($cptcot, $intitule, $facturable, $comcot, $numerofiche, $idformnew)
	{
		$sql="insert into cotation(cptcot, intitule, facturable, comcot, numerofiche, idform) values(?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array( $cptcot, $intitule, $facturable, $comcot, $numerofiche, $idformnew));
		
	}
public function updateCot($id_cot, $cptcot, $intitule, $facturable, $comcot, $numerofiche)
	{
	for($i=0; $i<$cptcot; $i++)
		{
			$this->Upcot($id_cot[$i], $cptcot, $intitule[$i], $facturable[$i], $comcot[$i], $numerofiche);
		}
	}
public function Upcot($id_cot, $cptcot, $intitule, $facturable, $comcot, $numerofiche){
		$sql="update cotation set cptcot=?, intitule=?, facturable=?, comcot=? where id_arc=? and numerofiche=?";
		$this->runRequest($sql, array($id_cot, $cptcot, $intitule, $facturable, $comcot, $numerofiche));
	}
	
	//type de financement 
	public function insrtFin($cptfin, $soinscourant, $tarif, $comfin, $numerofiche, $idformnew)
	{
		for($n=0; $n<$cptfin; $n++)
		{
			$this->addfin($cptfin, $soinscourant[$n], $tarif[$n], $comfin[$n], $numerofiche, $idformnew);
		}
	}
	
public function addfin($cptfin, $soinscourant, $tarif, $comfin, $numerofiche, $idformnew)
	{
		$sql="insert into projet_type_financement(cptfin, soinscourant, tarif, comfin, numerofiche, idform) values(?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cptfin, $soinscourant, $tarif, $comfin, $numerofiche, $idformnew));
		
	}
public function updateFin($id_fin, $cptfin, $soinscourant, $tarif, $comfin, $numerofiche)
	{
	for($i=0; $i<$cptfin; $i++)
		{
			$this->Upfin($id_fin[$i], $cptfin, $soinscourant[$i], $tarif[$i], $comfin[$i], $numerofiche);
		}
	}
public function Upfin($id_fin, $cptfin, $soinscourant, $tarif, $comfin, $numerofiche){
		$sql="update projet_type_financement set cptfin=?, soinscourant=?, tarif=?, comfin=?, arctel=? where id_arc=? and numerofiche=?";
		$this->runRequest($sql, array($id_fin, $cptfin, $soinscourant, $tarif, $comfin, $numerofiche));
	}
	
	
//Modifier la fiche projet depuis la liste des fiches projets

	public function updateliste($idform, $datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm){
		$sql = "update neurinfo set datedemande, utilisateur, acronyme, titre, type, nac, cprenom, cnom, cfonction, cmail, ctel, promoteur, infos, crolibelle, cri, rsre, cpp, cppnumero, resume, objectif, experimentation, protocolimagerie, traitementdonnee, resultatattendu, publicationenvisage, motcle, temoins, patient, fantome, responsablerecru, nbrexam, duree, dureetotale, planification, commentaire, datedemarage, dureeetude, contrainte, rhlme, rhlmn, aedsm, aaodn, cspn, ndlcdn, caf, mddedmedr, mmdde, numerofiche, typeactivite, protocoleinjecte, numerovisite, opglibelle, opgcoordonee, cstns, cstnt, gamds, cdanonym, cdnomin, miseenplace, cloture, irm, lastirm where idform=?" ;
		$this->runRequest($sql, array($datedemande, $utilisateur, $acronyme, $titre, $type, $nac, $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $rsre, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $nbrexam, $duree, $dureetotale, $planification, $commentaire, $datedemarage, $dureeetude, $contrainte, $rhlme, $rhlmn, $aedsm, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $numerofiche, $typeactivite, $protocoleinjecte, $numerovisite, $opglibelle, $opgcoordonee, $cstns, $cstnt, $gamds, $cdanonym, $cdnomin, $miseenplace, $cloture, $irm, $lastirm, $idform));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}