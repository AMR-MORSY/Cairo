<?php

namespace App\Services\NUR\NURStatestics;

use App\Services\NUR\NURStatestics\NURHelpers;

class WeeklyStatestics
{

    private $NUR2G, $NUR3G, $NUR4G;

    public function __construct($NUR2G, $NUR3G, $NUR4G)
    {
        $this->NUR2G = $NUR2G;
        $this->NUR3G = $NUR3G;
        $this->NUR4G = $NUR4G;
    }

    public function NUR2GStatestics()
    {
        $NURHelpers = new NURHelpers($this->NUR2G);
        $cairo2GNUR = number_format($this->NUR2G->sum('nur'), 2, '.', ',');
        $zonesNUR = $NURHelpers->zonesNUR($this->NUR2G->groupBy('oz')->keys(), "nur");
        // $zonesSubsystemNUR = $NURHelpers->zonesSubsystemNUR($this->NUR2G->groupBy('oz')->keys(),"nur");
        // $zonesSubsystemCountTickts =  $NURHelpers->zonesSubsystemCountTickts($this->NUR2G->groupBy('oz')->keys());
        // $zonesAccessCountTickts = $NURHelpers->zonesAccessCountTickts($this->NUR2G->groupBy('oz')->keys());
        // $zonesAccessNUR = $NURHelpers->zonesAccessNUR($this->NUR2G->groupBy('oz')->keys(),"nur");
        // $zonesTopSitesNur = $NURHelpers->zonesTopSitesNur($this->NUR2G->groupBy('oz')->keys(),"nur");
        // $zonesRepeatedSites = $NURHelpers->zonesRepeatedSites($this->NUR2G->groupBy('oz')->keys());
        // $zonesGeneratorStatestics =  $NURHelpers->zonesGeneratorStatestics($this->NUR2G->groupBy('oz')->keys(),"nur");
        // $zonesAverageTicketsDur =  $NURHelpers->zonesAverageTicketsDur($this->NUR2G->groupBy('oz')->keys());
        // $zonesResponseWithAccess=$NURHelpers->zonesResponseWithAccess($this->NUR2G->groupBy('oz')->keys(),"nur");
        // $zonesResponseWithoutAccess=$NURHelpers->zonesResponseWithoutAccess($this->NUR2G->groupBy('oz')->keys(),"nur");
        $zonesTotalNumTickets = $NURHelpers->zonesTotalNumTickets($this->NUR2G->groupBy('oz')->keys());

        $NUR2G['cairoNUR2G'] = $cairo2GNUR;
        $NUR2G['zonesNUR2G'] = $zonesNUR;
        // $NUR2G['zonesNUR2GSubsystemNUR'] = $zonesSubsystemNUR;
        // $NUR2G['zonesNUR2GSubsystemCountTickets'] = $zonesSubsystemCountTickts;
        // $NUR2G['zonesNUR2GAccessCountTickets'] =  $zonesAccessCountTickts;
        // $NUR2G['zonesNUR2GAccessNUR'] = $zonesAccessNUR;
        // $NUR2G['zonesNUR2GTopSitesNUR'] =  $zonesTopSitesNur;
        // $NUR2G['zonesNUR2GRepeatedSitesNUR'] =  $zonesRepeatedSites;
        // $NUR2G['zonesNUR2GGenStatestics'] =   $zonesGeneratorStatestics;
        // $NUR2G['zonesNUR2AverageTicketsDur'] =    $zonesAverageTicketsDur;
        // $NUR2G['zonesResponseWithoutAccess']= $zonesResponseWithoutAccess;
        // $NUR2G['zonesResponseWithAccess']= $zonesResponseWithAccess;
        $NUR2G['zonesTotalNumTickets'] = $zonesTotalNumTickets;


        return    $NUR2G;
    }
    public function NUR3GStatestics()
    {
        $NURHelpers = new NURHelpers($this->NUR3G);
        $cairo3GNUR = number_format($this->NUR3G->sum('nur'), 2, '.', ',');
        $zonesNUR = $NURHelpers->zonesNUR($this->NUR3G->groupBy('oz')->keys(), "nur");
        $zonesSubsystemNUR = $NURHelpers->zonesSubsystemNUR($this->NUR3G->groupBy('oz')->keys(), "nur");
        $zonesSubsystemCountTickts =  $NURHelpers->zonesSubsystemCountTickts($this->NUR3G->groupBy('oz')->keys());
        $zonesAccessCountTickts = $NURHelpers->zonesAccessCountTickts($this->NUR3G->groupBy('oz')->keys());
        $zonesAccessNUR =   $NURHelpers->zonesAccessNUR($this->NUR3G->groupBy('oz')->keys(), "nur");
        // $zonesTopSitesNur =   $NURHelpers->zonesTopSitesNur($this->NUR3G->groupBy('oz')->keys(), "nur");
        // $zonesRepeatedSites =  $NURHelpers->zonesRepeatedSites($this->NUR3G->groupBy('oz')->keys());
        $zonesGeneratorStatestics =  $NURHelpers->zonesGeneratorStatestics($this->NUR3G->groupBy('oz')->keys(), "nur");
        $zonesAverageTicketsDur =  $NURHelpers->zonesAverageTicketsDur($this->NUR3G->groupBy('oz')->keys());
        $zonesResponseWithAccess = $NURHelpers->zonesResponseWithAccess($this->NUR3G->groupBy('oz')->keys(), "nur");
        $zonesResponseWithoutAccess = $NURHelpers->zonesResponseWithoutAccess($this->NUR3G->groupBy('oz')->keys(), "nur");
        $zonesTotalNumTickets = $NURHelpers->zonesTotalNumTickets($this->NUR3G->groupBy('oz')->keys());

        $NUR3G['cairoNUR3G'] = $cairo3GNUR;
        $NUR3G['zonesNUR3G'] = $zonesNUR;
        $NUR3G['zonesNUR3GSubsystemNUR'] = $zonesSubsystemNUR;
        $NUR3G['zonesNUR3GSubsystemCountTickets'] = $zonesSubsystemCountTickts;
        $NUR3G['zonesNUR3GAccessCountTickets'] =  $zonesAccessCountTickts;
        $NUR3G['zonesNUR3GAccessNUR'] = $zonesAccessNUR;
        // $NUR3G['zonesNUR3GTopSitesNUR'] =  $zonesTopSitesNur;
        // $NUR3G['zonesNUR3GRepeatedSitesNUR'] =  $zonesRepeatedSites;
        $NUR3G['zonesNUR3GGenStatestics'] =   $zonesGeneratorStatestics;
        $NUR3G['zonesNUR2AverageTicketsDur'] =    $zonesAverageTicketsDur;
        $NUR3G['zonesResponseWithoutAccess'] = $zonesResponseWithoutAccess;
        $NUR3G['zonesResponseWithAccess'] = $zonesResponseWithAccess;
        $NUR3G['zonesTotalNumTickets'] = $zonesTotalNumTickets;



        return   $NUR3G;
    }
    public function NUR4GStatestics()
    {
        $NURHelpers = new NURHelpers($this->NUR4G);
        $cairo4GNUR = number_format($this->NUR4G->sum('nur'), 2, '.', ',');
        $zonesNUR =  $NURHelpers->zonesNUR($this->NUR4G->groupBy('oz')->keys(), "nur");
        // $zonesSubsystemNUR = $NURHelpers->zonesSubsystemNUR($this->NUR4G->groupBy('oz')->keys(),"nur");
        // $zonesSubsystemCountTickts =  $NURHelpers->zonesSubsystemCountTickts($this->NUR4G->groupBy('oz')->keys());
        // $zonesAccessCountTickts = $NURHelpers->zonesAccessCountTickts($this->NUR4G->groupBy('oz')->keys());
        // $zonesAccessNUR = $NURHelpers->zonesAccessNUR($this->NUR4G->groupBy('oz')->keys(),"nur");
        // $zonesTopSitesNur = $NURHelpers->zonesTopSitesNur($this->NUR4G->groupBy('oz')->keys(),"nur");
        // $zonesRepeatedSites = $NURHelpers->zonesRepeatedSites($this->NUR4G->groupBy('oz')->keys());
        // $zonesGeneratorStatestics =  $NURHelpers->zonesGeneratorStatestics($this->NUR4G->groupBy('oz')->keys(),"nur");
        // $zonesAverageTicketsDur = $NURHelpers->zonesAverageTicketsDur($this->NUR4G->groupBy('oz')->keys());
        // $zonesResponseWithAccess=$NURHelpers->zonesResponseWithAccess($this->NUR4G->groupBy('oz')->keys(),"nur");
        // $zonesResponseWithoutAccess=$NURHelpers->zonesResponseWithoutAccess($this->NUR4G->groupBy('oz')->keys(),"nur");
        $zonesTotalNumTickets = $NURHelpers->zonesTotalNumTickets($this->NUR4G->groupBy('oz')->keys());

        $NUR4G['cairoNUR4G'] = $cairo4GNUR;
        $NUR4G['zonesNUR4G'] = $zonesNUR;
        // $NUR4G['zonesNUR4GSubsystemNUR'] = $zonesSubsystemNUR;
        // $NUR4G['zonesNUR4GSubsystemCountTickets'] = $zonesSubsystemCountTickts;
        // $NUR4G['zonesNUR4GAccessCountTickets'] =  $zonesAccessCountTickts;
        // $NUR4G['zonesNUR4GAccessNUR'] = $zonesAccessNUR;
        // $NUR4G['zonesNUR4GTopSitesNUR'] =  $zonesTopSitesNur;
        // $NUR4G['zonesNUR4GRepeatedSitesNUR'] =  $zonesRepeatedSites;
        // $NUR4G['zonesNUR4GGenStatestics'] =   $zonesGeneratorStatestics;
        // $NUR4G['zonesNUR2AverageTicketsDur'] =    $zonesAverageTicketsDur;
        // $NUR4G['zonesResponseWithoutAccess']= $zonesResponseWithoutAccess;
        // $NUR4G['zonesResponseWithAccess']= $zonesResponseWithAccess;
        $NUR4G['zonesTotalNumTickets'] = $zonesTotalNumTickets;


        return   $NUR4G;
    }
    private function getRepeatedSites($repeated2G, $repeated3G, $repeated4G)
    {

        $array2G3G4G = [];

        foreach ($repeated2G as $site) {
            array_push($array2G3G4G, $site);
        }
        foreach ($repeated3G as $site) {
            array_push($array2G3G4G, $site);
        }
        foreach ($repeated4G as $site) {
            array_push($array2G3G4G, $site);
        }
        $array2G3G4G = collect($array2G3G4G);
        $sites = $array2G3G4G->groupBy("siteCode");
        $tops = [];
        foreach ($sites as $key => $values) {
            $top = $values->sortByDesc("count")->first();
            array_push($tops, $top);
        }
        return $tops;
    }

