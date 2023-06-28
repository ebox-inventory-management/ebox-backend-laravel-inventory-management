<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Faker\Provider\Image;

class SupplierController extends Controller
{
    protected function uploadSupplierImage($request)
    {
        $supplierImage = $request->file('photo');
        $imageType = $supplierImage->getClientOriginalExtension();
        $imageName = rand(100, 100000) . $request->name . '.' . $imageType;
        $directory = 'inventory/supplier-images/';
        $imageUrl = $directory . $imageName;
        Image::make($supplierImage)->save($imageUrl);
        return $imageUrl;

    }

    public function saveSupplier(Request $request)
    {
        $supplier = new Supplier();

        // upload image to storage
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/suppliers/'), $image_name);
            $supplier->photo = $image_name;
        } else if ($request->photo) {
            $base64_string = $request->photo;
            $image = base64_decode($base64_string);

            $file_name = time() . '.' . 'png';
            $file_path = public_path('images/suppliers/' . $file_name);
            file_put_contents($file_path, $image);
            $supplier->photo = $file_name;
        }
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->type = $request->type;
        $supplier->shop_name = $request->shop_name;
        $supplier->bank_name = $request->bank_name;
        $supplier->bank_number = $request->bank_number;
        $supplier->save();
        return response()->json([
            "message" => "Supplier added successfully!",
            "status" => 200,
        ]);

    }
    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        return response()->json([
            "suppliers" => $suppliers,
            "status" => 200,
        ]);
    }
    public function getSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json([
            "supplier" => $supplier,
            "status" => 200,
        ]);
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $data = $request->all();

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['city'] = $request->city;
        $data['type'] = $request->type;
        $data['shop_name'] = $request->shop_name;
        $data['bank_name'] = $request->bank_name;
        $data['bank_number'] = $request->bank_number;


        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/suppliers/'), $image_name);
            $data['photo'] = $image_name; // remove old image
            $old_image = public_path('images/suppliers/' . $supplier->photo);
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
        } else if ($request->photo) {
            $base64_string = $request->photo;
            $image = base64_decode($base64_string);

            $file_name = time() . '.' . 'png';
            $file_path = public_path('images/suppliers/' . $file_name);
            file_put_contents($file_path, $image);
            $data['photo'] = $file_name; // remove old image
            $old_image = public_path('images/suppliers/' . $supplier->photo);
            if (file_exists($old_image)) {
                @unlink($old_image);
            }
        }
        $supplier->update($data);
        return response()->json([
            "message" => "Supplier data updated successfully!",
            "status" => 200,
        ]);
    }


    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);

        //if($supplier->photo) unlink($supplier->photo);
        $supplier->delete();
        return response()->json([
            "message" => "Supplier removed successfully!",
            "status" => 200,
        ]);

    }

    public function getByName($Supplier)
    {
        $supplier = Supplier::where('name', '=', $Supplier)->first();

        if ($supplier) {
            return response()->json([
                "supplier" => $supplier,
                "status" => 200,
            ]);
        } else {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
    }
    public function getByChar($supplier_name)
    {

        $supplier = Supplier::where('name', 'like', '%' . $supplier_name . '%')->get();

        if ($supplier) {
            return response()->json([
                "suppliers" => $supplier,
                "status" => 200,
            ]);
        } else {
            return response()->json(['error' => 'supplier not found'], 404);
        }
    }

}
