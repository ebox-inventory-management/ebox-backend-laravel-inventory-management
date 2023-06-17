<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Category;
use App\Models\Customer;
use Faker\Provider\Image;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    protected function uploadCustomerImage($request){
        $customerImage = $request->file('photo');
        $imageType = $customerImage->getClientOriginalExtension();
        $imageName = rand(100,100000).$request->name.'.'.$imageType;
        $directory = 'inventory/customer-images/';
        $imageUrl = $directory.$imageName;
        Image::make($customerImage)->save($imageUrl);
        return $imageUrl;
    }

    public function saveCustomer(Request $request){

        $imageUrl='';
        if($request->hasFile('photo'))
        {
            $imageUrl = $this->uploadCustomerImage($request);
        }
        $customer = new Customer();
        $customer-> name = $request-> name;
        $customer-> email = $request-> email;
        $customer-> phone = $request-> phone;
        $customer-> address = $request-> address;
        $customer-> city = $request-> city;
        $customer-> shop_name = $request-> shop_name;
        $customer-> bank_name = $request-> bank_name;
        $customer-> bank_number = $request-> bank_number;
        $customer-> photo = $imageUrl;
        $customer->save();
        return response()->json([
            "message"=>"Customer added successfully!",
            "status"=>200,
        ]);

    }
    public function getCustomers(){
        $customers = Customer::all();
        return response()->json([
            "customers" =>$customers,"status"=>200,
        ]);
    }
    public function getCustomer($id){
        $customer = Customer::findOrFail($id);
        return response()->json([
            "customer" =>$customer,"status"=>200,
        ]);
    }
    public function updatedCustomer(Request $request,$id){


        $customer = Customer::findOrFail($id);
        if($request->hasFile('photo'))
        {
            unlink($customer->photo);
            $customer-> photo = $this->uploadCustomerImage($request);
        }
        $customer-> name = $request-> name;
        $customer-> email = $request-> email;
        $customer-> phone = $request-> phone;
        $customer-> address = $request-> address;
        $customer-> city = $request-> city;
        $customer-> shop_name = $request-> shop_name;
        $customer-> bank_name = $request-> bank_name;
        $customer-> bank_number = $request-> bank_number;
        $customer->save();
        return response()->json([
            "message"=>"Customer data updated successfully!",
            "status"=>200,
        ]);
    }


    public function deleteCustomer($id){
        $customer = Customer::findOrFail($id);
//        if($customer->hasFile('photo'))
//        {
//            unlink($customer->photo);
//        }
        $customer->delete();
        return response()->json([
            "message"=>"Customer removed successfully!",
            "status"=>200,
        ]);

    }


    public function getByName($Customer)
    {
        $customer = Customer::where('name', '=',  $Customer)->first();

        if ($customer) {
            return response()->json( [
                "category" =>$customer,"status"=>200,
            ]);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }



}