    private function getTopNurSites($top2G, $top3G, $top4G)
    {
        $array2G3G4G = [];

        foreach ($top2G as $site) {
            $site['tech'] = "2G";
            array_push($array2G3G4G, $site);
        }
        foreach ($top3G as $site) {
            $site['tech'] = "3G";
            array_push($array2G3G4G, $site);
        }
        foreach ($top4G as $site) {
            $site['tech'] = "4G";
            array_push($array2G3G4G, $site);
        }

        $array2G3G4G = collect($array2G3G4G);
        $siteCodes = $array2G3G4G->groupBy("siteCode")->keys();
        $tops = [];

        foreach ($siteCodes as $code) {
            $Nur2G = $array2G3G4G->where("tech", "2G")->where("siteCode", $code)->first();
            $Nur3G = $array2G3G4G->where("siteCode", $code)->where("tech", "3G")->first();
            $Nur4G = $array2G3G4G->where("siteCode", $code)->where("tech", "4G")->first();

            $has["2G"] = $Nur2G;
            $has["3G"] = $Nur3G;
            $has["4G"] = $Nur4G;


            array_push($tops, $has);
        }
        $newSites = [];

        foreach ($tops as $top) {
            if (isset($top["2G"])) {
                $NUR2G = $top["2G"]['NUR'];
                $siteCode = $top["2G"]['siteCode'];
                $siteName = $top["2G"]['siteName'];
            } else {
                $NUR2G = 0;
            }
            if (isset($top["3G"])) {
                $NUR3G = $top["3G"]['NUR'];
                $siteCode = $top["3G"]['siteCode'];
                $siteName = $top["3G"]['siteName'];
            } else {
                $NUR3G = 0;
            }
            if (isset($top["4G"])) {
                $NUR4G = $top["4G"]['NUR'];
                $siteCode = $top["4G"]['siteCode'];
                $siteName = $top["4G"]['siteName'];
            } else {
                $NUR4G = 0;
            }
            $NurCombined = number_format(((floatval($NUR2G) * $this->NUR2G->first()->network_cells) + (floatval($NUR3G)  * $this->NUR3G->first()->network_cells) + (floatval($NUR4G)* $this->NUR4G->first()->network_cells)) /($this->NUR2G->first()->network_cells + $this->NUR3G->first()->network_cells + $this->NUR4G->first()->network_cells), 2, '.', ',');

            $topSite['siteCode'] = $siteCode;
            $topSite['siteName'] = $siteName;
            $topSite["NUR"] = $NurCombined;
            array_push($newSites, $topSite);
        }


       



        return $newSites;
    }

