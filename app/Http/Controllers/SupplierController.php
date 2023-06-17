<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Faker\Provider\Image;
class SupplierController extends Controller
{
    protected function uploadSupplierImage($request){
        $supplierImage = $request->file('photo');
        $imageType = $supplierImage->getClientOriginalExtension();
        $imageName = rand(100,100000).$request->name.'.'.$imageType;
        $directory = 'inventory/supplier-images/';
        $imageUrl = $directory.$imageName;
        Image::make($supplierImage)->save($imageUrl);
        return $imageUrl;

    }

    public function saveSupplier(Request $request){

        $imageUrl='';
        if($request->hasFile('photo'))
        {
            $imageUrl = $this->uploadSupplierImage($request);
        }
        $supplier = new Supplier();
        $supplier-> name = $request-> name;
        $supplier-> email = $request-> email;
        $supplier-> phone = $request-> phone;
        $supplier-> address = $request-> address;
        $supplier-> city = $request-> city;
        $supplier-> type = $request-> type;
        $supplier-> shop_name = $request-> shop_name;
        $supplier-> bank_name = $request-> bank_name;
        $supplier-> bank_number = $request-> bank_number;
        $supplier-> photo = $imageUrl;
        $supplier->save();
        return response()->json([
            "message"=>"Supplier added successfully!",
            "status"=>200,
        ]);

    }
    public function getSuppliers(){
        $suppliers = Supplier::all();
        return response()->json([
            "suppliers" =>$suppliers,"status"=>200,
        ]);
    }
    public function getSupplier($id){
        $supplier = Supplier::findOrFail($id);
        return response()->json([
            "supplier" =>$supplier,"status"=>200,
        ]);
    }

    public function updateSupplier(Request $request,$id){
        $supplier = Supplier::findOrFail($id);
        if($request->hasFile('photo'))
        {
            if($supplier->photo) unlink($supplier->photo);
            $supplier-> photo = $this->uploadCustomerImage($request);
        }
        $supplier-> name = $request-> name;
        $supplier-> email = $request-> email;
        $supplier-> phone = $request-> phone;
        $supplier-> address = $request-> address;
        $supplier-> city = $request-> city;
        $supplier-> type = $request-> type;
        $supplier-> shop_name = $request-> shop_name;
        $supplier-> bank_name = $request-> bank_name;
        $supplier-> bank_number = $request-> bank_number;
        $supplier->save();
        return response()->json([
            "message"=>"Supplier data updated successfully!",
            "status"=>200,
        ]);
    }


    public function deleteSupplier($id){
        $supplier = Supplier::findOrFail($id);

        //if($supplier->photo) unlink($supplier->photo);
        $supplier->delete();
        return response()->json([
            "message"=>"Supplier removed successfully!",
            "status"=>200,
        ]);

    }

    public function getByName($Supplier)
    {
        $supplier = Supplier::where('name', '=',  $Supplier)->first();

        if ($supplier) {
            return response()->json( [
                "category" =>$supplier,"status"=>200,
            ]);
        } else {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
    }
}
