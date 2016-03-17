<?php
require_once 'Framework/Controller.php';
require_once 'Modules/anticorps/Model/AcProtocol.php';
require_once 'Modules/anticorps/Model/Anticorps.php';
require_once 'Modules/anticorps/Model/Isotype.php';
require_once 'Modules/anticorps/Model/Organe.php';
require_once 'Modules/anticorps/Model/Tissus.php';
require_once 'Modules/anticorps/Model/Espece.php';
require_once 'Modules/anticorps/Model/Prelevement.php';
require_once 'Modules/anticorps/Model/Kit.php';
require_once 'Modules/anticorps/Model/Proto.php';
require_once 'Modules/anticorps/Model/Fixative.php';
require_once 'Modules/anticorps/Model/AcOption.php';
require_once 'Modules/anticorps/Model/Enzyme.php';
require_once 'Modules/anticorps/Model/Dem.php';
require_once 'Modules/anticorps/Model/Aciinc.php';
require_once 'Modules/anticorps/Model/Linker.php';
require_once 'Modules/anticorps/Model/Inc.php';
require_once 'Modules/anticorps/Model/Acii.php';
require_once 'Modules/core/Model/CoreUser.php';
require_once 'Modules/sprojects/Model/SpProject.php';

require_once 'externals/PHPExcel/Classes/PHPExcel.php';

class ControllerSynchistopproj extends Controller {

	// affiche la liste des Sources
	public function index() {	

		$dsn_grr = 'mysql:host=localhost;dbname=sygrrif2_h2p2;charset=utf8';
		$login_grr = "root";
		$pwd_grr = "root";
		
		$pdo_grr = new PDO($dsn_grr, $login_grr, $pwd_grr,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		
		$this->copyprojectsEntries($pdo_grr);
		echo "add projects entries done <br/>";
		
	}
        
	public function copyprojectsEntries($pdo_grr){
		$sql = "select * from sp_projects_entries";
		$entry_oldq = $pdo_grr->query($sql);
		$entries_old = $entry_oldq->fetchAll();
		
                $modelEntry = new SpProject();
		foreach ($entries_old as $entry){
                        echo "curent entry = " . $entry["id"] . "<br/>";
                        $content = $entry["content"];
                        $contentArray = explode(";", $content);
                        foreach($contentArray as $contentEntry){
                            $entryInfo = explode("=", $contentEntry);
                            if (count($entryInfo) == 2){
                                if ($entryInfo[1] != ""){
                                    $id_proj = $entry["id_proj"];
                                    $cdate = $entry["date"];
                                    $ciditem = $entryInfo[0];
                                    $cquantity = $entryInfo[1]; 
                                    $cinvoiceid = 0;
                                    $modelEntry->addProjectEntry($id_proj, $cdate, $ciditem, $cquantity, $cinvoiceid);

                                
                                }
                            }
                        }
		}
	}
	
	
}
?>