<?php
require_once 'Framework/Model.php';



class Utilisateur extends Model{
	public function setUtilisateur($nom, $prenom, $identifiant, $mdp, $courrier, $tel, $status, $charte){
		$this->addUser($nom, $prenom, $identifiant, $mdp, $courrier, $tel, $status, $charte);
	}
	public  function addUser($nom, $prenom, $identifiant, $mdp, $courrier, $tel, $status, $charte)
	{
		$sql= "insert into projet_utilisateur(nom, prenom, identifiant, mdp, courrier, tel, status, charte)"."values(?,?,?,?,?,?,?,?);";
		$user = $this->runRequest($sql, array($nom, $prenom, $identifiant, $mdp, $courrier, $tel, $status, $charte));		
	
	}
public function UpdateUser($id, $nom, $prenom, $identifiant, $courrier, $tel, $status, $charte){
		$sql="UPDATE projet_utilisateur SET nom=?, prenom=?, identifiant=?, courrier=?, tel=?, status=?, charte=? where id=?";
		$this->runRequest($sql, array($nom, $prenom, $identifiant, $courrier, $tel, $status, $charte, $id));
	}
	public function getUser($id){
		$sql = "select * from projet_utilisateur where id=?;";
		$data = $this->runRequest($sql, array($id));
		return  $data->fetch();
		
	}
	public function getUserModif()
	{
		$sql ="select * from projet_utilisateur ";
		$req = $this-> runRequest($sql);
		return $req->fetchAll();
	}
	
	public function deletUser($id){
		$sql="DELETE FROM projet_utilisateur WHERE id = ?";
		$req = $this->runRequest($sql, array($id));
	}
}