    public function zonesTopRepeated()
    {
        $NUR2GHelpers = new NURHelpers($this->NUR2G);
        $NUR3GHelpers = new NURHelpers($this->NUR3G);
        $NUR4GHelpers = new NURHelpers($this->NUR4G);
        $topRepeated2G = $NUR2GHelpers->zonesRepeatedSites($this->NUR2G->groupBy('oz')->keys());
        $topRepeated3G = $NUR3GHelpers->zonesRepeatedSites($this->NUR3G->groupBy('oz')->keys());
        $topRepeated4G = $NUR4GHelpers->zonesRepeatedSites($this->NUR4G->groupBy('oz')->keys());
        //  $repeated2G=$topRepeated2G["zonesNUR2GRepeatedSitesNUR"];
        //  $repeated3G=$topRepeated3G["zonesNUR3GRepeatedSitesNUR"];
        //  $repeated4G=$topRepeated4G["zonesNUR4GRepeatedSitesNUR"];

        $zoneTopRepeated2G["CAIRO EAST"] = $topRepeated2G["CAIRO EAST"];
        $zoneTopRepeated2G["CAIRO NORTH"] = $topRepeated2G["CAIRO NORTH"];
        $zoneTopRepeated2G["CAIRO SOUTH"] = $topRepeated2G["CAIRO SOUTH"];
        $zoneTopRepeated2G["GIZA"] = $topRepeated2G["GIZA"];



        $zoneTopRepeated3G["CAIRO EAST"] = $topRepeated3G["CAIRO EAST"];
        $zoneTopRepeated3G["CAIRO NORTH"] = $topRepeated3G["CAIRO NORTH"];
        $zoneTopRepeated3G["CAIRO SOUTH"] = $topRepeated3G["CAIRO SOUTH"];
        $zoneTopRepeated3G["GIZA"] = $topRepeated3G["GIZA"];

        $zoneTopRepeated4G["CAIRO EAST"] = $topRepeated4G["CAIRO EAST"];
        $zoneTopRepeated4G["CAIRO NORTH"] = $topRepeated4G["CAIRO NORTH"];
        $zoneTopRepeated4G["CAIRO SOUTH"] = $topRepeated4G["CAIRO SOUTH"];
        $zoneTopRepeated4G["GIZA"] = $topRepeated4G["GIZA"];

        $cairoEast = $this->getRepeatedSites($zoneTopRepeated2G["CAIRO EAST"], $zoneTopRepeated3G["CAIRO EAST"], $zoneTopRepeated4G["CAIRO EAST"]);
        $cairoSouth = $this->getRepeatedSites($zoneTopRepeated2G["CAIRO SOUTH"], $zoneTopRepeated3G["CAIRO SOUTH"], $zoneTopRepeated4G["CAIRO SOUTH"]);
        $cairoNorth = $this->getRepeatedSites($zoneTopRepeated2G["CAIRO NORTH"], $zoneTopRepeated3G["CAIRO NORTH"], $zoneTopRepeated4G["CAIRO NORTH"]);
        $giza = $this->getRepeatedSites($zoneTopRepeated2G["GIZA"], $zoneTopRepeated3G["GIZA"], $zoneTopRepeated4G["GIZA"]);

        $zonesTopRepeatedSites["CAIRO EAST"] = $cairoEast;
        $zonesTopRepeatedSites["CAIRO NORTH"] = $cairoNorth;
        $zonesTopRepeatedSites["CAIRO SOUTH"] = $cairoSouth;
        $zonesTopRepeatedSites["GIZA"] = $giza;

        return $zonesTopRepeatedSites;
    }

