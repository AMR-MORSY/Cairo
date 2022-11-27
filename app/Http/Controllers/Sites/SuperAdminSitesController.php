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

    public function siteUpdate(Site $site)
    {

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
            "severity"=>['nullable','exists:sites,severity'],
            "category"=>['nullable','exists:sites,category'],
            "type"=>['nullable','exists:sites,type'],
            "sharing"=>['nullable','exists:sites,sharing'],
            "oz"=>['nullable','exists:sites,oz'],
            "host"=>['nullable','exists:sites,host'],
            "gest"=>['nullable','exists:sites,gest'],
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
