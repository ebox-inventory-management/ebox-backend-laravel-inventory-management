<?php

namespace App\Http\Controllers;

use App\Models\Export;

use App\Models\Products;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function saveExport(Request $request)
    {

        $export = new Export();
        $export->product_id = $request->product_id;
        $export->export_quantity = $request->export_quantity;
        $export->save();
        return response()->json([
            "message" => "Import added successfully!",
            "status" => 200,
        ]);

    }

    public function getExports()
    {
        $exports = Export::all();

        return response()->json([
            "exports" => $exports,
            "status" => 200,
        ]);
    }
}
