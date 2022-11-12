<?php

namespace App\Services\EnergyAlarms;

use Illuminate\Support\Collection;


class Helpers
{

    protected $powerAlarmsCollection, $downAlarmsCollection;

    public function __construct($powerAlarms, $downAlarms = null)
    {
        $this->powerAlarmsCollection = $powerAlarms;
        $this->downAlarmsCollection = $downAlarms;
    }

    public function zonesAlarmsCount($zones)
    {
        $oz = [];
        foreach ($zones as $zone) {
            $oz[$zone] = $this->powerAlarmsCollection->where("operational_zone", $zone)->count();
        }

        return $oz;
    }

    public function zonesSitesReportedAlarms($zones)
    {
        $oz = [];
        foreach ($zones as $zone) {
            $siteCodes = $this->powerAlarmsCollection->where("operational_zone", $zone)->groupBy("site_code")->count();
            $oz[$zone] = $siteCodes;
        }
        return $oz;
    }
    public function zonesSitesPowerAlarmsMoreThan($zones,$times)
    {
        $oz = [];
        
        foreach ($zones as $zone) {
            $sites=[];
            $siteCodes = $this->powerAlarmsCollection->where("operational_zone", $zone)->groupBy("site_code");
            foreach($siteCodes as $key=> $codes)
            {
                $subs["siteName"] =  $codes->first()->site_name;
                $subs["siteCode"] =  $codes->first()->site_code;
                $subs["count"] =  $codes->count();
                array_push($sites,$subs);


            }
            $oz[$zone] = collect($sites)->where("count",">",$times);

            
        }
        return $oz;

    }

    public function zonesHighiestAlarmDuration($zones)
    {
        $oz = [];

        foreach ($zones as $zone) {
            $sites = [];
            $siteCodes = $this->powerAlarmsCollection->where("operational_zone", $zone)->groupBy("site_code");

            foreach ($siteCodes as $key => $codes) {

                $siteCode = $codes->sortByDesc("duration");
                $siteCode = $siteCode->first();
                $subs["siteName"] =  $siteCode->site_name;
                $subs["siteCode"] =  $siteCode->site_code;
                $subs["duration"] =  $siteCode->duration;
                array_push($sites, $subs);
            }
            $oz[$zone] = collect($sites)->sortByDesc('duration')->take(5);
        }


        return $oz;
    }
    public function zonesPowerDurationLessThanHour($zones)
    {
        $oz = [];

        foreach ($zones as $zone) {

            $durations = [];
            $countSites = $this->powerAlarmsCollection->where("operational_zone", $zone)->where("duration", "<", 60)->count();
            $durations['count'] = $countSites;

            // foreach ($sites as  $site) {


            //     $subs["siteName"] =  $site->site_name;
            //     $subs["siteCode"] =  $site->site_code;
            //     $subs["duration"] =  $site->duration;
            //     array_push($durations, $subs);
            // }
            $oz[$zone] = $durations;
        }


        return $oz;
    }
    public function zonesDownSitesAfterPowerAlarm($zones)
    {
        // $oz = [];

        // foreach ($zones as $zone) {
            $sites = [];
            $siteCodes = $this->powerAlarmsCollection->where("operational_zone", "Cairo South")->groupBy("site_code");
            $downAlarms=$this->downAlarmsCollection->where("operational_zone","Cairo South");
            foreach ($siteCodes as $key=> $codes) {
                foreach($codes as $code)
                {
                    $downSites = $downAlarms->where("site_code", $code->site_code)->where("alarm_name","NodeB Unavailable")->whereStrict("start_date", $code->start_date)->where("start_time",">=",$code->start_time)->where("end_time","<=",$code->end_time);
                    
                    if (count($downSites) > 0) {
                        foreach($downSites as $site)
                        {
                            $sub["siteCode"] =$site->site_code;
                            $sub["siteName"] =$site->site_name;
                             $sub['duration'] = $code->duration;
                            array_push($sites, $sub);
    
                        }
                       
                      
                    }

                }
                // $downSite = $this->downAlarmsCollection->where("site_code", $code->site_code)->where("start_date", $code->start_date)->where("start_time", "<=", $code->start_time);
                // $downSites=$this->downAlarmsCollection->where("operational_zone", $zone)->where("site_code", $code);
               
            }
            $oz["Cairo East"] = $sites;
        // }
        return $oz;
    }
}
