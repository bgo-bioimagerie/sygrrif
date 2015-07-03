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
		$sql="select * from reservation;";
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
	public function getNeurinfoModif($numerofiche){
		$sql="select * from neurinfo where numerofiche=?";
		$req= $this->runRequest($sql, array($numerofiche));
		return $req->fetch();
	}
//Selectionné les informations depuis investigateur principal
  public function getInvesPrinc($numerofiche){
    	$sql="select * from invesprinc where numerofiche=?";
    	$req=$this->runRequest($sql, array($numerofiche));
    	return $req->fetchAll();
    }
    //prendre les données des investigateurs associés
 public function getInvesAssoc($numerofiche){
    	$sql="select * from invesassoc where numerofiche=?";
    	$req=$this->runRequest($sql, array($numerofiche));
    	return $req->fetchAll();
    }
//Supprimer la fiche projet 
    public function deletfiche($idform){
    	$sql="DELETE FROM neurinfo WHERE idform = ?";
		$req = $this->runRequest($sql, array($idform));
    }
//inserer les données depuis la fiche projet
	public function	setDonnee($datedemande, $utilisateur, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime)
		{
			$this->addDonnee($datedemande, $utilisateur, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime);
		}

	private function addDonnee($datedemande, $utilisateur, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime){
		
		$sql = "insert into neurinfo(datedemande, utilisateur, numerofiche, type, titre, acronyme, typeactivite, nac, cprenom, cnom, cfonction, cmail, ctel, promoteur, infos, crolibelle, cri, opglibelle, opgcoordonee, arcprenom, arcnom, arcfonction, arcmail, arctel, rsre, cstns, cstnt, cpp, cppnumero, resume, objectif, experimentation, protocolimagerie, traitementdonnee, resultatattendu, publicationenvisage, motcle, temoins, patient, fantome, responsablerecru, protocoleinjecte, nbrexam, duree, dureetotale,  planification, numerovisite, commentaire, datedemarage, contrainte, dureeetude, programmation, cotation, codecouleur,  rhlme, rhlmn, aedsm, gamds, aaodn, cspn, ndlcdn, caf, mddedmedr, mmdde, coutestime)" 
				. " values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($datedemande, $utilisateur, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime));		
		}
	
//Inserer les coordonnées des investigateurs principal 
	public function insrtPrinc($cpt, $ipprenom, $ipnom, $ipfonction, $ipmail, $iptel, $numerofiche)
	{
		for($i=0; $i<$cpt; $i++)
		{
			$this->addinvP($cpt, $ipprenom[$i], $ipnom[$i], $ipfonction[$i], $ipmail[$i], $iptel[$i], $numerofiche);
		}
			
	}
	public function addinvP($cpt, $vp, $vn, $vf, $vm, $vt, $nv)
	{
		$sql="insert into invesprinc (cpt, ipprenom, ipnom, ipfonction, ipmail, iptel, numerofiche) values(?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cpt, $vp, $vn, $vf, $vm, $vt, $nv));
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
	public function insrtAssoc($cpta, $iaprenom, $ianom, $iafonction, $iamail, $iatel, $numerofiche)
	{
		for($k=0; $k<$cpta; $k++)
		{
			$this->addinvA($cpta, $iaprenom[$k], $ianom[$k], $iafonction[$k], $iamail[$k], $iatel[$k], $numerofiche);
		}
	}
	
	public function addinvA($cpt, $vp, $vn, $vf, $vm, $vt, $nf)
	{
		$sql="insert into invesassoc(cpta, iaprenom, ianom, iafonction, iamail, iatel, numerofiche) values(?,?,?,?,?,?,?)";
		$user = $this->runRequest($sql, array($cpt, $vp, $vn, $vf, $vm, $vt, $nf));
		
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
//Modifier la fiche projet depuis la liste des fiches projets

	public function updateliste($idform, $datedemande, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime){
		$sql = "update neurinfo set datedemande=?, numerofiche=?, type=?, titre=?, acronyme=?, typeactivite=?, nac=?,  cprenom=?, cnom=?, cfonction=?, cmail=?, ctel=?, promoteur=?, infos=?, crolibelle=?, cri=?, opglibelle=?, opgcoordonee=?, arcprenom=?, arcnom=?, arcfonction=?, arcmail=?, arctel=?, rsre=?, cstns=?, cstnt=?, cpp=?, cppnumero=?, resume=?, objectif=?, experimentation=?, protocolimagerie=?, traitementdonnee=?, resultatattendu=?, publicationenvisage=?, motcle=?, temoins=?, patient=?, fantome=?, responsablerecru=?, protocoleinjecte=?, nbrexam=?, duree=?, dureetotale=?, planification=?, numerovisite=?, commentaire=?, datedemarage=?, dureeetude=?, contrainte=?, programmation=?, cotation=?, codecouleur=?, rhlme=?, rhlmn=?, aedsm=?, gamds=?, aaodn=?, cspn=?, ndlcdn=?, caf=?, mddedmedr=?, mmdde=?, coutestime=?  where idform=?" ;
		$this->runRequest($sql, array($datedemande, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime, $idform));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}