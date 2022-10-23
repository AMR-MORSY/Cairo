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
    public function show_nur(Request $request)
    {
        if($request->input('week'))
        {
            
            $validator=Validator::make($request->all(),["month"=>"nullable","week"=>["required",'regex:/^(week)$/'],"year" => ['required', 'regex:/^2[0-9]{3}$/'],"week_month"=>['required','regex:/^(?:[1-9]|[1-3][0-9]|4[0-8])$/']]);
           
        }
         if($request->input('month'))
        {
            $validator=Validator::make($request->all(),["week"=>"nullable","month"=>["required",'regex:/^(month)$/'],"year" => ['required', 'regex:/^2[0-9]{3}$/'],"week_month"=>['required','regex:/^[1-9]|1[0-2]$/']]);
            
        }
        else if(!$request->input('week') && !$request->input('month'))
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

            if(isset($validated['month']))
            {
              $monthlyNUR= $this->getMonthlyNUR($validated['week_month'],$validated['year']);
              if($monthlyNUR['error'])
              {
                return response()->json([
                    "error"=>$monthlyNUR['errors']

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
                        "error"=>$weeklyNUR['errors']
    
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
            $NUR['combined']=$statestics->combinedNUR();
            return $NUR;
          
        }

      
    }
}
