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
        $NURHelpers=new NURHelpers($this->NUR2G);
        $cairo2GNUR = number_format($this->NUR2G->sum('nur'), 2, '.', ',');
        $zonesNUR = $NURHelpers->zonesNUR($this->NUR2G->groupBy('oz')->keys(),"nur");
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
        $zonesTotalNumTickets=$NURHelpers->zonesTotalNumTickets($this->NUR2G->groupBy('oz')->keys());

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
        $NUR2G['zonesTotalNumTickets']= $zonesTotalNumTickets;


        return    $NUR2G;
    }
    public function NUR3GStatestics()
    {
        $NURHelpers=new NURHelpers($this->NUR3G);
        $cairo3GNUR = number_format($this->NUR3G->sum('nur'), 2, '.', ',');
        $zonesNUR = $NURHelpers->zonesNUR($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesSubsystemNUR =$NURHelpers->zonesSubsystemNUR($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesSubsystemCountTickts =  $NURHelpers->zonesSubsystemCountTickts($this->NUR3G->groupBy('oz')->keys());
        $zonesAccessCountTickts = $NURHelpers->zonesAccessCountTickts($this->NUR3G->groupBy('oz')->keys());
        $zonesAccessNUR =   $NURHelpers->zonesAccessNUR($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesTopSitesNur =   $NURHelpers->zonesTopSitesNur($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesRepeatedSites =  $NURHelpers->zonesRepeatedSites($this->NUR3G->groupBy('oz')->keys());
        $zonesGeneratorStatestics =  $NURHelpers->zonesGeneratorStatestics($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesAverageTicketsDur =  $NURHelpers->zonesAverageTicketsDur($this->NUR3G->groupBy('oz')->keys());
        $zonesResponseWithAccess=$NURHelpers->zonesResponseWithAccess($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesResponseWithoutAccess=$NURHelpers->zonesResponseWithoutAccess($this->NUR3G->groupBy('oz')->keys(),"nur");
        $zonesTotalNumTickets=$NURHelpers->zonesTotalNumTickets($this->NUR3G->groupBy('oz')->keys());

        $NUR3G['cairoNUR3G'] = $cairo3GNUR;
        $NUR3G['zonesNUR3G'] = $zonesNUR;
        $NUR3G['zonesNUR3GSubsystemNUR'] = $zonesSubsystemNUR;
        $NUR3G['zonesNUR3GSubsystemCountTickets'] = $zonesSubsystemCountTickts;
        $NUR3G['zonesNUR3GAccessCountTickets'] =  $zonesAccessCountTickts;
        $NUR3G['zonesNUR3GAccessNUR'] = $zonesAccessNUR;
        $NUR3G['zonesNUR3GTopSitesNUR'] =  $zonesTopSitesNur;
        $NUR3G['zonesNUR3GRepeatedSitesNUR'] =  $zonesRepeatedSites;
        $NUR3G['zonesNUR3GGenStatestics'] =   $zonesGeneratorStatestics;
        $NUR3G['zonesNUR2AverageTicketsDur'] =    $zonesAverageTicketsDur;
        $NUR3G['zonesResponseWithoutAccess']= $zonesResponseWithoutAccess;
        $NUR3G['zonesResponseWithAccess']= $zonesResponseWithAccess;
        $NUR3G['zonesTotalNumTickets']= $zonesTotalNumTickets;



        return   $NUR3G;
    }
    public function NUR4GStatestics()
    {
        $NURHelpers=new NURHelpers($this->NUR4G);
        $cairo4GNUR = number_format($this->NUR4G->sum('nur'), 2, '.', ',');
        $zonesNUR =  $NURHelpers->zonesNUR($this->NUR4G->groupBy('oz')->keys(),"nur");
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
        $zonesTotalNumTickets=$NURHelpers->zonesTotalNumTickets($this->NUR4G->groupBy('oz')->keys());

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
        $NUR4G['zonesTotalNumTickets']= $zonesTotalNumTickets;


        return   $NUR4G;
    }

    public function combinedNUR()
    {
        $NUR2G=$this->NUR2GStatestics();
        $zonesNUR2G=$NUR2G['zonesNUR2G'];
        $NUR3G=$this->NUR3GStatestics();
        $zonesNUR3G=$NUR3G['zonesNUR3G'];
        $NUR4G=$this->NUR4GStatestics();
        $zonesNUR4G=$NUR4G['zonesNUR4G'];


        $cairoEastCombined=number_format((($zonesNUR2G['CAIRO EAST'] * $this->NUR2G->first()->network_cells )+($zonesNUR3G['CAIRO EAST'] *$this->NUR3G->first()->network_cells)+($zonesNUR4G['CAIRO EAST']*$this->NUR4G->first()->network_cells))/($this->NUR2G->first()->network_cells+$this->NUR3G->first()->network_cells+$this->NUR4G->first()->network_cells),2, '.', ',') ;

        $cairoSouthCombined=number_format((($zonesNUR2G['CAIRO SOUTH'] * $this->NUR2G->first()->network_cells )+($zonesNUR3G['CAIRO SOUTH'] *$this->NUR3G->first()->network_cells)+($zonesNUR4G['CAIRO SOUTH']*$this->NUR4G->first()->network_cells))/($this->NUR2G->first()->network_cells+$this->NUR3G->first()->network_cells+$this->NUR4G->first()->network_cells),2, '.', ',') ;
        $cairoNorthCombined=number_format((($zonesNUR2G['CAIRO NORTH'] * $this->NUR2G->first()->network_cells )+($zonesNUR3G['CAIRO NORTH'] *$this->NUR3G->first()->network_cells)+($zonesNUR4G['CAIRO NORTH']*$this->NUR4G->first()->network_cells))/($this->NUR2G->first()->network_cells+$this->NUR3G->first()->network_cells+$this->NUR4G->first()->network_cells),2, '.', ',') ;
        $gizaCombined=number_format((($zonesNUR2G['GIZA'] * $this->NUR2G->first()->network_cells )+($zonesNUR3G['GIZA'] *$this->NUR3G->first()->network_cells)+($zonesNUR4G['GIZA']*$this->NUR4G->first()->network_cells))/($this->NUR2G->first()->network_cells+$this->NUR3G->first()->network_cells+$this->NUR4G->first()->network_cells),2, '.', ',') ;
        $combined['CAIRO EAST']=  $cairoEastCombined;
        $combined['CAIRO SOUTH']=  $cairoSouthCombined;
        $combined['CAIRO NORTH']=  $cairoNorthCombined;
        $combined['GIZA']=  $gizaCombined;
        $combined["cairo"]=number_format($cairoEastCombined+$cairoNorthCombined+$cairoSouthCombined+$gizaCombined,2, '.', ',') ;
        return $combined;
    }
}