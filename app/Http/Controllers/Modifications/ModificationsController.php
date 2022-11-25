<?php

namespace App\Http\Controllers\Modifications;

use Carbon\Carbon;
use App\Models\Sites\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Modifications\Modification;

class ModificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware("role:super-admin|admin");
        
    }
    private function get_column_values($column_name)
    {

        $keys = Modification::all()->groupBy($column_name)->keys();


        return $keys;
    }

    public function analysis()
    {
        $analysis = [];
        $status = $this->get_column_values('status');
        $subcontractor = $this->get_column_values('subcontractor');
        $project = $this->get_column_values('project');
        $requester = $this->get_column_values('requester');
        $analysis["status"] = $status;
        $analysis["subcontractor"] =  $subcontractor;
        $analysis["project"] = $project;
        $analysis["requester"] = $requester;

        return response()->json([
            'status' => '200',
            'message' => 'success',
            'index' => $analysis

        ]);
    }

    public function index($colmnName,$colmnValue)
    {
        $data=[
            "columnName" => $colmnName,
            "columnValue" =>$colmnValue
        ];
        $validator = Validator::make($data, [
            "columnName" => ['required', "regex:/(status|requester|subcontractor|project)/"],
            "columnValue" => ['required', 'string']
        ]);
        if ($validator->fails()) {
          
            return response()->json(array(
                'success' => false,
                'message' => 'There are incorect values in the form!',
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);


            $this->throwValidationException(

                
                $validator

            );
        } else {
            $validated = $validated = $validator->validated();
            $modifications = Modification::where($validated['columnName'], $validated['columnValue'])->orderBy('request_date', "desc")->get();

            return response()->json([

                'modifications' => $modifications

            ], 200);
        }
    }

    public function modificationDetails($id)
    {
        if ($id == "null") {
            $id = null;
        }
        $data = [
            "id" => $id,
        ];
        $validator = Validator::make($data, ["id" => ['required', "exists:modifications,id"]]);
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
            $details = Modification::find($validated["id"]);
            return response()->json([
                "message" => "success",
                "details" => $details,


            ], 200);
        }
    }

    public function modificationUpdate(Request $request)
    {
        $ruls = [
            "id" => ['required', "exists:modifications,id"],
            "modification.*.site_code" => "required|exists:modifications,site_code",
            "modification.*.site_name" => "required|exists:modifications,site_name",
            "modification.*.requester" => "required|exists:modifications,requester",
            "modification.*.subcontractor" => "required|exists:modifications,subcontractor",
            "modification.*.request_date" => "required|date",
            "modification.*.finish_date" => "nullable|date",
            "modification.*.status" => "required|exists:modifications,status",
            "modification.*.project" => "required|exists:modifications,project",
            "modification.*.cost" => "nullable|numeric",
            "modification.*.action" => "required|string",
            "modification.*.materials" => "nullable|string",
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
            $modification = Modification::find($validated["id"]);
            $modification->requester=$validated["requester"];
            $modification->subcontractor=$validated["subcontractor"];
            $modification->status=$validated["status"];
            $modification->request_date=$validated["request_date"];
            $modification->finish_date=$validated["finish_date"];
            $modification->cost=$validated["cost"];
            $modification->project=$validated["project"];
            $modification->action=$validated["action"];
            $modification->materials=$validated["materials"];
            $modification->save();

            return response()->json([
                "message" => "Updated successfully ",
                


            ], 200);
        }
    }

    public function siteModifications($site_code)
    {
        if ($site_code == "null") {
            $site_code = null;
        }
        $data = [
            "site_code" => $site_code
        ];
        $validator = Validator::make($data, ["site_code" => ['required', "exists:sites,site_code"]]);

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
            $siteCode = $validated['site_code'];

            $site = Site::where("site_code", $siteCode)->first();
            if ($site) {
                $modifications = $site->modifications;

                return response()->json([
                    "message" => "success",
                    "modifications" => $modifications,


                ], 200);
            } else {
                return response()->json([
                    "message" => "Site Not Found",

                ], 404);
            }
        }
    }

    private function dateFormat($date)
    {
       $newDate= Carbon::parse($date);
       return $newDate=$newDate->format("Y-m-d");
    }

    public function newModification(Request $request)
    {
        // $data=json_encode($request->all(),true);
        // // return response(
        // //     $data
        // // );
        $ruls=[
            "siteCode"=>"required|exists:sites,site_code",
            "siteName"=>"required|exists:sites,site_name",
            "subcontractor"=>"required|exists:modifications,subcontractor",
            "requester"=>"required|exists:modifications,requester",
            "project"=>"required|exists:modifications,project",
            "action"=>"required|string",
            "cost"=>"nullable|numeric",
            "status"=>"required|exists:modifications,status",
            "materials"=>"nullable|string",
            "request_date"=>"required|date",
            "finish_date"=>"nullable|date",
    
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
             Modification::create([
                "site_code"=>$validated["siteCode"],
            "site_name"=>$validated["siteName"],
            "cost"=>$validated["cost"],
            "status"=>$validated["status"]['status'],
            "project"=>$validated["project"]["project"],
            "subcontractor"=>$validated["subcontractor"]['subcontractor'],
            "requester"=>$validated["requester"]['requester'],
            "action"=>$validated["action"],
            "materials"=>$validated["materials"],
            "request_date"=>$this->dateFormat(  $validated["request_date"]) ,
            "finish_date"=>$this->dateFormat(  $validated["finish_date"]),
    
        ]);
            return response()->json([
                "message"=>$validated

            ],200);
        }
    }
}
