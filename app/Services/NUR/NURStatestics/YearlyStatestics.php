<?php

namespace App\Services\NUR\NURStatestics;

use App\Models\NUR\NUR4G;

class YearlyStatestics
{

    private $NUR2G, $NUR3G, $NUR4G,$year,$allTickets;

    public function __construct($NUR2G, $NUR3G, $NUR4G,$year)
    {
        $this->NUR2G = $NUR2G;
        $this->NUR3G = $NUR3G;
        $this->NUR4G = $NUR4G;
        $this->year=$year;
      
    }

    private function zonesNUR_C()
    {
        $zones=$this->NUR2G->where("year",$this->year)->groupBy("oz")->keys();
        $zonesNUR_C=[];
        foreach($zones as $zone)
        {
            $zoneNUR_2G=$this->NUR2G->where("oz",$zone)->where("year",$this->year);
            $zoneNUR_3G=$this->NUR3G->where("oz",$zone)->where("year",$this->year);
            $zoneNUR_4G=$this->NUR4G->where("oz",$zone)->where("year",$this->year);
            $NUR_C=$this->getNUR_C($zoneNUR_2G,$zoneNUR_3G,$zoneNUR_4G);
            $zonesNUR_C[$zone]=$NUR_C;

        }

        return $zonesNUR_C;
    }
    private function getNUR_C($NUR2G,$NUR3G,$NUR4G)
    {
        $NUR_2G_weekly=$NUR2G->where("year",$this->year)->groupBy("week");
        $weeks_2G_NUR=[];
        $weeks_2G_network_cells=[];
        // $zone_2G=[];
        // $zone_2G_sum_NUR=[];
        foreach( $NUR_2G_weekly as $key=>$NURs)
        {
            $weeks_2G_NUR[$key]= number_format($NURs->sum("nur"),2,".",",") ;
            $weeks_2G_network_cells[$key]=$NURs->first()->network_cells;
            // $zones=$NURs->groupBy("oz");
            // foreach($zones as $ky=>$val)
            // {
            //     $zones[$ky]=$zone_2G_sum_NUR[$key]

            // }
           

           

        }
        $NUR_3G_weekly=$NUR3G->where("year",$this->year)->groupBy("week");
        $weeks_3G_NUR=[];
        $weeks_3G_network_cells=[];
        foreach( $NUR_3G_weekly as $key=>$NURs)
        {
            $weeks_3G_NUR[$key]= number_format($NURs->sum("nur"),2,".",",") ;
            $weeks_3G_network_cells[$key]=$NURs->first()->network_cells;
           

        }
        $NUR_4G_weekly=$NUR4G->where("year",$this->year)->groupBy("week");
        $weeks_4G_NUR=[];
        $weeks_4G_network_cells=[];
        foreach( $NUR_4G_weekly as $key=>$NURs)
        {
            $weeks_4G_NUR[$key]= number_format($NURs->sum("nur"),2,".",",") ;
            $weeks_4G_network_cells[$key]=$NURs->first()->network_cells;
           

        }
        $NUR_C=[];
        foreach($weeks_2G_NUR as $key=>$value)
        {
            $combined=(($weeks_2G_NUR[$key]* $weeks_2G_network_cells[$key])+($weeks_3G_NUR[$key]* $weeks_3G_network_cells[$key])+($weeks_4G_NUR[$key]* $weeks_4G_network_cells[$key]))/($weeks_2G_network_cells[$key]+$weeks_3G_network_cells[$key]+$weeks_4G_network_cells[$key]);
            $NUR_C["week $key"]=number_format($combined,2,".",",");

        }
     
        return $NUR_C;


    }
    public function cairoNUR_C()
    {
        $cairoNUR_C=$this->getNUR_C($this->NUR2G,$this->NUR3G,$this->NUR4G);
        $zonesNUR_c=$this->zonesNUR_C();

        return [
            "cairo"=>$cairoNUR_C,
            "zones"=>$zonesNUR_c
        ];
       
      
    }
    private function calculateCombinedNUR($NUR2G, $NUR3G, $NUR4G)
    {
        if (count($NUR2G) > 0) {
            $sum_NUR_2G = number_format($NUR2G->sum("nur"), 2, '.', ',');
        } else {
            $sum_NUR_2G = 0;
        }
        if (count($NUR3G) > 0) {
            $sum_NUR_3G = number_format($NUR3G->sum("nur"), 2, '.', ',');
        } else {
            $sum_NUR_3G = 0;
        }
        if (count($NUR4G) > 0) {
            $sum_NUR_4G = number_format($NUR4G->sum("nur"), 2, '.', ',');
        } else {
            $sum_NUR_4G = 0;
        }
        // $NUR_c = (($sum_NUR_2G * $this->network_2G_cells) + ($sum_NUR_3G * $this->network_3G_cells) + ($sum_NUR_4G * $this->network_4G_cells)) / ($this->network_2G_cells + $this->network_3G_cells + $this->network_4G_cells);
        // return $NUR_c;
    }


    
   
}