    public function zonesTopNUR()
    {
        $NUR2GHelpers = new NURHelpers($this->NUR2G);
        $NUR3GHelpers = new NURHelpers($this->NUR3G);
        $NUR4GHelpers = new NURHelpers($this->NUR4G);

        $top2GSitesNur = $NUR2GHelpers->zonesTopSitesNur($this->NUR2G->groupBy('oz')->keys(), "nur");
        $top3GSitesNur = $NUR3GHelpers->zonesTopSitesNur($this->NUR3G->groupBy('oz')->keys(), "nur");
        $top4GSitesNur = $NUR4GHelpers->zonesTopSitesNur($this->NUR4G->groupBy('oz')->keys(), "nur");

        $zoneTopNUR2G["CAIRO EAST"] = $top2GSitesNur["CAIRO EAST"];
        $zoneTopNUR2G["CAIRO NORTH"] = $top2GSitesNur["CAIRO NORTH"];
        $zoneTopNUR2G["CAIRO SOUTH"] = $top2GSitesNur["CAIRO SOUTH"];
        $zoneTopNUR2G["GIZA"] = $top2GSitesNur["GIZA"];

        $zoneTopNUR3G["CAIRO EAST"] =  $top3GSitesNur["CAIRO EAST"];
        $zoneTopNUR3G["CAIRO NORTH"] =  $top3GSitesNur["CAIRO NORTH"];
        $zoneTopNUR3G["CAIRO SOUTH"] =  $top3GSitesNur["CAIRO SOUTH"];
        $zoneTopNUR3G["GIZA"] =  $top3GSitesNur["GIZA"];

        $zoneTopNUR4G["CAIRO EAST"] =  $top4GSitesNur["CAIRO EAST"];
        $zoneTopNUR4G["CAIRO NORTH"] =  $top4GSitesNur["CAIRO NORTH"];
        $zoneTopNUR4G["CAIRO SOUTH"] =  $top4GSitesNur["CAIRO SOUTH"];
        $zoneTopNUR4G["GIZA"] =  $top4GSitesNur["GIZA"];

        $cairoEast = $this->getTopNurSites($zoneTopNUR2G["CAIRO EAST"], $zoneTopNUR3G["CAIRO EAST"], $zoneTopNUR4G["CAIRO EAST"]);
        $cairoNorth = $this->getTopNurSites($zoneTopNUR2G["CAIRO NORTH"], $zoneTopNUR3G["CAIRO NORTH"], $zoneTopNUR4G["CAIRO NORTH"]);
        $cairoSouth = $this->getTopNurSites($zoneTopNUR2G["CAIRO SOUTH"], $zoneTopNUR3G["CAIRO SOUTH"], $zoneTopNUR4G["CAIRO SOUTH"]);
        $giza = $this->getTopNurSites($zoneTopNUR2G["GIZA"], $zoneTopNUR3G["GIZA"], $zoneTopNUR4G["GIZA"]);

        $zonesTopNurSites["CAIRO EAST"] = $cairoEast;
        $zonesTopNurSites["CAIRO NORTH"] = $cairoNorth;
        $zonesTopNurSites["CAIRO SOUTH"] = $cairoSouth;
        $zonesTopNurSites["GIZA"] = $giza;

        return $zonesTopNurSites;
    }

