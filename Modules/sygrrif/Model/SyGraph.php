<?php

require_once 'Framework/Model.php';

/**
 * Class defining the Sygrrif graph model
 *
 * @author Sylvain Prigent
 */
class SyGraph extends Model {

    /**
     * Generate a graph containing the number of reservation per month
     * @param unknown $year
     * @return multitype:multitype:unknown  number
     */
    public function getYearNumResGraph($month_start, $year_start, $month_end, $year_end) {

        $num = 0;
        $numTotal = 0;
        $graph = array();
        $monthIds = array();
        $i = 0;
        for ($y = $year_start; $y <= $year_end; $y++) {
            // start month
            $start_month = 1;
            if ($y == $year_start) {
                $start_month = $month_start;
            }
            // end month
            $stop_month = 12;
            if ($y == $year_end) {
                $stop_month = $month_end;
            }
            for ($m = $start_month; $m <= $stop_month; $m++) {
                $dstart = mktime(0, 0, 0, $m, 1, $y); // Le premier jour du mois en cours
                $dend = mktime(0, 0, 0, $m + 1, 1, $y); // Le 0eme jour du mois suivant == le dernier jour du mois en cour

                $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . $dstart . ' AND end_time <=' . $dend . ' ORDER by resource_id';
                $req = $this->runRequest($sql);
                $numMachinesFormesTotal = $req->rowCount();
                $machinesFormesListe = $req->fetchAll();

                $num = 0;
                foreach ($machinesFormesListe as $machine) {
                    // test if the resource still exists
                    $sql = 'SELECT name FROM sy_resources WHERE id ="' . $machine[0] . '"';
                    $req = $this->runRequest($sql);
                    $res = $req->fetchAll();
                    if (count($res) > 0) {
                        $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . $dstart . ' AND end_time <=' . $dend . ' AND resource_id ="' . $machine[0] . '"';
                        $req = $this->runRequest($sql);
                        $num += $req->rowCount();
                    }
                }

                $i++;
                $numTotal += $num;
                $graph[$i] = $num;
                $monthIds[$i] = $m;
            }
        }

        $graphData = array('numTotal' => $numTotal, 'graph' => $graph, 'monthIds' => $monthIds);
        return $graphData;
    }

