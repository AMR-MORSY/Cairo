<?php

namespace App\Http\Controllers\Modifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Modifications\Modification;

class ModificationsController extends Controller
{
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

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "columnName" => ['required', "regex:/(status|requester|subcontractor|project)/"],
            "columnValue" => 'required', 'string'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            return response()->json(array(
                'success' => false,
                'message' => 'There are incorect values in the form!',
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);


            $this->throwValidationException(

                $request,
                $validator

            );
        } else {
            $validated = $validated = $validator->validated();
            $modifications = Modification::where($validated['columnName'], $validated['columnValue'])->orderBy('request_date',"desc")->get();

            return response()->json([

                'modifications' => $modifications

            ], 200);
        }
    }
}
