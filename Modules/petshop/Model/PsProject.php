<?php

require_once 'Framework/Model.php';

class PsProject extends Model {

    public function createTable() {

        $sql = "CREATE TABLE IF NOT EXISTS `ps_projects` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(200) NOT NULL,
            `id_unit` int(11) NOT NULL,
            `id_responsible` int(11) NOT NULL,
            `date_de_lancement` date NOT NULL,
            `date_envoi` date NOT NULL,
            `date_rencontre_commite` date NOT NULL,
            `type_animal` int(11) NOT NULL,
            `nbr_animaux` int(11) NOT NULL,
            `nbr_procedures` int(11) NOT NULL,
            `type_procedure` int(11) NOT NULL,
            `type_project` int(11) NOT NULL,
            `date_reel_lancement` date NOT NULL,
            `type_secteur` varchar(60) NOT NULL,
            `no_projet` varchar(30) NOT NULL,
            `user1` int(11) NOT NULL,
            `user2` int(11) NOT NULL,
            `souche_lignee` varchar(150) NOT NULL,
            `chirurgie` varchar(3) NOT NULL,
            `date_closed` date NOT NULL,
            PRIMARY KEY (`id`)
		);";

        $this->runRequest($sql);
    }

    public function getAllInfo($type = 0) {
        $sql = "SELECT ps_projects.*, core_units.name as unit_name, ps_types.name as animal_type
                FROM ps_projects
                INNER JOIN ps_types AS ps_types ON ps_projects.type_animal = ps_types.id
                INNER JOIN core_units AS core_units ON ps_projects.id_unit = core_units.id";
        if ($type != 0) {
            $sql .= " WHERE ps_projects.type_project=?";
            return $this->runRequest($sql, array($type))->fetchAll();
        } else {
            return $this->runRequest($sql)->fetchAll();
        }
    }
    
    public function getByResponsible($id){
        $sql = "SELECT * FROM ps_projects WHERE id_responsible=?";
        return $this->runRequest($sql, array($id))->fetchAll();
    }
    
    public function getAllOpenedClosedInfo($type = 0, $closed = false) {
        
        
        $sql = "SELECT ps_projects.*, core_units.name as unit_name, ps_types.name as animal_type
                FROM ps_projects
                INNER JOIN ps_types AS ps_types ON ps_projects.type_animal = ps_types.id
                INNER JOIN core_units AS core_units ON ps_projects.id_unit = core_units.id";
        if ($type != 0) {
            if ($closed){
                $sql .= " WHERE ps_projects.type_project=? AND ps_projects.date_closed!=?";
            }
            else{
                $sql .= " WHERE ps_projects.type_project=? AND ps_projects.date_closed=?";
            }
            return $this->runRequest($sql, array($type, "0000-00-00"))->fetchAll();
        } else {
            if ($closed){
                $sql .= " WHERE ps_projects.date_closed!=?";
            }
            else{
                $sql .= " WHERE ps_projects.date_closed=?";
            }
            return $this->runRequest($sql, array("0000-00-00"))->fetchAll();
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM ps_projects WHERE id = ?";
        $this->runRequest($sql, array($id));
    }

    public function getDefault() {
        return array(
            "id" => 0,
            "name" => "",
            "id_unit" => 0,
            "id_responsible" => 0,
            "date_de_lancement" => "",
            "date_envoi" => "",
            "date_rencontre_commite" => "",
            "type_animal" => 1,
            "nbr_animaux" => 0,
            "nbr_procedures" => 0,
            "type_procedure" => 1,
            "type_project" => 1,
            "date_reel_lancement" => "",
            "type_secteur" => "",
            "no_projet" => "",
            "user1" => 0,
            "user2" => 0,
            "souche_lignee" => "",
            "chirurgie" => "",
            "date_closed" => ""
        );
    }

    public function get($id) {
        $sql = "SELECT * FROM ps_projects WHERE id=?";
        return $this->runRequest($sql, array($id))->fetch();
    }

    public function set($id, $name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed) {
        if (!$this->exists($id)) {
            return $this->add($name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed);
        } else {
            return $this->edit($id, $name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed);
        }
    }

    public function exists($id) {
        $sql = "select * from ps_projects where id=?";
        $unit = $this->runRequest($sql, array($id));
        if ($unit->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function add($name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed) {

        $sql = "INSERT INTO ps_projects (name, no_projet, id_unit, id_responsible, user1, user2, date_envoi, date_rencontre_commite,
                        type_animal, souche_lignee, nbr_animaux, nbr_procedures, type_procedure,
                        chirurgie, type_project, date_reel_lancement, date_closed) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $this->runRequest($sql, array($name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite,
            $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure,
            $chirurgie, $type_project, $date_reel_lancement, $date_closed));
        return $this->getDatabase()->lastInsertId();
    }

    public function edit($id, $name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite, $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure, $chirurgie, $type_project, $date_reel_lancement, $date_closed) {

        $sql = "UPDATE ps_projects SET name=?, no_projet=?, id_unit=?, id_responsible=?, user1=?, user2=?, date_envoi=?, 
                                       date_rencontre_commite=?, type_animal=?, souche_lignee=?, nbr_animaux=?, 
                                       nbr_procedures=?, type_procedure=?, chirurgie=?, type_project=?, 
                                       date_reel_lancement=?, date_closed=?
                                  WHERE id=?";
        $this->runRequest($sql, array($name, $no_projet, $id_unit, $id_responsible, $user1, $user2, $date_envoi, $date_rencontre_commite,
            $type_animal, $souche_lignee, $nbr_animaux, $nbr_procedures, $type_procedure,
            $chirurgie, $type_project, $date_reel_lancement, $date_closed, $id));
        return $id;
    }

}