    /**
     * Generate a graph containing the number of hours of reservation per year
     * @param unknown $year
     * @return multitype:number multitype:number
     */
    public function getYearNumHoursResGraph($month_start, $year_start, $month_end, $year_end) {

        $numTotal = 0;
        $dstart = mktime(0, 0, 0, $month_start, 1, $year_start); // Le premier jour du mois en cours
        $dend = mktime(0, 0, 0, $month_end + 1, 0, $year_end);
        $sql = "SELECT * FROM sy_calendar_entry WHERE start_time >=? AND end_time <=?";
        $req = $this->runRequest($sql, array($dstart, $dend));
        $ress = $req->fetchAll();
        foreach ($ress as $res) {
            if ($res["end_time"] - $res["start_time"] >= 0) {
                $numTotal += (float) ($res["end_time"] - $res["start_time"]) / (float) 3600;
            } else {
                echo "WARNING: error in reservation : <br/>";
                print_r($res);
            }
        }

        $timeResa = 0.0;
        $timeTotal = 0.0;
        $graph = array();
        $monthIds = array();
        $i = 0;
        for ($y = $year_start; $y <= $year_end; $y++) {
            // start month
            $start_month = 1;
            if ($y == $year_start) {
                $start_month = $month_start;
            }
            // end month
            $stop_month = 12;
            if ($y == $year_end) {
                $stop_month = $month_end;
            }
            for ($m = $start_month; $m <= $stop_month; $m++) {
                //echo "year = " . $y . " month = " . $m . "<br/>";
                $dstart = mktime(0, 0, 0, $m, 1, $y); // Le premier jour du mois en cours
                $dend = mktime(0, 0, 0, $m + 1, 0, $y); // Le 0eme jour du mois suivant == le dernier jour du mois en cour

                $sql = "SELECT * FROM sy_calendar_entry WHERE start_time >=? AND end_time <=?";
                //echo "req = " . $sql . "</br>";
                $req = $this->runRequest($sql, array($dstart, $dend));
                $resas = $req->fetchAll();
                //print_r($resas);
                $timeResa = 0.0;
                foreach ($resas as $resa) {
                    if ($resa["end_time"] - $resa["start_time"] >= 0) {
                        $timeResa += (float) ($resa["end_time"] - $resa["start_time"]) / (float) 3600;
                    } else {
                        echo "WARNING: error in reservation : <br/>";
                        print_r($resa);
                    }
                }
                $i++;
                $timeTotal += $timeResa;
                $graph[$i] = $timeResa;
                $monthIds[$i] = $m;
            }
        }

        /*
          $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . $dstart . ' AND end_time <=' . $dend . ' ORDER by resource_id';
          $req = $this->runRequest($sql);
          $numMachinesFormesTotal = $req->rowCount();
          $machinesFormesListe = $req->fetchAll();

          $timeResa = 0;
          foreach ($machinesFormesListe as $machine) {
          // test if the resource still exists
          $sql = 'SELECT name FROM sy_resources WHERE id ="' . $machine[0] . '"';
          $req = $this->runRequest($sql);
          $res = $req->fetchAll();
          if (count($res) > 0) {
          $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . $dstart . ' AND end_time <=' . $dend . ' AND resource_id ="' . $machine[0] . '"';
          $req = $this->runRequest($sql);
          $datas = $req->fetchAll();


          foreach ($datas as $data) {
          if ($data["end_time"] - $data["start_time"] >= 0) {
          $timeResa += (float) ($data["end_time"] - $data["start_time"]) / (float) 3600;
          } else {
          echo "WARNING: error in reservation : <br/>";
          print_r($data);
          }
          }
          }
          }
          $i++;
          $timeTotal += $timeResa;
          $graph[$i] = $timeResa;
          $monthIds[$i] = $m;
          }
          }
         */
        $numTotal = round($numTotal);
        $graphData = array('timeTotal' => $numTotal, 'graph' => $graph, 'monthIds' => $monthIds);
        return $graphData;
    }

    /**
     * Generate a pie chart number of reservation per resource
     * @param number $year
     * @return unknown
     */
    public function getCamembertArray($month_start, $year_start, $month_end, $year_end) {
        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 0, $year_end) . ' ORDER by resource_id';
        $req = $this->runRequest($sql);
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        $machineFormes = array();
        $i = -1;
        foreach ($machinesFormesListe as $mFL) {
            $i++;
            $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 1, $year_end) . ' AND resource_id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $numMachinesFormes[$i][0] = $mFL[0];
            $numMachinesFormes[$i][1] = $req->rowCount();

            $sql = 'SELECT name FROM sy_resources WHERE id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $res = $req->fetchAll();
            $nomMachine = "-";
            if (count($res) > 0) {
                $nomMachine = $res[0][0];
            }

