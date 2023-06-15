<?php

namespace App\Http\Controllers;

use App\Models\Export;
use App\Models\Import;
use App\Models\Products;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function saveImport(Request $request)
    {

        $import = new Import();
        $import->product_id = $request->product_id;
        $import->import_quantity = $request->import_quantity;


        $import->save();
        return response()->json([
            "message" => "Import added successfully!",
            "status" => 200,
        ]);

    }

    public function getImports()
    {
        $imports = Import::all();

        return response()->json([
            "imports" => $imports,
            "status" => 200,
        ]);
    }


}
