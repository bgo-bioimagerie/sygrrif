<?php

require_once 'Framework/Model.php';



class ProjetModifier extends Model{
	 //  Model pour afficher la liste des projets 
	public function getListeProjet()
	{
		$sql = "select * from neurinfo;";
		$data = $this->runRequest($sql);
		return $data->fetchAll();
	}
	
	
	//model pour modifier la fiche de projet 
	public function getdonnee($idform){
		$sql = "select * from neurinfo where idform=?;";
		$data = $this->runRequest($sql, array($idform));
		if ($data->rowCount () == 1)
		{
			return  $data->fetch ();
			}
		else{
			return "not found";
		}
	}
	
     public function updateliste($idform, $datedemande, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime){
		$sql = "update neurinfo set datedemande=?, numerofiche=?, type=?, titre=?, acronyme=?, typeactivite=?, nac=?,  cprenom=?, cnom=?, cfonction=?, cmail=?, ctel=?, promoteur=?, infos=?, crolibelle=?, cri=?, opglibelle=?, opgcoordonee=?, arcprenom=?, arcnom=?, arcfonction=?, arcmail=?, arctel=?, rsre=?, cstns=?, cstnt=?, cpp=?, cppnumero=?, resume=?, objectif=?, experimentation=?, protocolimagerie=?, traitementdonnee=?, resultatattendu=?, publicationenvisage=?, motcle=?, temoins=?, patient=?, fantome=?, responsablerecru=?, protocoleinjecte=?, nbrexam=?, duree=?, dureetotale=?, planification=?, numerovisite=?, commentaire=?, datedemarage=?, dureeetude=?, contrainte=?, programmation=?, cotation=?, rhlme=?, rhlmn=?, aedsm=?, gamds=?, aaodn=?, cspn=?, ndlcdn=?, caf=?, mddedmedr=?, mmdde=?, coutestime=?  where idform=?" ;
		$this->runRequest($sql, array($datedemande, $numerofiche, $type, $titre, $acronyme, $typeactivite, $nac,  $cprenom, $cnom, $cfonction, $cmail, $ctel, $promoteur, $infos, $crolibelle, $cri, $opglibelle, $opgcoordonee, $arcprenom, $arcnom, $arcfonction, $arcmail, $arctel, $rsre, $cstns, $cstnt, $cpp, $cppnumero, $resume, $objectif, $experimentation, $protocolimagerie, $traitementdonnee, $resultatattendu, $publicationenvisage, $motcle, $temoins, $patient, $fantome, $responsablerecru, $protocoleinjecte, $nbrexam, $duree, $dureetotale,  $planification, $numerovisite, $commentaire, $datedemarage, $dureeetude, $contrainte, $programmation, $cotation, $codecouleur, $rhlme, $rhlmn, $aedsm, $gamds, $aaodn, $cspn, $ndlcdn, $caf, $mddedmedr, $mmdde, $coutestime, $idform));
	}

	//function permettant de prendre toute les informations de la base de données appropriées au idform passé en paramettre 
	public function showdonnee($idform){
		$sql = "select * from neurinfo where idform=?;";
		$data = $this->runRequest($sql, array($idform));
		if ($data->rowCount () == 1)
		{
			return  $data->fetch ();
			}
		else{
			return "not found";
		}
	}
	
     public function delete($idform){
		$sql="DELETE FROM `sygrrif`.`neurinfo` WHERE  `neurinfo`.`idform` = ?";
		$this->runRequest($sql, array($idform));
	}
	
}