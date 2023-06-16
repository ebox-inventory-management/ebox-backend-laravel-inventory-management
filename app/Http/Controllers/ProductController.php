<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Customer;
use App\Models\Export;
use App\Models\Import;
use App\Models\Income;
use App\Models\Products;

use Illuminate\Http\Request;
use Faker\Provider\Image;

class ProductController extends Controller
{
    protected function uploadProductImage($request)
    {
        $productImage = $request->file('product_image');
        //        $imageType = $productImage->file('file');
        $imageName = rand(100, 100000) . $request->product_name . '.jpg';
        $directory = 'inventory/product-images/';
        $imageUrl = $directory . $imageName;
        Image::imageUrl($imageUrl);
        return $imageUrl;

    }


    public function saveProduct(Request $request)
    {

        $imageUrl = $this->uploadProductImage($request);
        $product = new Products();
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->brand_id = $request->brand_id;
        $product->product_name = $request->product_name;

        $product->product_code = $request->product_code;
        $product->product_garage = $request->product_garage;
        $product->product_route = $request->product_route;
        $product->product_image = $request->product_image;
        $product->expire_date = $request->expire_date;
        $product->import_price = $request->import_price;
        $product->export_price = $request->export_price;

        $product->save();
        return response()->json([
            "message" => "Product added successfully!",
            "status" => 200,
        ]);

    }

    public function getProducts()
    {
        $products = Products::all();

        return response()->json([
            "products" => $products,

            "status" => 200,
        ]);
    }


    public function getProduct($id){
        $product = Products::findOrFail($id);
        return response()->json([
            "product" =>$product,"status"=>200,
        ]);
    }

    public function getByName($product_name)
    {
        $product = Products::where('product_name', '=',  $product_name)->first();

        if ($product) {
            return response()->json( [
                "product" =>$product,"status"=>200,
            ]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
//    public function getProduct($id)
//    {
//        $product = Products::table('products')
//            ->join('categories', 'categories.id', '=', 'products.category_id')
//            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
//            ->join('brands', 'brands.id', '=', 'products.brand_id')
//            ->select('products.*', 'brands.name as brand_name', 'suppliers.name as sup_name', 'suppliers.id as supplier_id', 'categories.category_name', 'categories.id as category_id')
//            ->where('products.id', '=', $id)
//            ->first();
//        return response()->json([
//            "product" => $product,
//            "status" => 200,
//        ]);
//    }

    public function updateProduct(Request $request)
    {

        $imageUrl = '';

        $product = Products::findOrFail($request->id);
        if ($request->hasFile('product_image')) {
            $imageUrl = $this->uploadProductImage($request);
            $product->product_image = $imageUrl;
        }
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->brand_id = $request->brand_id;
        $product->product_name = $request->product_name;
        $product->product_quantity = $request->product_quantity;
        $product->product_code = $request->product_code;
        $product->product_garage = $request->product_garage;
        $product->product_route = $request->product_route;
        $product->expire_date = $request->expire_date;
        $product->import_price = $request->import_price;
        $product->export_price = $request->export_price;
        $product->product_amount = $product->product_quantity * $product->import_price;
        $product->update();

        return response()->json([
            "message" => "Product data updated successfully!",
            "status" => 200,
        ]);
    }

    public function deleteProduct($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return response()->json([
            "message" => "Product removed successfully!",
            "status" => 200,
        ]);


    }

    public function getProductByCategory($category_id)
    {
        $products = Products::where('category_id', '=', $category_id)->get();
        return response()->json([
            "products" => $products,
            "status" => 200,
        ]);
    }

    public function getProductByCategoryAndBrand($category_id, $brand_id)
    {
        $products = Products::where('category_id', '=', $category_id)->where('brand_id', '=', $brand_id)->get();
        return response()->json([
            "products" => $products,
            "status" => 200,
        ]);
    }

    public function getProductByCategoryAndSupplier($category_id, $supplier_id)
    {
        $products = Products::where('category_id', '=', $category_id)->where('supplier_id', '=', $supplier_id)->get();
        return response()->json([
            "products" => $products,
            "status" => 200,
        ]);
    }


    public function getProductQuatity($category_id, $supplier_id)
    {
        $products = Products::where('category_id', '=', $category_id)->where('supplier_id', '=', $supplier_id)->get();
        return response()->json([
            "products" => $products,
            "status" => 200,
        ]);
    }
}
