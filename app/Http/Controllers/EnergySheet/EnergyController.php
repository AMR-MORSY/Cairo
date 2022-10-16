<?php

namespace App\Http\Controllers\EnergySheet;

use Illuminate\Http\Request;
use App\Imports\DownAlarmsImport;
use App\Imports\EnergySheetImport;
use App\Imports\PowerAlarmsImport;
use App\Http\Controllers\Controller;
use App\Imports\GenDownAlarmsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HighTempAlarmsImport;
use Illuminate\Support\Facades\Validator;

class EnergyController extends Controller
{
    public function index()
    {
        $weeks = [];
        $years = [];
        for ($i = 1; $i <= 48; $i++) {
            array_push($weeks, $i);
        }
        for ($i = 2022; $i <= 2050; $i++) {
            array_push($years, $i);
        }


        return response()->json([
            "weeks" => $weeks,
            "years" => $years


        ], 200);
    }

    public function __construct()
    {
        $this->middleware(["role:super-admin|admin"]);
    }


    public function store_alarms(Request $request)
    {

        $validator = Validator::make($request->all(), ["week" => ['required', 'regex:/^(?:[1-9]|[1-3][0-9]|4[0-8])$/'], "year" => ['required', 'regex:/^2[0-9]{3}$/'], "energy_sheet" => 'required|mimes:csv,xlsx']);
        $validated = $validator->validated();
        if ($validated) {

            $import = new EnergySheetImport($validated['week'], $validated['year']);
            try {
                $import->onlySheets("Power", "Down", "HT without power", "Power with gen");
                Excel::import($import, $request->file("energy_sheet"));
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
                    "errors" => $errors,
                ], 422);
            }
        } else {

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
