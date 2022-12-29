<?php

namespace App\Http\Controllers\NUR;

use App\Models\NUR\NUR2G;
use App\Models\NUR\NUR3G;
use App\Models\NUR\NUR4G;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\NUR\NURStatestics\WeeklyStatestics;
use App\Services\NUR\NURStatestics\MonthlyStatestics;

class ShowNURController extends Controller
{
    public function __construct()
    {
        $this->middleware(["role:admin|super-admin"]);
    }
    public function show_nur($week_month,$week,$month,$year)
    {
        $data=[
            "week_month"=>$week_month,
            "week"=>$week,
            "month"=>$month,
            "year"=>$year
        ];
        if($week!=0)
        {
            
            $validator=Validator::make($data,["month"=>"nullable","week"=>["required",'regex:/^(week)$/'],"year" => ['required', 'regex:/^2[0-9]{3}$/'],"week_month"=>['required','regex:/^(?:[1-9]|[1-4][0-9]|5[0-8])$/']]);
           
        }
        else if($month!=0)
        {
            $validator=Validator::make($data,["week"=>"nullable","month"=>["required",'regex:/^(month)$/'],"year" => ['required', 'regex:/^2[0-9]{3}$/'],"week_month"=>['required','regex:/^[1-9]|1[0-2]$/']]);
            
        }
        else if($week==0 && $month==0)
        {
            return response()->json([
                'period_error' => "Please select week or month",
            ],422);

        }
        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ],422);
        }
        else{
            $validated=$validator->validated();

            if($validated['month']=="month")
            {
              $monthlyNUR= $this->getMonthlyNUR($validated['week_month'],$validated['year']);
              if($monthlyNUR['error'])
              {
                return response()->json([
                    "errors"=>$monthlyNUR['errors']

                ],404);

              }
              else
              {
                return response()->json([
                    "NUR"=>$monthlyNUR,

                ],200);


              }
               

            }
            else{
                $weeklyNUR= $this->getWeeklyNUR($validated['week_month'],$validated['year']);
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
            // if(count($site_2GNUR)>0 && count($site_3GNUR)>0 && count($site_4GNUR)>0)
            // {
                return response()->json([
                    "NUR2G"=>$site_2GNUR,
                    "NUR3G"=>$site_3GNUR,
                    "NUR4G"=>$site_4GNUR,
                ],200);
            // }
            // else
            // {
            //     return response()->json([
            //         'errors' => "No"
            //     ],404);
    

            // }
        }

    }
}
