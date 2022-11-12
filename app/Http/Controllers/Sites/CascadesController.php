<?php

namespace App\Http\Controllers\Sites;

use App\Models\Cascade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Sites\CascadesImport;
use App\Exports\sites\AllCascadesExport;
use Illuminate\Support\Facades\Validator;

class CascadesController extends Controller
{
    public function index(Request $request)
    {
      return  Cascade::all();
    }

    public function __construct()
    {
        $this->middleware("role:super-admin|admin");
    }
    public function exportAllCascades()
    {
       
        return new AllCascadesExport();
    }

    public function updateCascades(Request $request)
    {
        
    }

    public function importCascades(Request $request)
    {
        $import=new CascadesImport();

        $validator=Validator::make($request->all(),["cascades" => 'required|mimes:csv,xlsx']);
        $validated=$validator->validated();

    

        if($validated)
        {
           
            try {
                Excel::import($import,  $validated["cascades"]);
                   
            
                return response()->json([
                    "message" => "inserted Succesfully",
                ]);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $errors = [];
                $error = [];
    
                foreach ($failures as $failure) {
                    $error['row'] = $failure->row(); // row that went wrong
                    $error['attribute'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $error['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                    $error['values'] = $failure->values(); // The values of the row that has failed.
                    array_push($errors, $error);
                }
                return response()->json([
                    "sheet_errors" => $errors,
                ], 422);
            }

        }
        else
        {
            return response()->json(array(
                'success' => false,
                'message' => 'There are incorect values in the form!',
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);


            $this->throwValidationException(

                $request,
                $validator

            );

        }



    }
}
