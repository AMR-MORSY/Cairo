<?php

namespace App\Http\Controllers\Sites;

use App\Models\Sites\Site;
use App\Imports\Sites\SitesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

use App\Http\Controllers\Controller;
use App\Exports\sites\AllSitesExport;
use Illuminate\Support\Facades\Validator;

class SitesController extends Controller
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
            if (count($import->failures()) > 0) {
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
}