            $numMachinesFormes[$i][0] = $nomMachine;
        }
        return $numMachinesFormes;
    }

    private function calculateReservationTime($searchDate_start, $searchDate_end, $night_start, $night_end, $we_array, $is_unique_price) {

        if ($is_unique_price) {
            if ($searchDate_end > $searchDate_start) {
                //echo "date s= " . $searchDate_start . ", date e= " . $searchDate_end . "</br>";
                return array((float) ($searchDate_end - $searchDate_start) / (float) 3600, 0, 0);
            } else {
                return array(0, 0, 0);
            }
        } else {

            $gap = 60;
            $timeStep = $searchDate_start;
            $nb_hours_day = 0;
            $nb_hours_night = 0;
            $nb_hours_we = 0;
            while ($timeStep <= $searchDate_end) {


                // test if pricing is we
                if (in_array(date("N", $timeStep), $we_array) && in_array(date("N", $timeStep + $gap), $we_array)) {  // we pricing
                    $nb_hours_we += $gap;
                } else {
                    $H = date("H", $timeStep);

                    if ($H >= $night_end && $H < $night_start) { // price day
                        $nb_hours_day += $gap;
                    } else { // price night
                        $nb_hours_night += $gap;
                    }
                }
            }
            $timeStep += $gap;
        }


        $resaDayNightWe[0] = round($nb_hours_day / 3600, 1);
        $resaDayNightWe[1] = round($nb_hours_night / 3600, 1);
        $resaDayNightWe[2] = round($nb_hours_we / 3600, 1);
        return $resaDayNightWe;
    }

    private function getFirstPricing() {
        $pricingModel = new SyPricing();
        $pricingsInfo = $pricingModel->getPrices();
        return $pricingsInfo[0];
    }

    /**
     * Generate a pie chart number of hours of reservation per resource
     * @param unknown $year
     * @return unknown
     */
    public function getCamembertTimeArray($month_start, $year_start, $month_end, $year_end) {
        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 0, $year_end) . ' ORDER by resource_id';
        $req = $this->runRequest($sql);
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        $i = -1;
        foreach ($machinesFormesListe as $mFL) {

            // get the resource type
            $sql = 'SELECT type_id FROM sy_resources WHERE id=?';
            $req = $this->runRequest($sql, array($mFL["resource_id"]));
            $tmp = $req->fetch();
            $resourceType = $tmp[0];

            // get the night and we periods
            $pricingInfo = $this->getFirstPricing();
            $night_start = $pricingInfo['night_start'];
            $night_end = $pricingInfo['night_end'];
            $we_array1 = explode(",", $pricingInfo['choice_we']);
            $we_array = array();
            for ($s = 0; $s < count($we_array1); $s++) {
                if ($we_array1[$s] > 0) {
                    $we_array[] = $s + 1;
                }
            }

            // get all the reservations
            $i++;
            $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 1, $year_end) . ' AND resource_id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $resas = $req->fetchAll();

            // calculate the reservation time
            $timeResa = 0.0;
            $timeResaNight = 0.0;
            $timeResaWe = 0.0;
            foreach ($resas as $resa) {
                if ($resourceType == 1) {
                    $timeResaArray = $this->calculateReservationTime($resa["start_time"], $resa["end_time"], $night_start, $night_end, $we_array);
                    $timeResa += $timeResaArray[0];
                    $timeResaNight += $timeResaArray[1];
                    $timeResaWe += $timeResaArray[2];
                } else {
                    $timeResa += (float) ($resa["end_time"] - $resa["start_time"]) / (float) 3600;
                }
            }
            $numMachinesFormes[$i][1] = $timeResa;
            $numMachinesFormes[$i][2] = $timeResaNight;
            $numMachinesFormes[$i][3] = $timeResaWe;

            $sql = 'SELECT name FROM sy_resources WHERE id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $res = $req->fetchAll();
            $nomMachine = "-";
            if (count($res) > 0) {
                $nomMachine = $res[0][0];
            }

            $numMachinesFormes[$i][0] = $nomMachine;
        }

        return $numMachinesFormes;
    }

    /**
     * Generate a pie chart number of reservation per resource
     * @param unknown $year
     * @param unknown $numTotal
     * @return string
     */
    public function getCamembertContent($month_start, $year_start, $month_end, $year_end, $numTotal) {
        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 0, $year_end) . ' ORDER by resource_id';
        $req = $this->runRequest($sql);
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        $i = 0;
        $numMachinesFormes = array();
        $angle = 0;
        $departX = 300 + 250 * cos(0);
        $departY = 300 - 250 * sin(0);

        $test = '<g fill="rgb(97, 115, 169)">';
        $test .= '<title>Réservations</title>';
        $test .= '<desc>287</desc>';
        $test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
        $couleur = array("#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000",
            "#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000"
        );

        foreach ($machinesFormesListe as $mFL) {
            $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 1, $year_end) . ' AND resource_id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $numMachinesFormes[$i][0] = $mFL[0];
            $numMachinesFormes[$i][1] = $req->rowCount();

            $curentAngle = 2 * pi() * $numMachinesFormes[$i][1] / $numTotal;

            $sql = 'SELECT name FROM sy_resources WHERE id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $res = $req->fetchAll();
            $nomMachine = "-";
            if (count($res) > 0) {
                $nomMachine = $res[0][0];
            }

            if ($nomMachine != "-") {

                if ($curentAngle > pi()) {

                    $angle += $curentAngle / 2;

                    $arriveeX = 300 + 250 * cos($angle);
                    $arriveeY = 300 - 250 * sin($angle);

                    $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '" stroke="black" stroke-width="0"  />';
                    $test .= '<g>';

                    $departX = $arriveeX;
                    $departY = $arriveeY;
                    $angle += $curentAngle / 2;
                } else {
                    $angle += $curentAngle;
                }

                $arriveeX = 300 + 250 * cos($angle);
                $arriveeY = 300 - 250 * sin($angle);

                $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '"/>';
                $test .= '<g>';
                $test .= '<rect x="580" y="' . (83 + 40 * $i) . '" width="30" height="20" rx="5" ry="5" fill="' . $couleur[$i] . '" stroke="' . $couleur[$i] . '" stroke-width="0"/>';

                $test .= '<text x="615" y="' . (100 + 40 * $i) . '" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $numMachinesFormes[$i][1] . '</text>';
                $test .= '</g>';


                $departX = $arriveeX;
                $departY = $arriveeY;

                $i++;
            }
        }

        $test .= '</g>';
        return $test;
    }

    /**
     * Generate a pie chart number of reservation per resource
     * @param unknown $year
     * @param unknown $numTotal
     * @return string
     */
    public function getCamembertContentResourceType($month_start, $year_start, $month_end, $year_end, $numTotal) {
        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 0, $year_end) . ' ORDER by resource_id';
        $req = $this->runRequest($sql);
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        for ($m = 0; $m < count($machinesFormesListe); $m++) {
            $sql = 'SELECT category_id from sy_resources WHERE id=?';
            $req = $this->runRequest($sql, array($machinesFormesListe[$m]["resource_id"]));
            $val = $req->fetch();
            $machinesFormesListe[$m]["category_id"] = $val[0];
        }

        $sql = 'SELECT * from sy_resourcescategory ORDER BY name ASC;';
        $req = $this->runRequest($sql);
        $resourceTypeList = $req->fetchAll();

        $i = 0;
        $numMachinesFormes = array();
        $angle = 0;
        $departX = 300 + 250 * cos(0);
        $departY = 300 - 250 * sin(0);

        $test = '<g fill="rgb(97, 115, 169)">';
        $test .= '<title>Réservations</title>';
        $test .= '<desc>287</desc>';
        $test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
        $couleur = array("#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000",
            "#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000"
        );

        for ($i = 0; $i < count($resourceTypeList); $i++) {

            $resTypID = $resourceTypeList[$i]["id"];
            $count = 0;
            foreach ($machinesFormesListe as $mFL) {

                if ($mFL["category_id"] == $resTypID) {
                    $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 1, $year_end) . ' AND resource_id ="' . $mFL[0] . '"';
                    $req = $this->runRequest($sql);
                    $count += $req->rowCount();
                }
            }
            $resourceTypeList[$i]["number_resa"] = $count;

            $curentAngle = 2 * pi() * $resourceTypeList[$i]["number_resa"] / $numTotal;

            if ($curentAngle > pi()) {

                $angle += $curentAngle / 2;

                $arriveeX = 300 + 250 * cos($angle);
                $arriveeY = 300 - 250 * sin($angle);

                $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '" stroke="black" stroke-width="0"  />';
                $test .= '<g>';

                $departX = $arriveeX;
                $departY = $arriveeY;
                $angle += $curentAngle / 2;
            } else {
                $angle += $curentAngle;
            }

            $arriveeX = 300 + 250 * cos($angle);
            $arriveeY = 300 - 250 * sin($angle);

            $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '"/>';
            $test .= '<g>';
            $test .= '<rect x="580" y="' . (83 + 40 * $i) . '" width="30" height="20" rx="5" ry="5" fill="' . $couleur[$i] . '" stroke="' . $couleur[$i] . '" stroke-width="0"/>';

            $nomMachine = $resourceTypeList[$i]["name"];
            $test .= '<text x="615" y="' . (100 + 40 * $i) . '" font-size="25" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $resourceTypeList[$i]["number_resa"] . '</text>';
            $test .= '</g>';


            $departX = $arriveeX;
            $departY = $arriveeY;
        }

        $test .= '</g>';
        return $test;
    }

    /**
     * Generate a pie chart time of reservation per resource
     * @param unknown $year
     * @param unknown $numTotal
     * @return string
     */
    public function getCamembertTimeContentResourceType($month_start, $year_start, $month_end, $year_end, $numTotal) {

        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 0, $year_end) . ' ORDER by resource_id';
        $req = $this->runRequest($sql);
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        // get the night and we periods
        $pricingInfo = $this->getFirstPricing();
        $is_unique_price = $pricingInfo["tarif_unique"];

        $night_start = $pricingInfo['night_start'];
        $night_end = $pricingInfo['night_end'];
        $we_array1 = explode(",", $pricingInfo['choice_we']);
        $we_array = array();
        for ($s = 0; $s < count($we_array1); $s++) {
            if ($we_array1[$s] > 0) {
                $we_array[] = $s + 1;
            }
        }

        for ($m = 0; $m < count($machinesFormesListe); $m++) {
            $sql = 'SELECT category_id from sy_resources WHERE id=?';
            $req = $this->runRequest($sql, array($machinesFormesListe[$m]["resource_id"]));
            $val = $req->fetch();
            $machinesFormesListe[$m]["category_id"] = $val[0];
        }

        $sql = 'SELECT * from sy_resourcescategory ORDER BY name ASC;';
        $req = $this->runRequest($sql);
        $resourceTypeList = $req->fetchAll();

        $i = 0;
        $numMachinesFormes = array();
        $angle = 0;
        $departX = 300 + 250 * cos(0);
        $departY = 300 - 250 * sin(0);

        $test = '<g fill="rgb(97, 115, 169)">';
        $test .= '<title>Réservations</title>';
        $test .= '<desc>287</desc>';
        $test .= '<rect x="0" y="0" width="1000" height="600" fill="white" stroke="black" stroke-width="0"/>';
        $couleur = array("#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000",
            "#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000"
        );

        $resourceType = 1; // forced to count night and we prices (to be modified if needed)

        for ($i = 0; $i < count($resourceTypeList); $i++) {


            $resTypID = $resourceTypeList[$i]["id"];
            $timeResa = 0;
            $timeResaNight = 0;
            $timeResaWe = 0;
            foreach ($machinesFormesListe as $mFL) {

                if ($mFL["category_id"] == $resTypID) {
                    $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=' . mktime(0, 0, 0, $month_start, 1, $year_start) . ' AND end_time <=' . mktime(0, 0, 0, $month_end + 1, 1, $year_end) . ' AND resource_id ="' . $mFL[0] . '"';
                    $req = $this->runRequest($sql);
                    $numMachinesFormes[$i][0] = $mFL[0];

                    $resas = $req->fetchAll();
                    foreach ($resas as $resa) {
                        if ($resourceType == 1) {
                            $timeResaArray = $this->calculateReservationTime($resa["start_time"], $resa["end_time"], $night_start, $night_end, $we_array, $is_unique_price);
                            $timeResa += $timeResaArray[0];
                            $timeResaNight += $timeResaArray[1];
                            $timeResaWe += $timeResaArray[2];
                        } else {
                            $timeResa += (float) ($resa["end_time"] - $resa["start_time"]) / (float) 3600;
                        }
                    }
                }
            }

            $curentAngle = 2 * pi() * ($timeResa + $timeResaNight + $timeResaWe) / $numTotal;

            if ($curentAngle > pi()) {

                $angle += $curentAngle / 2;

                $arriveeX = 300 + 250 * cos($angle);
                $arriveeY = 300 - 250 * sin($angle);

                $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '" stroke="black" stroke-width="0"  />';
                $test .= '<g>';

                $departX = $arriveeX;
                $departY = $arriveeY;
                $angle += $curentAngle / 2;
            } else {
                $angle += $curentAngle;
            }

            $arriveeX = 300 + 250 * cos($angle);
            $arriveeY = 300 - 250 * sin($angle);

            $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '"/>';
            $test .= '<g>';
            $test .= '<rect x="580" y="' . (83 + 40 * $i) . '" width="30" height="20" rx="5" ry="5" fill="' . $couleur[$i] . '" stroke="' . $couleur[$i] . '" stroke-width="0"/>';

            $sql = 'SELECT name FROM sy_resources WHERE id ="' . $mFL[0] . '"';
            $req = $this->runRequest($sql);
            $res = $req->fetchAll();
            $nomMachine = $resourceTypeList[$i]["name"];

            if ($timeResaNight != 0 || $timeResaWe != 0) {
                $test .= '<text x="615" y="' . (100 + 40 * $i) . '" font-size="20" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $timeResa . "|" . $timeResaNight . "|" . $timeResaWe . '</text>';
            } else {
                $test .= '<text x="615" y="' . (100 + 40 * $i) . '" font-size="20" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $timeResa . '</text>';
            }
            $test .= '</g>';

            $departX = $arriveeX;
            $departY = $arriveeY;
        }


        $test .= '</g>';
        return $test;
    }

    /**
     * Generate a pie chart time of reservation per resource
     * @param unknown $year
     * @param unknown $numTotal
     * @return string
     */
    public function getCamembertTimeContent($month_start, $year_start, $month_end, $year_end, $numTotal) {
        $sql = 'SELECT DISTINCT resource_id FROM sy_calendar_entry WHERE start_time >=? AND end_time <=? ORDER by resource_id';
        $req = $this->runRequest($sql, array(mktime(0, 0, 0, $month_start, 1, $year_start), mktime(0, 0, 0, $month_end + 1, 0, $year_end)));
        $numMachinesFormesTotal = $req->rowCount();
        $machinesFormesListe = $req->fetchAll();

        // get the night and we periods
        $pricingInfo = $this->getFirstPricing();
        $is_unique_price = $pricingInfo["tarif_unique"];
        $night_start = $pricingInfo['night_start'];
        $night_end = $pricingInfo['night_end'];
        $we_array1 = explode(",", $pricingInfo['choice_we']);
        $we_array = array();
        for ($s = 0; $s < count($we_array1); $s++) {
            if ($we_array1[$s] > 0) {
                $we_array[] = $s + 1;
            }
        }

        $i = 0;
        $numMachinesFormes = array();
        $angle = 0;
        $departX = 300 + 250 * cos(0);
        $departY = 300 - 250 * sin(0);

        $test = '<g fill="rgb(97, 115, 169)">';
        $test .= '<title>Réservations</title>';
        $test .= '<desc>287</desc>';
        $test .= '<rect x="0" y="0" width="1500" height="600" fill="white" stroke="black" stroke-width="0"/>';
        $couleur = array("#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000",
            "#FC441D", "#FE8D11", "#FCC212", "#FFFD32", "#D0E92B", "#53D745", "#6AC720", "#156947", "#291D81", "#804DA4", "#E4AADF", "#A7194B", "#FE0000"
        );

        foreach ($machinesFormesListe as $mFL) {

            $sql = 'SELECT name FROM sy_resources WHERE id =?';
            $req = $this->runRequest($sql, array($mFL[0]));
            $res = $req->fetchAll();
            $nomMachine = "-";
            if (count($res) > 0) {
                $nomMachine = $res[0][0];
            }

            if ($nomMachine != "-") {

                $sql = 'SELECT * FROM sy_calendar_entry WHERE start_time >=? AND end_time <=? AND resource_id=?';
                $req = $this->runRequest($sql, array(mktime(0, 0, 0, $month_start, 1, $year_start), mktime(0, 0, 0, $month_end + 1, 0, $year_end), $mFL[0]));
                $numMachinesFormes[$i][0] = $mFL[0];

                $resas = $req->fetchAll();
                //echo "resas for " . $nomMachine . "<br/>";
                //print_r($resas);
                $timeResa = 0.0;
                $timeResaNight = 0.0;
                $timeResaWe = 0.0;
                foreach ($resas as $resa) {
                    $timeResaArray = $this->calculateReservationTime($resa["start_time"], $resa["end_time"], $night_start, $night_end, $we_array, $is_unique_price);
                    $timeResa += $timeResaArray[0];
                    $timeResaNight += $timeResaArray[1];
                    $timeResaWe += $timeResaArray[2];
                }
                //echo " room = " . $nomMachine . ", room id = " . $mFL[0] . ", timeResa = " . $timeResa . "<br/>";
                $numMachinesFormes[$i][1] = round($timeResa, 1);
                $numMachinesFormes[$i][2] = round($timeResaNight, 1);
                $numMachinesFormes[$i][3] = round($timeResaWe, 1);

                $curentAngle = 2 * pi() * ($numMachinesFormes[$i][1] + $numMachinesFormes[$i][2] + $numMachinesFormes[$i][3]) / $numTotal;

                if ($curentAngle > pi()) {

                    $angle += $curentAngle / 2;

                    $arriveeX = 300 + 250 * cos($angle);
                    $arriveeY = 300 - 250 * sin($angle);

                    $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '" stroke="black" stroke-width="0"  />';
                    $test .= '<g>';

                    $departX = $arriveeX;
                    $departY = $arriveeY;
                    $angle += $curentAngle / 2;
                } else {
                    $angle += $curentAngle;
                }

                $arriveeX = 300 + 250 * cos($angle);
                $arriveeY = 300 - 250 * sin($angle);

                $test .= '<path d="M ' . $departX . ' ' . $departY . ' A 250 250 0 0 0 ' . $arriveeX . ' ' . $arriveeY . ' L 300 300" fill="' . $couleur[$i] . '"/>';
                $test .= '<g>';
                $test .= '<rect x="580" y="' . (83 + 40 * $i) . '" width="30" height="20" rx="5" ry="5" fill="' . $couleur[$i] . '" stroke="' . $couleur[$i] . '" stroke-width="0"/>';

                if ($numMachinesFormes[$i][2] == 0 && $numMachinesFormes[$i][3] == 0) {
                    $test .= '<text x="625" y="' . (100 + 40 * $i) . '" font-size="20" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $numMachinesFormes[$i][1] . "" . '</text>';
                } else {
                    $test .= '<text x="615" y="' . (100 + 40 * $i) . '" font-size="20" fill="black" stroke="none" text-anchor="start" baseline-shift="-11px">' . $nomMachine . ' : ' . $numMachinesFormes[$i][1] . "|" . $numMachinesFormes[$i][2] . "|" . $numMachinesFormes[$i][3] . "" . '</text>';
                }
                $test .= '</g>';

                $departX = $arriveeX;
                $departY = $arriveeY;
                $i++;
            }
        }

        $test .= '</g>';
        return $test;
    }

}
