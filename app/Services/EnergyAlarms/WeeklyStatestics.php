<?php

namespace App\Services\EnergyAlarms;

use App\Services\EnergyAlarms\Helpers;

class WeeklyStatestics
{


    protected $powerAlarms, $genAlarms, $HT, $downAlarms,$week;
    public function __construct($powerAlarms, $genAlarms, $HT, $downAlarms,$week)
    {
        $this->powerAlarms = $powerAlarms;
        $this->genAlarms = $genAlarms;
        $this->HT = $HT;
        $this->downAlarms = $downAlarms;
        $this->week=$week;
    }

    public function zonesPowerAlarmsCount()
    {

        $powerAlarmsStatestics = new Helpers($this->powerAlarms);

        $zonesPowerAlarmsCount = $powerAlarmsStatestics->zonesAlarmsCount($this->powerAlarms->groupBy('operational_zone')->keys());

        return  $zonesPowerAlarmsCount;
    }
    public function zonesSitesReportedPowerAlarms()
    {
        $powerAlarmsStatestics = new Helpers($this->powerAlarms);

        $zonesSitesReportedPowerAlarms = $powerAlarmsStatestics->zonesSitesReportedAlarms($this->powerAlarms->groupBy("operational_zone")->keys());

        return  $zonesSitesReportedPowerAlarms;
    }
    public function zonesSitesPowerAlarmsMoreThan()
    {
        $powerAlarmsStatestics = new Helpers($this->powerAlarms);
        $zonesSitesPowerAlarmsMoreThan = $powerAlarmsStatestics->zonesSitesPowerAlarmsMoreThan($this->powerAlarms->groupBy("operational_zone")->keys(),2);
        return $zonesSitesPowerAlarmsMoreThan;
    }
    public function zonesHighiestPowerAlarmDuration()
    {
        $powerAlarmsStatestics = new Helpers($this->powerAlarms);
        $zonesHighiestPowerAlarmDuration = $powerAlarmsStatestics->zonesHighiestAlarmDuration($this->powerAlarms->groupBy("operational_zone")->keys());
        return   $zonesHighiestPowerAlarmDuration;
    }
    public function zonesPowerDurationLessThanHour()
    {
        $powerAlarmsStatestics = new Helpers($this->powerAlarms);
        $zonesPowerDurationLessThanHour = $powerAlarmsStatestics->zonesPowerDurationLessThanHour($this->powerAlarms->groupBy("operational_zone")->keys());
        return  $zonesPowerDurationLessThanHour;
    }
    public function zonesDownSitesAfterPowerAlarm()
    {
        $powerAlarmsStatestics = new Helpers($this->powerAlarms, $this->downAlarms);
        $zonesDownSitesAfterPowerAlarm = $powerAlarmsStatestics->zonesDownSitesAfterPowerAlarm($this->powerAlarms->groupBy("operational_zone")->keys());
        return   $zonesDownSitesAfterPowerAlarm;
    }

   public function sitesDownWithoutPowerAlarms()
   {
    $powerAlarmsStatestics = new Helpers($this->powerAlarms, $this->downAlarms,$this->week);
    $zonessitesDownWithoutPowerAlarms = $powerAlarmsStatestics->sitesDownWithoutPowerAlarms($this->powerAlarms->groupBy("operational_zone")->keys());
    return  $zonessitesDownWithoutPowerAlarms;

   }
}
