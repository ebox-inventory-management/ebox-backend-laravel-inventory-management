<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function saveBrand(Request $request)
    {
        $brand = new Brand();

        $brand->name = $request->name;
        $brand->cat_id = $request->cat_id;
        $brand->sup_id = $request->sup_id;
        $brand->save();

        return response()->json([
            "message"=>"Brand added successfully!",
            "status"=>200
        ]);
    }

    public function getBrands()
    {
        $brands  = DB::table('brands');

        return response()->json([
            "brands"=>$brands,
            "status"=>200
        ]);

    }

    public function updateBrand(Request $request,$id)
    {
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->cat_id = $request->cat_id;
        $brand->sup_id = $request->sup_id;
        $brand->update();

        return response()->json([
            "message"=>"Brand data updated successfully!",
            "status"=>200
        ]);
    }


    // if client want to add delete related products
    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json([
            "message"=>"Brand deleted successfully!",
            "status"=>200
        ]);

    }


}
