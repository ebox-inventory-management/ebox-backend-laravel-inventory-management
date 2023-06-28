<?php

namespace App\Http\Controllers;

use App\Models\Export;
use App\Models\Import;
use App\Models\Products;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function saveImport(Request $request, $id)
    {

        $product = Products::findOrFail($id);
        $product->product_quantity = $product->product_quantity + $request->product_quantity;
        $product->product_amount = $product->product_quantity * $product->import_price;
        $product->update();

        $import = new Import();
        $import->product_id = $id;
        $import->product_name = $product->product_name;
        $import->import_quantity = $request->product_quantity;
        $import->total_import_price = $import->import_quantity * $product->import_price;
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
