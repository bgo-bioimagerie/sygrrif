<?php

require_once 'Framework/ModelGRR.php';
require_once 'Modules/sygrrif/Model/SyUnitPricing.php';
require_once("PHPExcel/Classes/PHPExcel.php");

/**
 * Class defining the Sygrrif pricing model
 *
 * @author Sylvain Prigent
 */
class SyBillGenerator extends ModelGRR {
	
	public function generate($searchDate_start, $searchDate_end, $unit_id, $responsible_id){
		
		
		// /////////////////////////////////////////// // 
		//        get the input informations           //
		// /////////////////////////////////////////// //
		// convert start date to unix date
		$tabDate = explode("-",$searchDate_start);
		$date_debut = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_start= mktime(0,0,0,$tabDate[1],$tabDate[2],$tabDate[0]);
		
		// convert end date to unix date
		$tabDate = explode("-",$searchDate_end);
		$date_fin = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
		$searchDate_end= mktime(0,0,0,$tabDate[1],$tabDate[2]+1,$tabDate[0]);
		
		// get the lab info
		$unitPricingModel = new SyUnitPricing();
		$LABpricingid = $unitPricingModel->getPricing($unit_id);
		
		$sql = 'SELECT id FROM grr_overload WHERE fieldname="Personnel"';
		$req = $this->runRequest($sql);
		$tarif_overload = $req->fetchAll();
		
		
		// ///////////////////////////////////////// //
		//             Main query                    //
		// ///////////////////////////////////////// //
		// get the list of users in the selected period
		$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end);
		$sql = 'SELECT DISTINCT beneficiaire FROM grr_entry WHERE
				(start_time <:start AND end_time <= :end AND end_time>:start) OR
				(start_time >=:start AND end_time <= :end) OR
				(start_time >=:start AND start_time<:end AND end_time > :end) ORDER BY id';
		$req = $this->runRequest($sql, $q);
		$beneficiaire = $req->fetchAll();	// Liste des bénéficiaire dans la période séléctionée
		
		$i=0;
		foreach($beneficiaire as $b){
			// user info
			$modelUser = new User();
			$nomPrenom = $modelUser->getUserFromlup(strtolower($b[0]), $unit_id, $responsible_id);
			// name, firstname, id_responsible
			if (count($nomPrenom) != 0){
				$people[0][$i] = $nomPrenom[0]["name"]; 	//Nom du beneficiaire
				$people[1][$i] = $nomPrenom[0]["firstname"]; 	//Prénom du bénéficiaire
				$people[2][$i] = $b[0];				//Login du bénéficiaire
				$people[3][$i] = $nomPrenom[0]["id_responsible"];	//Responsable du bénéficiaire
				$people[4][$i] = $LABpricingid;	//Tarif appliqué
				$i++;
			}
		}
		array_multisort($people[0],SORT_ASC,$people[1],$people[2],$people[3],$people[4]);
		
		$sql = 'SELECT * FROM grr_room ORDER BY room_name';
		$req = $this->runRequest($sql);
		$equipement = $req->fetchAll();
		
