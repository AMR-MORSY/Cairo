<?php

namespace App\Http\Controllers\Sites;

use App\Models\Sites\Site;
use App\Imports\Sites\SitesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

use App\Http\Controllers\Controller;
use App\Exports\sites\AllSitesExport;
use Illuminate\Support\Facades\Validator;

class SuperAdminSitesController extends Controller
{
    public function index()
    {
        return view("sites.index");
    }
    public function __construct()
    {
        $this->middleware(["role:super-admin"]);
    }

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['sites' => 'required|mimes:csv,xlsx'], ['sites.mimes' => "only csv,xlsx extensions"]);
        $validated = $validator->validated();
        if ($validated) {

            $import = new SitesImport;


            $import->import($validated['sites']);
            if ($import->failures() ) {
                $errors = [];
                $error = [];

                foreach ($import->failures() as $failure) {
                    $error['row'] = $failure->row(); // row that went wrong
                    $error['attribute'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $error['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                    $error['values'] = $failure->values(); // The values of the row that has failed.
                    array_push($errors, $error);
                }
                return response()->json([
                    "sheet_errors" => $errors,
                ], 422);
            } else {
                return response()->json([
                    "message" => "inserted Succesfully",
                ], 200);
            }
        } else {
            return response()->json([
                "errors" => $validator->getMessageBag()->toArray(),
            ], 422);
            $this->throwValidationException(

                $request,
                $validator

            );
        }
    }
    public function export_all(Request $request)
    {
        // $export=new AllSitesExport();
        // $export->download('AllSites.xlsx');
        return new AllSitesExport();
    }

    public function siteUpdate(Request $request)
    {
        $ruls=[
            "site_code"=>["required","exists:sites,site_code"],
            "site_name"=>["required","exists:sites,site_name"],
            "BSC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
             "RNC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
             "office"=>["nullable", "string"],
             "severity"=>['nullable',"regex:/^Golden|Bronze|Silver$/"],
             "category"=>['nullable',"regex:/^Normal|BSC|NDL|LDN|VIP+NDL|VIP$/"],
             "type"=>['nullable','regex:/^Shelter|Micro|Outdoor$/'],
             "sharing"=>['nullable',"regex:/^Yes|No$/"],
             "oz"=>['nullable','regex:/^Cairo South|Cairo East|Cairo North|Giza$/'],
             "host"=>['nullable',"regex:/^VF|OG||ET||WE$/"],
             "gest"=>['nullable',"regex:/^VF|OG||ET||WE$/"],
             "2G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
             "3G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
             "4G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
         ];
         $validator = Validator::make($request->all(), $ruls);
         
         if ($validator->fails()) {
             return response()->json(
                 [
                     "errors" => $validator->getMessageBag()->toArray(),
 
                 ],
                 422
             );
             $this->throwValidationException(
 
 
                 $validator
 
             );
         } else {
             $validated = $validator->validated();
             $site=Site::where("site_code",$validated['site_code'])->first();
             $site['BSC']=$validated["BSC"];
             $site['RNC']=$validated["RNC"];
             $site['office']=$validated["office"];
             $site['severity']=$validated["severity"];
             $site['oz']=$validated["oz"];
             $site['sharing']=$validated["sharing"];
             $site['host']=$validated["host"];
             $site['gest']=$validated["gest"];
             $site['type']=$validated["type"];
             $site['category']=$validated["category"];
             $site["2G_cells"]=$validated["2G_cells"];
             $site["3G_cells"]=$validated["3G_cells"];
             $site["4G_cells"]=$validated["4G_cells"];
           $site->save();
           
             return response()->json([
                 "site"=>$site
 
             ],200);
 
         }
         

    }
    public function siteDelete(Site $site)
    {
        
    }
    public function siteCreate(Request $request)
    {

        $ruls=[
           "site_code"=>["required","unique:sites,site_code","regex:/^([0-9a-zA-Z]{4,6}(up|UP))|([0-9a-zA-Z]{4,6}(ca|CA))|([0-9a-zA-Z]{4,6}(de|DE))$/"],
           "site_name"=>["required", "regex:/^([0-9a-zA-Z_-]|\s){2,60}$/"],
           " BSC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
            "RNC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
            "office"=>["nullable", "string"],
            "severity"=>['nullable',"regex:/^Golden|Bronze|Silver$/"],
            "category"=>['nullable',"regex:/^Normal|BSC|NDL|LDN|VIP+NDL|VIP$/"],
            "type"=>['nullable','regex:/^Shelter|Micro|Outdoor$/'],
            "sharing"=>['nullable',"regex:/^Yes|No$/"],
            "oz"=>['nullable','regex:/^Cairo South|Cairo East|Cairo North|Giza$/'],
            "host"=>['nullable',"regex:/^VF|OG||ET||WE$/"],
            "gest"=>['nullable',"regex:/^VF|OG||ET||WE$/"],
            "2G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
            "3G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
            "4G_cells"=> ["nullable", "regex:/^(100)|[1-9]\d?$/"],
        ];
        $validator = Validator::make($request->all(), $ruls);
        
        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->getMessageBag()->toArray(),

                ],
                422
            );
            $this->throwValidationException(


                $validator

            );
        } else {
            $validated = $validator->validated();
            Site::create($validated);
            return response()->json([
                "message"=>"inserted Successfully"

            ],200);

        }
        
        
    }
}