    public function combinedNUR()
    {
        $NUR2G = $this->NUR2GStatestics();
        $zonesNUR2G = $NUR2G['zonesNUR2G'];
        $NUR3G = $this->NUR3GStatestics();
        $zonesNUR3G = $NUR3G['zonesNUR3G'];
        $NUR4G = $this->NUR4GStatestics();
        $zonesNUR4G = $NUR4G['zonesNUR4G'];


        $cairoEastCombined = number_format((($zonesNUR2G['CAIRO EAST'] * $this->NUR2G->first()->network_cells) + ($zonesNUR3G['CAIRO EAST'] * $this->NUR3G->first()->network_cells) + ($zonesNUR4G['CAIRO EAST'] * $this->NUR4G->first()->network_cells)) / ($this->NUR2G->first()->network_cells + $this->NUR3G->first()->network_cells + $this->NUR4G->first()->network_cells), 2, '.', ',');

        $cairoSouthCombined = number_format((($zonesNUR2G['CAIRO SOUTH'] * $this->NUR2G->first()->network_cells) + ($zonesNUR3G['CAIRO SOUTH'] * $this->NUR3G->first()->network_cells) + ($zonesNUR4G['CAIRO SOUTH'] * $this->NUR4G->first()->network_cells)) / ($this->NUR2G->first()->network_cells + $this->NUR3G->first()->network_cells + $this->NUR4G->first()->network_cells), 2, '.', ',');
        $cairoNorthCombined = number_format((($zonesNUR2G['CAIRO NORTH'] * $this->NUR2G->first()->network_cells) + ($zonesNUR3G['CAIRO NORTH'] * $this->NUR3G->first()->network_cells) + ($zonesNUR4G['CAIRO NORTH'] * $this->NUR4G->first()->network_cells)) / ($this->NUR2G->first()->network_cells + $this->NUR3G->first()->network_cells + $this->NUR4G->first()->network_cells), 2, '.', ',');
        $gizaCombined = number_format((($zonesNUR2G['GIZA'] * $this->NUR2G->first()->network_cells) + ($zonesNUR3G['GIZA'] * $this->NUR3G->first()->network_cells) + ($zonesNUR4G['GIZA'] * $this->NUR4G->first()->network_cells)) / ($this->NUR2G->first()->network_cells + $this->NUR3G->first()->network_cells + $this->NUR4G->first()->network_cells), 2, '.', ',');
        $combined['CAIRO EAST'] =  $cairoEastCombined;
        $combined['CAIRO SOUTH'] =  $cairoSouthCombined;
        $combined['CAIRO NORTH'] =  $cairoNorthCombined;
        $combined['GIZA'] =  $gizaCombined;
        $combined["cairo"] = number_format($cairoEastCombined + $cairoNorthCombined + $cairoSouthCombined + $gizaCombined, 2, '.', ',');
        return $combined;
    }
}