		$i=0;
		foreach($equipement as $e){
			$numResTotal = 0;
			$heureTotal = 0;
			$heureResTotalJour = 0;
			$heureResTotalNuit = 0;
			$heureResTotalWeJour = 0;
			$heureResTotalWeNuit = 0;
					
			$heureTotalVrai = 0;
			$heureResTotalNuitVrai = 0;
			$heureResTotalWeJourVrai = 0;
			$heureResTotalWeNuitVrai = 0;
		
			$pricingModel = new SyPricing();
			for ($j = 0; $j < count($people[0]); $j++) {
				$descriptionTarif = $pricingModel->getPricing($people[4][$j]);

				// get the pricing info for this unit
				$tarif_id = $LABpricingid;
				$tarif_name = $descriptionTarif['tarif_name'];
				$tarif_unique = $descriptionTarif['tarif_unique'];
				$tarif_nuit = $descriptionTarif['tarif_night'];
				$tarif_we = $descriptionTarif['tarif_we'];
				$night_start = $descriptionTarif['night_start'];
				$night_end = $descriptionTarif['night_end'];
				$we_array = explode(",", $descriptionTarif['choice_we']);
				
				// get the pricing for the curent resource
				$modelRessourcePricing = new SyResourcePricing();
				$res = $modelRessourcePricing->getPrice($e[0], $tarif_id);
				$tarif_horaire_jour = $res['price_day'];	//Tarif jour pour l'utilisateur sélectionné
				$tarif_horaire_nuit = $res['price_night'];	//Tarif nuit pour l'utilisateur sélectionné
				$tarif_horaire_we = $res['price_we'];		//Tarif w-e pour l'utilisateur sélectionné

				//Informations sur le domaine de de la ressource
				$q = array('id'=>$e[1]);
				$sql = 'SELECT * FROM grr_area WHERE id=?';
				$req = $this->runRequest($sql, array($e[1]));
				$descriptionDomaine = $req->fetchAll();
				$resolutionDomaine = $descriptionDomaine[0][8];

				//---------
				//ResBefore : Réservation qui commence avant la période sélectionée et se termine dans la période sélectionnée
				$q = array('start'=>$searchDate_start, 'end'=>$searchDate_end, 'room_id'=>$e[0], 'beneficiaire'=>$people[2][$j]);
				$sql = 'SELECT start_time, end_time, overload_desc FROM grr_entry WHERE start_time <:start AND end_time <= :end AND end_time>:start AND room_id=:room_id AND beneficiaire=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resBefore = $req->fetchAll();
				$numResBefore = $req->rowCount();

				$heureBeforeJour = 0;
				$honoraireBeforeJour = 0;
				$heureBeforeNuit = 0;
				$honoraireBeforeNuit = 0;
				$heureBeforeWeJour = 0;
				$honoraireBeforeWeJour = 0;
				$heureBeforeWeNuit = 0;
				$honoraireBeforeWeNuit = 0;
				foreach($resBefore as $rB){
					$progress = $searchDate_start;
					while ($progress < $rB[1]){
						$progress += $resolutionDomaine;
						if (in_array(date('N',$progress),$we_array)){
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureBeforeWeJour += $resolutionDomaine/3600;
							} else {
								$heureBeforeWeNuit += $resolutionDomaine/3600;
							}
						} else {
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureBeforeJour += $resolutionDomaine/3600;
							} else {
								$heureBeforeNuit += $resolutionDomaine/3600;
							}
						}
					}
				}
				$heureBeforeVrai = $heureBeforeJour + $heureBeforeNuit + $heureBeforeWeJour + $heureBeforeWeNuit;
				$heureBefore = $heureBeforeJour + ($heureBeforeNuit/2) + ($heureBeforeWeJour/2) + ($heureBeforeWeNuit/2);
				//---------
				//ResIn : Réservation qui commence ET se termine dans la période sélectionnée
				$sql = 'SELECT start_time, end_time, overload_desc FROM grr_entry WHERE start_time >=:start AND end_time <= :end AND room_id=:room_id AND beneficiaire=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resIn = $req->fetchAll();
				$numResIn = $req->rowCount();

