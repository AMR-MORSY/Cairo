<?php

namespace App\Http\Controllers\NUR;

use App\Models\NUR\NUR2G;
use App\Models\NUR\NUR3G;
use App\Models\NUR\NUR4G;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sites\Site;
use Illuminate\Support\Facades\Validator;
use App\Services\NUR\NURStatestics\WeeklyStatestics;
use App\Services\NUR\NURStatestics\MonthlyStatestics;

class ShowNURController extends Controller
{
    public function __construct()
    {
        $this->middleware(["role:admin|super-admin"]);
    }


    public function show_nur($week,$year)
    {
        $data=[
           
            "week"=>$week,
            
            "year"=>$year
        ];
      
            
            $validator=Validator::make($data,["week"=>["required",'integer',"between:1,52"],"year" => ['required', 'regex:/^2[0-9]{3}$/']]);
           
        
      
      
        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ],422);
        }
        else{
            $validated=$validator->validated();

                $weeklyNUR= $this->getWeeklyNUR($validated['week'],$validated['year']);
                if(isset($weeklyNUR['error']))
                {
                    return response()->json([
                        "errors"=>$weeklyNUR['errors'],
    
                    ],404);
    
  
                }
                else
                {
                    return response()->json([

                        "NUR"=>$weeklyNUR,
                       
    
                    ],200);
    

                  
                }
                 
  
            
        

            
          

        }

    }

    public function getMonthlyNUR($month,$year)
    {
        $total_month_tickets_2G = NUR2G::where('year', $year)->where('month', $month)->get();
        $total_month_tickets_3G = NUR3G::where('year', $year)->where('month', $month)->get();
        $total_month_tickets_4G = NUR4G::where('year', $year)->where('month', $month)->get();
        $errors=[];
        if(count($total_month_tickets_2G)<=0)
        {
             array_push($errors,"2G NUR does not exist");
        }
        if(count($total_month_tickets_3G)<=0)
        {
             array_push($errors,"3G NUR does not exist");
        }
        if(count($total_month_tickets_4G)<=0)
        {
             array_push($errors,"4G NUR does not exist");
        }
        if(count($errors)>0)
        {
            $notFound["error"]=true;
            $notFound["errors"]=$errors;
            return $notFound;
        }
        else
        {
            $statestics=new MonthlyStatestics($total_month_tickets_2G,$total_month_tickets_3G,$total_month_tickets_4G);
            $NUR['NUR2G']=$statestics->NUR2GStatestics();
            $NUR['NUR3G']=$statestics->NUR3GStatestics();
            $NUR['NUR4G']=$statestics->NUR4GStatestics();
            return $NUR;

           
           

        }

      
       

    }
    public function getWeeklyNUR($week,$year)
    {
        $total_week_tickets_2G = NUR2G::where('year', $year)->where('week', $week)->get();
        $total_week_tickets_3G = NUR3G::where('year', $year)->where('week', $week)->get();
        $total_week_tickets_4G = NUR4G::where('year', $year)->where('week', $week)->get();
        $errors=[];
        if(count($total_week_tickets_2G)<=0)
        {
             array_push($errors,"2G NUR does not exist");
        }
        if(count($total_week_tickets_3G)<=0)
        {
             array_push($errors,"3G NUR does not exist");
        }
        if(count($total_week_tickets_4G)<=0)
        {
             array_push($errors,"4G NUR does not exist");
        }
        if(count($errors)>0)
        {
            $notFound["error"]=true;
            $notFound["errors"]=$errors;
            return $notFound;
        }
        else
        {
            $statestics=new WeeklyStatestics($total_week_tickets_2G,$total_week_tickets_3G,$total_week_tickets_4G);
            $NUR['NUR2G']=$statestics->NUR2GStatestics();
            $NUR['NUR3G']=$statestics->NUR3GStatestics();
            $NUR['NUR4G']=$statestics->NUR4GStatestics();
            $NUR["topRepeated"]=$statestics->zonesTopRepeated();
             $NUR["topNUR"]=$statestics->zonesTopNUR();
            $NUR['combined']=$statestics->combinedNUR();
            return $NUR;
          
        }

      
    }

    public function siteNUR(Request $request)
    {
        $validator=validator::make($request->all(),["site_code"=>["required","regex:/^([0-9a-zA-Z]{4,6}(up|UP))|([0-9a-zA-Z]{4,6}(ca|CA))|([0-9a-zA-Z]{4,6}(de|DE))$/"]]);
        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ],422);

        }
        else
        {
            $validated=$validator->validated();
            $site_2GNUR=NUR2G::where("problem_site_code",$validated["site_code"])->get();
            $site_3GNUR=NUR3G::where("problem_site_code",$validated["site_code"])->get();
            $site_4GNUR=NUR4G::where("problem_site_code",$validated["site_code"])->get();
          
                return response()->json([
                    "NUR2G"=>$site_2GNUR,
                    "NUR3G"=>$site_3GNUR,
                    "NUR4G"=>$site_4GNUR,
                ],200);
         
        }

    }
    public function vipSitesWeeklyNUR($zone,$week,$year)
    {
        $data=[
            "zone"=>$zone,
            "week"=>$week,
            "year"=>$year
        ];
        $validator=Validator::make($data,["week"=>["required",'integer',"between:1,52"],"zone" => ['required', 'regex:/^Cairo East|Cairo South|Cairo North|Giza$/'],"year" => ['required', 'regex:/^2[0-9]{3}$/']]);
        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ],422);

        }
        else
        {
            $validated=$validator->validated();
            $vip_sites=Site::where("oz",$validated["zone"])->where("category","VIP")->orWhere("oz",$validated["zone"])->where("category","VIP + NDL")->get();
            $vip_sites_codes=$vip_sites->groupBy("site_code")->keys();
            $vip_sites_names=$vip_sites->groupBy("site_name")->keys();
            $count_vip_codes=count($vip_sites_codes);
            $sites=[];
          

            for($i=0;$i<$count_vip_codes;$i++)
            {
                $vip=[];
                $NUR2G=NUR2G::where("problem_site_code",$vip_sites_codes[$i])->where("week",$week)->where("year",$validated["year"])->get();
                $NUR3G=NUR3G::where("problem_site_code",$vip_sites_codes[$i])->where("week",$week)->where("year",$validated["year"])->get();
                $NUR4G=NUR4G::where("problem_site_code",$vip_sites_codes[$i])->where("week",$week)->where("year",$validated["year"])->get();
               
                if(count($NUR2G)>0)
                {
                    $vip["site_name"]=$vip_sites_names[$i];
                    $vip["site_code"]=$vip_sites_codes[$i];
                    $vip["NUR_2G_count_tickets"]=$NUR2G->count();
                    $vip["NUR_2G_sum_nur"]=number_format( $NUR2G-> sum("nur"), 2, '.', ',') ;
                    $vip["NUR_2G_tickets"]=$NUR2G;

                }
                if(count($NUR3G)>0)
                {
                    $vip["site_name"]=$vip_sites_names[$i];
                    $vip["site_code"]=$vip_sites_codes[$i];
                    $vip["NUR_3G_count_tickets"]=$NUR3G->count();
                    $vip["NUR_3G_sum_nur"] = number_format( $NUR3G-> sum("nur"), 2, '.', ',');
                    $vip["NUR_3G_tickets"]=$NUR3G;

                }
                if(count($NUR4G)>0)
                {
                    $vip["site_name"]=$vip_sites_names[$i];
                    $vip["site_code"]=$vip_sites_codes[$i];
                    $vip["NUR_4G_count_tickets"]=$NUR4G->count();
                    $vip["NUR_4G_sum_nur"]=number_format( $NUR4G-> sum("nur"), 2, '.', ',');
                    $vip["NUR_4G_tickets"]=$NUR4G;

                }
                if(count($vip)>0)
                {
                    array_push($sites,$vip);

                }
               

            }
         
               
            
            return response()->json([
                "sites"=>$sites
            ],200);

        }

    }
}
