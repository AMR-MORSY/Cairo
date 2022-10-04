<?php

namespace App\Http\Controllers\Sites;

use App\Imports\SitesImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SitesController extends Controller
{
    public function index()
    {
        return view("sites.index");
    }
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), ['sites' => 'required|mimes:csv,xlsx'], ['sites.mimes' => "only csv,xlsx extensions"]);
        $validated = $validator->validated();
        if ($validated) {

            $import = new SitesImport;
            // $import->import($validated['sites']);
            // if ($import->failures()->isNotEmpty()) {

            //     $errors = [];
            //     $error=[];

            //     foreach ($import->failures() as $failure) {
            //            $error['row']= $failure->row(); // row that went wrong
            //            $error['attribute']= $failure->attribute(); // either heading key (if using heading row concern) or column index
            //            $error['errors']=$failure->errors(); // Actual error messages from Laravel validator
            //         $error['value'] = $failure->values(); // The values of the row that has failed.
            //         array_push($errors, $error);
            //     }
            //     return response()->json([
            //         "errors" => $errors,
            //         "fail"=>true
            //     ], 422);

                try {
                    $import->import($validated['sites']);
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    $errors=[];
                    $error=[];

                    foreach ($failures as $failure) {
                       $error['row']= $failure->row(); // row that went wrong
                       $error['attribute']= $failure->attribute(); // either heading key (if using heading row concern) or column index
                       $error['errors']=$failure->errors(); // Actual error messages from Laravel validator
                       $error['values']= $failure->values(); // The values of the row that has failed.
                       array_push($errors,$error);
                    }
                    return response()->json([
                        "errors" => $errors,
                    ], 422);
                }

               
            // }
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
}
