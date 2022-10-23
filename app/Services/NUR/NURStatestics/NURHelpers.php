<?php
namespace App\Services\NUR\NURStatestics;

class NURHelpers{


    private $NUR;
    public function __construct($NUR)
    {
        $this->NUR=$NUR;
        
    }

    public function zonesTotalNumTickets($zones)
    {
        $oz = [];
        foreach ($zones as $zone) {
      
            $oz[$zone] = $this->NUR->where("oz", $zone)->count();
        }
        return $oz;

    }


   public  function zonesNUR($zones,$period)
    {
        $oz = [];
        foreach ($zones as $zone) {
            $data = $this->NUR->where("oz", $zone)->sum($period);
            $oz[$zone] = number_format($data, 2, '.', ',');
        }
        return $oz;
    }

    public function zonesSubsystemNUR($zones,$period)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {
            $subsystems = $this->NUR->groupBy("sub_system")->keys();
            foreach ($subsystems as $system) {
                $operation = $this->NUR->whereStrict("oz", $zone);
                $subs[$system] = number_format($operation->whereStrict('sub_system', $system)->sum($period), 2, '.', ',');
            }
            $filtered = array_filter($subs, function ($value, $key) {
                return $value != 0;
            }, ARRAY_FILTER_USE_BOTH);



            $oz[$zone] = $filtered;
        }



        return $oz;
    }

    public function zonesSubsystemCountTickts($zones)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {
            $subsystems = $this->NUR->groupBy("sub_system")->keys();
            foreach ($subsystems as $system) {
                $subs[$system] = $this->NUR->where("oz", $zone)->where('sub_system', $system)->count();
            }
            $filtered = array_filter($subs, function ($value, $key) {
                return $value != 0;
            }, ARRAY_FILTER_USE_BOTH);

            $oz[$zone] = $filtered;
        }
        return $oz;
    }

    public function zonesTopSitesNur($zones,$period)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {
            $siteCodes = $this->NUR->groupBy("problem_site_code")->keys();
            foreach ($siteCodes as $code) {
                $siteName = $this->NUR->firstWhere("problem_site_code", $code)->problem_site_name;

                $subs[$siteName] = number_format($this->NUR->where("oz", $zone)->where("problem_site_code", $code)->sum($period), 2, '.', ',');
            }

            $filtered = array_filter($subs, function ($value, $key) {
                return $value != 0;
            }, ARRAY_FILTER_USE_BOTH);




            $sub = collect($filtered);
            $sub = $sub->sortDesc();
            $sub = $sub->take(5);
            $oz[$zone] = $sub;
        }
        return $oz;
    }

    public function zonesAccessCountTickts($zones)
    {
        $oz = [];
        $sub = [];
        foreach ($zones as $zone) {


            $sub['access'] = $this->NUR->where("oz", $zone)->where('access', 1)->count();



            $oz[$zone] = $sub;
        }
        return $oz;
    }

    public function zonesAccessNUR($zones,$period)
    {
        $oz = [];
        $sub = [];
        foreach ($zones as $zone) {


            $sub["access"] = number_format($this->NUR->where("oz", $zone)->where('access', 1)->sum($period), 2, '.', ',');



            $oz[$zone] = $sub;
        }
        return $oz;
    }

    public function zonesResponseWithAccess($zones,$period)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {

            $subs['exceedSLA']=number_format($this->NUR->Where("oz", $zone)->where("access",1)->where('Dur_min',">",240)->sum($period),2,'.', ',')  ;
            $subs['withinSLA']=number_format($this->NUR->Where("oz", $zone)->where("access",1)->where('Dur_min',"<=",240)->sum($period),2,".",',')  ;

            $oz[$zone]=$subs;


        }

        return $oz;



    }
    public function zonesResponseWithoutAccess($zones,$period)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {

            $subs['exceedSLA']=number_format($this->NUR->Where("oz", $zone)->where("access",0)->where('Dur_min',">",240)->sum($period),2,'.', ',')  ;
            $subs['withinSLA']=number_format($this->NUR->Where("oz", $zone)->where("access",0)->where('Dur_min',"<=",240)->sum($period),2,".",',')  ;

            $oz[$zone]=$subs;


        }

        return $oz;



    }

    public function zonesRepeatedSites($zones)
    {
        $oz = [];
        $subs = [];
        foreach ($zones as $zone) {
            $siteCodes = $this->NUR->groupBy("problem_site_code")->keys();
            foreach ($siteCodes as $code) {
                $siteName = $this->NUR->firstWhere("problem_site_code", $code)->problem_site_name;

                $subs[$siteName] = $this->NUR->where("oz", $zone)->where("problem_site_code", $code)->count();
            }

            $filtered = array_filter($subs, function ($value, $key) {
                return $value != 0;
            }, ARRAY_FILTER_USE_BOTH);




            $sub = collect($filtered);
            $sub = $sub->sortDesc();
            $sub = $sub->take(5);
            $oz[$zone] = $sub;
        }
        return $oz;
    }

    public function zonesGeneratorStatestics($zones,$period)
    {
        $oz = [];
        $subs = [];

        foreach ($zones as $zone) {
            $VF = [];
            $ET = [];
            $ORG = [];
            $rented = [];
            $allTickets = $this->NUR->where("oz", $zone)->where("sub_system", "generator");
            $ORG = $this->NUR->where("oz", $zone)->where("gen_owner", "orange");
            $rented = $this->NUR->where("oz", $zone)->where("gen_owner", "rented");
            $allTickets = $allTickets->toArray();
            foreach ($allTickets as $ticket) {
                $ticketArray = explode(" ", $ticket['solution']);

                foreach ($ticketArray as $filt) {
                    if ($filt == "vf") {

                        array_push($VF, $ticket);
                        break;
                    }
                    if ($filt == "et") {
                        array_push($ET, $ticket);
                        break;
                    }
                }
                // }
            }
            $VF = collect($VF);
            $ET = collect($ET);
            $VF['count'] = $VF->count();
            $VF["nur"] = number_format($VF->sum($period), 2, '.', ',');
            $ET["count"] = $ET->count();
            $ET['nur'] = number_format($ET->sum($period), 2, '.', ',');
            $ORG['count'] = $ORG->count();
            $ORG['nur'] = number_format($ORG->sum($period), 2, '.', ',');
            $rented['count'] = $rented->count();
            $rented['nur'] = number_format($rented->sum($period), 2, '.', ',');

            $subs['VF'] = $VF;
            $subs['ET'] = $ET;
            $subs['ORG'] = $ORG;
            $subs['Rented'] = $rented;








            $oz[$zone] = $subs;
        }
        return $oz;
    }

    public function zonesAverageTicketsDur($zones)

    {
        $oz = [];

        foreach ($zones as $zone) {
            $accessAverageDurations = $this->NUR->where("oz", $zone)->where('access', 1)->avg('Dur_min');
            $accessAverageDurations = number_format($accessAverageDurations / 60, 2, '.', ',');
            $withoutAccessAverageDurations = $this->NUR->where("oz", $zone)->where('access', 0)->avg('Dur_min');
            $withoutAccessAverageDurations = number_format($withoutAccessAverageDurations / 60, 2, '.', ',');

            // $averageTicketsDur=$durations->avg();

            $oz[$zone]['access'] =  $accessAverageDurations;
            $oz[$zone]['withoutAccess'] =  $withoutAccessAverageDurations;
        }
        return $oz;
    }




}