				$heureInJour = 0;
				$honoraireInJour = 0;
				$heureInNuit = 0;
				$honoraireInNuit = 0;
				$heureInWeJour = 0;
				$honoraireInWeJour = 0;
				$heureInWeNuit = 0;
				$honoraireInWeNuit = 0;
				foreach($resIn as $rI){
					if (strpos($rI[2],"@2@")) {
						$tarif_majoration = urldecode(substr($rI[2],strpos($rI[2],"@2@")+3,strpos($rI[2],"@/2@")-strpos($rI[2],"@2@")-3));
					} else {
						$tarif_majoration = 0;
					}
					$progress = $rI[0];
					while ($progress < $rI[1]){
						$progress += $resolutionDomaine;
						if (in_array(date('N',$progress),$we_array)){
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureInWeJour += $resolutionDomaine/3600;
							} else {
								$heureInWeNuit += $resolutionDomaine/3600;
							}
						} else {
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureInJour += $resolutionDomaine/3600;
							} else {
								$heureInNuit += $resolutionDomaine/3600;
							}
						}
					}
				}
				$heureInVrai = $heureInJour + $heureInNuit + $heureInWeJour + $heureInWeNuit;
				$heureIn = $heureInJour + ($heureInNuit/2) + ($heureInWeJour/2) + ($heureInWeNuit/2);
				//---------
				//ResAfter : Réservation qui commence dans la période sélectionnée et se termine après la période sélectionnée
				$sql = 'SELECT start_time, end_time, overload_desc FROM grr_entry WHERE start_time >=:start AND start_time<:end AND end_time > :end AND room_id=:room_id AND beneficiaire=:beneficiaire';
				$req = $this->runRequest($sql, $q);
				$resAfter = $req->fetchAll();
				$numResAfter = $req->rowCount();

				$heureAfterJour = 0;
				$honoraireAfterJour = 0;
				$heureAfterNuit = 0;
				$honoraireAfterNuit = 0;
				$heureAfterWeJour = 0;
				$honoraireAfterWeJour = 0;
				$heureAfterWeNuit = 0;
				$honoraireAfterWeNuit = 0;
				foreach($resAfter as $rA){
					$progress = $rA[0];
					while ($progress < $searchDate_end){
						$progress += $resolutionDomaine;
						if (in_array(date('N',$progress),$we_array)){
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureAfterWeJour += $resolutionDomaine/3600;
							} else {
								$heureAfterWeNuit += $resolutionDomaine/3600;
							}
						} else {
							if ((date('H',$progress)>$night_end) && (date('H',$progress) <= $night_start)){
								$heureAfterJour += $resolutionDomaine/3600;
							} else {
								$heureAfterNuit += $resolutionDomaine/3600;
							}
						}
					}
				}
				$heureAfterVrai = $heureAfterJour + $heureAfterNuit + $heureAfterWeJour + $heureAfterWeNuit;
				$heureAfter = $heureAfterJour + ($heureAfterNuit/2) + ($heureAfterWeJour/2) + ($heureAfterWeNuit/2);
				//---------
		
				$numResBeneficiaire = $numResIn + $numResAfter;
				//$numResBeneficiaire = $numResBefore + $numResIn;
				$heureResBeneficiaire = $heureIn + $heureAfter;
				//$heureResBeneficiaire = $heureBefore + $heureIn;
				$heureResBeneficiaireJour = $heureInJour + $heureAfterJour;
				//$heureResBeneficiaireJour = $heureBeforeJour + $heureInJour;
				$heureResBeneficiaireNuit = ($heureInNuit/2) + ($heureAfterNuit/2);
				//$heureResBeneficiaireNuit = $heureBeforeNuit + $heureInNuit;
				$heureResBeneficiaireWeJour = ($heureInWeJour/2) + ($heureAfterWeJour/2);
				//$heureResBeneficiaireWeJour = $heureBeforeWeJour + $heureInWeJour;
				$heureResBeneficiaireWeNuit = ($heureInWeNuit/2) + ($heureAfterWeNuit/2);
				//$heureResBeneficiaireWeNuit = $heureBeforeWeNuit + $heureInWeNuit;
		
				$heureResBeneficiaireVrai = $heureInVrai + $heureAfterVrai;
				//$heureResBeneficiaireVrai = $heureBeforeVrai + $heureInVrai;
				$heureResBeneficiaireNuitVrai = $heureInNuit + $heureAfterNuit;
				//$heureResBeneficiaireNuit = $heureBeforeNuit + $heureInNuit;
				$heureResBeneficiaireWeJourVrai = $heureInWeJour + $heureAfterWeJour;
				//$heureResBeneficiaireWeJour = $heureBeforeWeJour + $heureInWeJour;
				$heureResBeneficiaireWeNuitVrai = $heureInWeNuit + $heureAfterWeNuit;
				//$heureResBeneficiaireWeNuit = $heureBeforeWeNuit + $heureInWeNuit;
		
		
				$beneficiaire[$j][$e[0]][0] = $numResBeneficiaire;			//nombre de réservations par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][1] = $heureResBeneficiaire;		//nombre d'heures réservées par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][2] = $tarif_unique;
				$beneficiaire[$j][$e[0]][3] = $tarif_nuit;
				$beneficiaire[$j][$e[0]][4] = $tarif_we;
				$beneficiaire[$j][$e[0]][5] = $heureResBeneficiaireJour;
				$beneficiaire[$j][$e[0]][6] = $heureResBeneficiaireNuit;
				$beneficiaire[$j][$e[0]][8] = $heureResBeneficiaireWeJour;
				$beneficiaire[$j][$e[0]][9] = $heureResBeneficiaireWeNuit;
				$beneficiaire[$j][$e[0]][10] = $tarif_horaire_jour;
				$beneficiaire[$j][$e[0]][11] = $tarif_horaire_nuit;
				$beneficiaire[$j][$e[0]][12] = $tarif_horaire_we;

				$beneficiaire[$j][$e[0]][13] = $heureResBeneficiaireVrai; //nombre d'heures "Vrai" réservées par bénéficiaire et par équipement
				$beneficiaire[$j][$e[0]][14] = $heureResBeneficiaireNuitVrai;
				$beneficiaire[$j][$e[0]][15] = $heureResBeneficiaireWeJourVrai;
				$beneficiaire[$j][$e[0]][16] = $heureResBeneficiaireWeNuitVrai;
		
				$numResTotal += $numResBeneficiaire;
				$heureTotal += $heureResBeneficiaire;
				$heureResTotalJour += $heureResBeneficiaireJour;
				$heureResTotalNuit += $heureResBeneficiaireNuit;
				$heureResTotalWeJour += $heureResBeneficiaireWeJour;
				$heureResTotalWeNuit += $heureResBeneficiaireWeNuit;
		
				$heureTotalVrai += $heureResBeneficiaireVrai;
				$heureResTotalNuitVrai += $heureResBeneficiaireNuitVrai;
				$heureResTotalWeJourVrai += $heureResBeneficiaireWeJourVrai;
				$heureResTotalWeNuitVrai += $heureResBeneficiaireWeNuitVrai;
		
		
			}
			if ($numResTotal != 0){
				$room[0][$i] = $e[0]; 					//id de la room
				$room[1][$i] = $e[2]; 					//nom de la room
				$room[2][$i] = $numResTotal; 			//nombre de réservations sur la room
				$room[3][$i] = $heureTotal; 			//nombre d'heures réservées sur la room
				$room[4][$i] = $heureResTotalJour;		//nombre d'heures réservées sur la room pendant la période jour
				$room[5][$i] = $heureResTotalNuit;		//nombre d'heures réservées sur la room pendant la période nuit / 2 (divisé par 2)
				$room[6][$i] = $heureResTotalWeJour;	//nombre d'heures réservées sur la room pendant la période w-e jour / 2 (divisé par 2)
				$room[7][$i] = $heureResTotalWeNuit;	//nombre d'heures réservées sur la room pendant la période w-e nuit / 2 (divisé par 2)
		
				$room[8][$i] = $heureTotalVrai;
				$room[9][$i] = $heureResTotalNuitVrai;
				$room[10][$i] = $heureResTotalWeJourVrai;
				$room[11][$i] = $heureResTotalWeNuitVrai;
		
				$i++;
			}
		}
		$numOfEquipement = count($room[0]);
		
		
		// /////////////////////////////////////////// //
		//             pdf output                      //
		// /////////////////////////////////////////// //
		ob_start();
		?>
		<link rel="stylesheet" type="text/css" href="css/pdf.css" />
		<style type="text/css">
			table { display:block; width:100%; border: 1px solid #000000; }
			td.footer-left { width:20%; text-align: left; border: 0px solid #000000; }
			td.footer-center { width:60%; text-align: center; border: 0px solid #000000;font-size: 10px; font-family:times;}
			td.footer-right { width:20%; text-align: right; border: 0px solid #000000; }
		
			td.header-left { width:40%; text-align: left; border: 0px solid #000000; font-size: 20px; font-family:times; }
			td.header-right { width:60%; text-align: right; border: 0px solid #000000; font-size: 20px; font-family:times; }
			
			
			
			td.entete-left { width:40%; text-align: center; border: 0px solid #000000; font-size: 15px; font-family:times;}
			td.entete-right { width:60%; text-align: center; border: 0px solid #000000; font-size: 15px; font-family:times;}
		
			td.ref { width:100%; text-align: left; border: 1px solid #000000; font-size: 15px; font-family:times;}
			td.ref2 { width:20%; text-align: center; border: 1px solid #000000; font-size: 15px; font-family:times;}
			#titre { text-align: center; padding-top: 10px; padding-bottom: 10px; font-size: 20px; font-family:times; }
			td.head { text-align: center; font-size: 15px; font-weight: bold; font-family:times; }
			td.resultat { text-align:center; padding-top: 1px; padding-bottom: 1px; font-size: 12px;font-family:times;}
			td.bilan { padding: 0px; font-size: 15px; font-family:times;}
			
		</style>
		<page backtop="100" backleft="5" backright="5" backbottom="20">
			<page_header>
				<table style="border: none;">
					<tr>
						<td class="entete-left">
							<img src="./Themes/logo_h2p2.jpg" alt="H2P2" border="0" style="width: 150px;"/><br/><br/>
						</td>
						<td class="entete-right" style="font-size: 25px; font-weight: bold;">
							Rennes le <?php echo date('d/m/Y') ?><br/><br/>
							AVIS DES SOMMES A PAYER
						</td>
					</tr>
					<tr>
						<td class="entete-left" style="border: 1px solid #000000">
							Structure fédérative de recherche Biosit<br/>
							UMS 3480 / US 018<br/>
							Université de Rennes 1<br/>
							2 av. du Prof. Léon Bernard<br/>
							CS 34317<br/>
							35043 Rennes cedex
						</td>
						<td class="entete-right" rowspan="2" style="margin-left: 220px; border: 1px solid #000000">
								<?php echo utf8_decode(nl2br($responsable))."<br/>".utf8_decode(nl2br($LAB[0][1])); ?>
						</td>
					</tr>
					<tr>
						<td class="entete-left">
							Personne à contacter :<br/>
							Alain FAUTREL<br/>
							Tél. : 02.23.23.47.95
						</td>
					</tr>
					<tr>
						<td colspan="2" class="entete-right">
							<br/>P.F. Histopathologie Haute Précision
							<table style="width: 100%;">
								<tr>
									<td class="ref2">
										U.B.
									</td>
									<td class="ref2">
										Année
									</td>
									<td class="ref2">
										CR
									</td>
									<td class="ref2">
										Dest
									</td>
									<td class="ref2">
										Compte crédité
									</td>
								</tr>
								<tr>
									<td class="ref2">
										453
									</td>
									<td class="ref2">
										2014
									</td>
									<td class="ref2">
										12PL514-03
									</td>
									<td class="ref2">
										R3
									</td>
									<td class="ref2">
										7062
									</td>
								</tr>
		
							</table>
							<div style="text-align: right">
								(Référence à rappeler)
							</div>
						</td>
					</tr>
				</table>
			</page_header>
		
			<page_footer>
				<hr />
				<table style="border: none;">
					<tr>
						<td class="footer-left">
						</td>
						<td class="footer-center">
							Page [[page_cu]]/[[page_nb]]
						</td>
						<td class="footer-right">
						</td>
					</tr>
					<tr>
						<td class="footer-left">
							<img src="./Themes/logo_universite.jpg" alt="H2P2" border="0" style="width: 100px;"/>
						</td>
						<td class="footer-center">
							n° SIRET : 193 509 361.00013 - code APE : 803Z - n°TVA : FR 70 193509361<br/>
							Somme à verser à l'ordre de l'Agent Comptable de l'Université de Rennes 1<br/>
							Domiciliation bancaire : TP RENNES TRESORERIE GENERALE : 10071 35000 00001000001 35<br/>
						</td>
						<td class="footer-right">
							<img src="./Themes/logo_biosit.jpg" alt="H2P2" border="0" style="width: 100px;"/>
						</td>
					</tr>
				</table>
			</page_footer>
		
			
			<?php
				if ($date_debut == $date_fin){
					echo '<div id="titre">Réservations du '.$date_debut.'</div>';
				} else {
					echo '<div id="titre">Réservations du '.$date_debut.' au '.$date_fin.'</div>';
				}
			?>
			<table cellpadding="0" cellspacing="0" style="border: 1px solid #000000";>
				<tr>
					<td class="head" style="width: 28%; border-right: 1px solid #000000;">
						Equipement
					</td>
					<td class="head" style="width: 28%; border-right: 1px solid #000000;">
						Utilisateur
					</td>
					<td class="head" style="width: 11%; border-right: 1px solid #000000;">
						Nombre de séances
					</td>
					<td class="head" style="width: 11%; border-right: 1px solid #000000;">
						Nombre d'heures
					</td>
					<td class="head" style="width: 11%; border-right: 1px solid #000000;">
						Tarif<br/>
						(€/h)
					</td>
					<td class="head" style="width: 11%">
						Montant
					</td>
				</tr>
			</table>			
			
			
			<table cellpadding="0" cellspacing="0" style="border-top: none; border-bottom: none;">
				<?php
					$honoraireTotal = 0;
					for ($j = 0; $j < $numOfEquipement; $j++) {
						if ($j%2) {
							$couleur="#ffffff";
						} else {
							$couleur="#F7F7F7";
						}
						if ($beneficiaire[0][$room[0][$j]][2] == 1){ 															// tarif unique = tarif jour
							//$jour = $room[3][$j];
							//$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
							//$honoraireTotal += $honoraire;
							//echo '<tr>';
							//echo '<td class="resultat" style="width: 30%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">'.$room[1][$j].'</td>';
							//echo '<td class="resultat" style="width: 15%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">'.$room[2][$j].'</td>';
							//echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">Jour</td>';
							//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$jour.'</td>';
							//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$beneficiaire[0][$room[0][$j]][10].'</td>';
							//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000">'.$honoraire.'</td>';
							//echo '</tr>';
							
							$jour = $room[3][$j];
							$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
							$honoraireTotal += $honoraire;
							$nBe = 0;
							$nBeArray = array();
							for ($p = 0; $p < count($people[0]); $p++) {
								if ($beneficiaire[$p][$room[0][$j]][0] != 0){
									$nBeArray[$nBe][0] = $people[0][$p].' '.$people[1][$p];
									$nBeArray[$nBe][1] = $beneficiaire[$p][$room[0][$j]][0];
									$nBeArray[$nBe][2] = $beneficiaire[$p][$room[0][$j]][1];
									$nBeArray[$nBe][3] = $beneficiaire[0][$room[0][$j]][10];
									$nBeArray[$nBe][4] = $beneficiaire[$p][$room[0][$j]][1]*$beneficiaire[$p][$room[0][$j]][10];
									$nBe++;
								}
							}
							echo '<tr style="background:'.$couleur.'">';
							echo '<td class="resultat" style="width: 28%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="'.$nBe.'">'.$room[1][$j].'</td>';
							for ($i = 0; $i < $nBe; $i++) {
								if ($i != 0) {
									echo '<tr style="background:'.$couleur.'">';
								}
								if ($i < ($nBe-1)){
									echo '<td class="resultat" style="width: 28%; border-bottom: 0px solid #000000; border-right: 1px solid #000000;">'.$nBeArray[$i][0].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 0px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][1].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 0px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][2].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 0px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][3].'</td>';
									echo '<td class="resultat" style="text-align: right; width: 11%; padding-right: 10px; border-bottom: 0px solid #000000">'.number_format(round($nBeArray[$i][4],2), 2, ',', ' ').'</td>';
								} else {
									echo '<td class="resultat" style="width: 28%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">'.$nBeArray[$i][0].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][1].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][2].'</td>';
									echo '<td class="resultat" style="width: 11%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$nBeArray[$i][3].'</td>';
									echo '<td class="resultat" style="text-align: right; width: 11%; padding-right: 10px; border-bottom: 1px solid #000000">'.number_format(round($nBeArray[$i][4],2), 2, ',', ' ').'</td>';
								}
								echo '</tr>';
							}
							
							
							
						} else {
							if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 0)){			// tarif jour + tarif nuit
								$jour = $room[4][$j]+$room[6][$j];
								$nuit = $room[5][$j]+$room[7][$j];
								$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10];
								$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11];
								$honoraireTotal += $honoraire_jour + $honoraire_nuit;
								echo '<td class="resultat" style="width: 15%">'.$jour.' (Jour)<br/>'.$nuit.' (Nuit)</td>';
								echo '<td class="resultat" style="width: 20%">'.$beneficiaire[0][$room[0][$j]][10].' (Jour)<br/>'.$beneficiaire[0][$room[0][$j]][11].' (Nuit)</td>';
								echo '<td class="resultat" style="width: 20%">'.$honoraire_jour.'<br/>'.$honoraire_nuit.'</td>';
							} else if (($beneficiaire[0][$room[0][$j]][3] == 0) && ($beneficiaire[0][$room[0][$j]][4] == 1)){	// tarif jour + tarif week-end
								$semaine = $room[4][$j]+$room[5][$j];
								$we = $room[6][$j]+$room[7][$j];
								$honoraire_semaine = $semaine*$beneficiaire[0][$room[0][$j]][10];
								$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
								$honoraireTotal += $honoraire_semaine + $honoraire_we;
								echo '<td class="resultat" style="width: 15%">'.$semaine.' (Semaine)<br/>'.$we.' (Week-end)</td>';
								echo '<td class="resultat" style="width: 20%">'.$beneficiaire[0][$room[0][$j]][10].' (Semaine)<br/>'.$beneficiaire[0][$room[0][$j]][12].' (Week-end)</td>';
								echo '<td class="resultat" style="width: 20%">'.$honoraire_semaine.'<br/>'.$honoraire_we.'</td>';
							} else if (($beneficiaire[0][$room[0][$j]][3] == 1) && ($beneficiaire[0][$room[0][$j]][4] == 1)){ 	// tarif jour + tarif nuit + tarif week-end
								$jour = $room[4][$j];
								$nuit = $room[5][$j];
								$we = $room[6][$j] + $room[7][$j];
								
								$nuitVrai = $room[9][$j];
								$weVrai = $room[10][$j] + $room[11][$j];
								
								$honoraire_jour = $jour*$beneficiaire[0][$room[0][$j]][10];
								$honoraire_nuit = $nuit*$beneficiaire[0][$room[0][$j]][11];
								$honoraire_we = $we*$beneficiaire[0][$room[0][$j]][12];
								$honoraireTotal += $honoraire_jour + $honoraire_nuit + $honoraire_we;
								
								$honoraire_nuitVrai = $nuitVrai*$beneficiaire[0][$room[0][$j]][11];
								$honoraire_weVrai = $weVrai*$beneficiaire[0][$room[0][$j]][12];
								$honoraireTotalVrai += $honoraire_jour + $honoraire_nuitVrai + $honoraire_weVrai;
								
								$nbTarif = 0;
								if ($jour) {
									$affichage[$nbTarif][0] = "Jour";
									$affichage[$nbTarif][1] = number_format(round($jour,2), 2, ',', ' ');
									$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][10],2), 2, ',', ' ');
									$affichage[$nbTarif][3] = number_format(round($honoraire_jour,2), 2, ',', ' ');
									$affichage[$nbTarif][4] = number_format(round($jour,2), 2, ',', ' ');
									$nbTarif++;
								}
								if ($nuit) { 
									$affichage[$nbTarif][0] = "Nuit";
									$affichage[$nbTarif][1] = number_format(round($nuit,2), 2, ',', ' ');
									$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][11],2), 2, ',', ' ');
									$affichage[$nbTarif][3] = number_format(round($honoraire_nuit,2), 2, ',', ' ');
									$affichage[$nbTarif][4] = number_format(round($nuitVrai,2), 2, ',', ' ');
									$nbTarif++;
								}
								if ($we) { 
									$affichage[$nbTarif][0] = "Week-end";
									$affichage[$nbTarif][1] = number_format(round($we,2), 2, ',', ' ');
									$affichage[$nbTarif][2] = number_format(round($beneficiaire[0][$room[0][$j]][12],2), 2, ',', ' ');
									$affichage[$nbTarif][3] = number_format(round($honoraire_we,2), 2, ',', ' ');
									$affichage[$nbTarif][4] = number_format(round($weVrai,2), 2, ',', ' ');
									$nbTarif++;
								}
								echo '<tr>';
								echo '<td class="resultat" style="width: 30%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="'.$nbTarif.'">'.$room[1][$j].'</td>';
								echo '<td class="resultat" style="width: 15%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="'.$nbTarif.'">'.$room[2][$j].'</td>';
								for ($n = 0; $n < $nbTarif; $n++) {
									if ($n == 0){
										if ($nbTarif == 1){
											echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000;border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
											//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
										} else{
											echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
											//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
										}
										echo '</tr>';
									} else{
										if (($n+1) == $nbTarif){
											echo '<tr>';
											echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
											//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
											echo '</tr>';
										
										} else{
											echo '<tr>';
											echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000;">'.$affichage[$n][0].'</td>';
											//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].' ('.$affichage[$n][4].')</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][1].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][2].'</td>';
											echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.$affichage[$n][3].' €</td>';
											echo '</tr>';
										}
									}
								}
								//echo '<tr>';
								//echo '<td class="resultat" style="width: 30%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="3">'.$room[1][$j].'</td>';
								//echo '<td class="resultat" style="width: 15%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;" rowspan="3">'.$room[2][$j].'</td>';
								//echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000;">Jour :</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($jour,2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000;border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($beneficiaire[0][$room[0][$j]][10],2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.number_format(round($honoraire_jour,2), 2, ',', ' ').' €</td>';
								//echo '</tr>';
								//echo '<tr>';
								//echo '<td class="resultat" style="width: 13%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000;">Nuit :</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($nuit,2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($beneficiaire[0][$room[0][$j]][11],2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px dashed #000000; padding-right: 10px; text-align: right;">'.number_format(round($honoraire_nuit,2), 2, ',', ' ').' €</td>';
								//echo '</tr>';
								//echo '<tr>';
								//echo '<td class="resultat" style="width: 13%; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">Week-end :</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($we,2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; border-right: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($beneficiaire[0][$room[0][$j]][12],2), 2, ',', ' ').'</td>';
								//echo '<td class="resultat" style="width: 14%; border-bottom: 1px solid #000000; padding-right: 10px; text-align: right;">'.number_format(round($honoraire_we,2), 2, ',', ' ').' €</td>';
								//echo '</tr>';
								
								//echo '<td class="resultat" style="width: 15%">'.$jour.' (Jour)<br/>'.$nuit.' (Nuit)<br/>'.$we.' (Week-end)</td>';
								//echo '<td class="resultat" style="width: 20%">'.$beneficiaire[0][$room[0][$j]][10].' (Jour)<br/>'.$beneficiaire[0][$room[0][$j]][11].' (Nuit)<br/>'.$beneficiaire[0][$room[0][$j]][12].' (Week-end)</td>';
								//echo '<td class="resultat" style="width: 20%; padding-right: 10px; text-align: right;">'.number_format(round($honoraire_jour,2), 2, ',', ' ').' €<br/>'.number_format(round($honoraire_nuit,2), 2, ',', ' ').' €<br/>'.number_format(round($honoraire_we,2), 2, ',', ' ').' €</td>';
							} else {
								$jour = $room[3][$j];
								$honoraire = $jour*$beneficiaire[0][$room[0][$j]][10];
								echo '<td class="resultat" style="width: 15%">'.$jour.'</td>';
								echo '<td class="resultat" style="width: 20%">'.$beneficiaire[0][$room[0][$j]][10].'</td>';
								echo '<td class="resultat" style="width: 20%">'.$honoraire.'</td>';
							}
						}
					}
				?>
			
			</table>
			<?php
			if ($people[4][0] != "Biosit"){
				$rs = 7;
			} else {
				$rs = 4;
			}
			?>
			<table cellpadding="0" cellspacing="0" style="border: 1px solid #000000;">
				<tr>
					<td class="bilan" rowspan="<?php echo $rs; ?>" style="text-align: justify; color:red; width: 56%; padding: 5px; border-right: 1px solid #000000;">
						ATTENTION: CECI N'EST PAS UNE FACTURE !<br/>
						Merci de bien vouloir retourner à Géraldine Gourmil (Biosit) ce document signé 
						avec la mention "Bon pour accord" accompagné d'un bon de commande établi sur le montant H.T. si paiement
						sur crédits UR1 ou T.T.C. si paiement sur autres crédits.
					</td>
					<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
						Total H.T.
					</td>
					<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
						<?php
							echo number_format(round($honoraireTotal,2), 2, ',', ' ')." €";
						?>
					</td>
				</tr>
			<?php
				if ($people[4][0] != "Biosit"){
			?>
					<tr>
						<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
							Frais de gestion :10%
						</td>
						<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
							<?php 
								$honoraireFrais = 0.1*$honoraireTotal;
								echo number_format(round($honoraireFrais,2), 2, ',', ' ')." €";
							?>
						</td>
					</tr>
					<tr>
						<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
							
						</td>
						<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
							----
						</td>
					</tr>
					<tr>
						<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
							<?php
								echo 'Total H.T.';
								if ($people[4][0] != "Biosit"){
									echo '<br/><span style="font-size: 8px;">(dont frais de gestion 10%)</span>';
								}
							?>
						</td>
						<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
							<?php
								if ($people[4][0] != "Biosit"){
									$honoraireFrais = 0.1*$honoraireTotal;
									$honoraireTotal += $honoraireFrais;
								}
								echo number_format(round($honoraireTotal,2), 2, ',', ' ')." €";
							?>
						</td>
					</tr>
					
					
			<?php
				}
			?>
				<tr>
					<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
						T.V.A.:20%
					</td>
					<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
						<?php 
							$honoraireTVA = 0.2*$honoraireTotal;
							$honoraireTVA = number_format(round($honoraireTVA,2), 2, '.', ' ');
							$honoraireTotal += $honoraireTVA;
							echo number_format(round($honoraireTVA,2), 2, ',', ' ')." €";
						?>
					</td>
				</tr>
				<tr>
					<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;">
						
					</td>
					<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right;">
						----
					</td>
				</tr>
				<tr>
					<td class="bilan" style="text-align: right; width: 25%; padding-right: 10px; border-right: 1px solid #000000;  font-weight: bold; font-size: 18px; ">
						Total T.T.C.
					</td>
					<td class="bilan" style="width: 19%; padding-right: 10px; text-align: right; font-weight: bold; font-size: 18px; ">
						<?php echo number_format(round($honoraireTotal,2), 2, ',', ' ')." €"; ?>
					</td>
				</tr>
			</table>			
		</page>	
		
		<?php
			$content = ob_get_clean();
			require_once('./html2pdf/html2pdf.class.php');
			//$pdf = new HTML2PDF('P','A4','fr',false,'ISO-8859-15',array(mL, mT, mR, mB));
		    $pdf = new HTML2PDF('P','A4','fr',false,'ISO-8859-15',array(5, 5, 5, 5));
			$pdf->pdf->SetDisplayMode('fullpage');
		    $pdf->WriteHTML($content);
		    $pdf->Output();
			//$pdf->Output('facture.pdf','D');
		
		
		
		
		
		// ///////////////////////////////////////// //
		//    Write the xls output file              //
		// ///////////////////////////////////////// //
		// create PHPExcel object
		
		
		/*
		$objPHPExcel = new PHPExcel;
		$objSheet = $objPHPExcel->getActiveSheet();
		
		// columns size
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('14.5');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('7.2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('6.6');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('13.9');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('5.18');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('9.77');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('13.9');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('11.42');
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		
		//On enregistre les modifications et on met en téléchargement le fichier Excel obtenu
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Facture.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		*/
		
	
	}
}
	
	
?>