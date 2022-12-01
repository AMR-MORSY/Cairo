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
    public function zonesSitesPowerAlarmsMoreThan($zones, $times)
    {
        $oz = [];

        foreach ($zones as $zone) {
            $sites = [];
            $siteCodes = $this->powerAlarmsCollection->where("operational_zone", $zone)->groupBy("site_code");
            foreach ($siteCodes as $key => $codes) {
                $subs["siteName"] =  $codes->first()->site_name;
                $subs["siteCode"] =  $codes->first()->site_code;
                $subs["count"] =  $codes->count();
                array_push($sites, $subs);
            }
            $oz[$zone] = collect($sites)->where("count", ">", $times);
        }
        return $oz;
    }

    private function convertMinutesToHours($minutes)
    {
        $quotient = (int)($minutes / 60);
        $remainder = $minutes % 60;
        return " $quotient:$remainder";
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
                $subs["duration"] = $this->convertMinutesToHours( $siteCode->duration);
                array_push($sites, $subs);
            }
            $oz[$zone] = collect($sites)->sortByDesc('duration')->take(10);
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
        $downAlarms = $this->downAlarmsCollection->where("operational_zone", "Cairo South");
        foreach ($siteCodes as $key => $codes) {
            foreach ($codes as $code) {
                $downAlarm = $downAlarms->where("site_code", $code->site_code)->where("alarm_name", "NodeB Unavailable")->whereStrict("start_date", $code->start_date)->where("start_time", ">=", $code->start_time)->where("end_time", "<=", $code->end_time)->first();
                if($downAlarm)
                {
                    $alarm["site_name"]=$downAlarm->site_name;
                    $alarm["site_code"]=$downAlarm->site_code;
                    $alarm["downAlarm_start_date"]=$downAlarm->start_date;
                    $alarm["powerAlarm_start_date"]=$code->start_date;
                    $alarm["downAlarm_id"]=$downAlarm->id;
                    $alarm['durationBeforDown']=intdiv((strtotime($downAlarm->start_time)-strtotime($code->start_time)),60);
                    $alarm["downAlarmDuration"]=intdiv((strtotime($downAlarm->end_time)-strtotime($downAlarm->start_time)),60);
                    array_push($sites,$alarm);

                }
                else{
                    $downAlarm = $downAlarms->where("site_code", $code->site_code)->where("alarm_name", "OML Fault")->whereStrict("start_date", $code->start_date)->where("start_time", ">=", $code->start_time)->where("end_time", "<=", $code->end_time)->first();
                    if($downAlarm){
                        $alarm["site_name"]=$downAlarm->site_name;
                        $alarm["site_code"]=$downAlarm->site_code;
                        $alarm["downAlarm_start_date"]=$downAlarm->start_date;
                        $alarm["powerAlarm_start_date"]=$code->start_date;
                        $alarm["downAlarm_id"]=$downAlarm->id;
                        $alarm['durationBeforDown']=intdiv((strtotime($downAlarm->start_time)-strtotime($code->start_time)),60);
                        $alarm["downAlarmDuration"]=intdiv((strtotime($downAlarm->end_time)-strtotime($downAlarm->start_time)),60);
                        array_push($sites,$alarm);
    

                    }
                  
                }

                
            }
            // $downSite = $this->downAlarmsCollection->where("site_code", $code->site_code)->where("start_date", $code->start_date)->where("start_time", "<=", $code->start_time);
            // $downSites=$this->downAlarmsCollection->where("operational_zone", $zone)->where("site_code", $code);

        }
        $oz["Cairo South"] = $sites;
        // }
        return $oz;
    }
}
