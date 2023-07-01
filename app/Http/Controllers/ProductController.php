<?php

namespace App\Http\Controllers;


use App\Models\Products;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Faker\Provider\Image;

class ProductController extends Controller
{
    //    protected function uploadProductImage($request)
//    {
//        $productImage = $request->file('product_image');
//        //        $imageType = $productImage->file('file');
//        $imageName = rand(100, 100000) . $request->product_name . '.jpg';
//        $directory = 'inventory/product-images/';
//        $imageUrl = $directory . $imageName;
//        Image::imageUrl($imageUrl);
//        return $imageUrl;
//
//    }

    public function saveProduct(Request $request)
    {
        $product = new Products();

        // upload image to storage
//        if ($request->hasFile('product_image')) {
//            $image = $request->file('product_image');
//            $image_name = time() . '.' . $image->getClientOriginalExtension();
//            $image->move(public_path('images/products/'), $image_name);
//            $product->product_image = $image_name;
//        } else if ($request->product_image) {
//            $base64_string = $request->product_image;
//            $image = base64_decode($base64_string);
//
//            $file_name = time() . '.' . 'png';
//            $file_path = public_path('images/products/' . $file_name);
//            file_put_contents($file_path, $image);
//            $product->product_image = $file_name;
//        }
        // upload image to storage for Cloudinary
        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->getRealPath();
            $uploadedImage = Cloudinary::upload($imagePath)->getSecurePath();
            $product->product_image = $uploadedImage;
        } else if ($request->product_image) {
            $imageBase64 = $request->product_image;
            $uploadedImage = Cloudinary::upload("data:image/png;base64," . $imageBase64)->getSecurePath();
            $product->product_image = $uploadedImage;
        }
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->brand_id = $request->brand_id;
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->product_garage = $request->product_garage;
        $product->product_route = $request->product_route;
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


    public function getProduct($id)
    {
        $product = Products::findOrFail($id);
        return response()->json([
            "product" => $product,
            "status" => 200,
        ]);
    }

    public function getByName($product_name)
    {
        $product = Products::where('product_name', '=', $product_name)->first();

        if ($product) {
            return response()->json([
                "product" => $product,
                "status" => 200,
            ]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function getByChar($product_name)
    {


        $products = Products::where('product_name', 'like', '%' . $product_name . '%')->get();

        if ($products) {
            return response()->json([
                "products" => $products,
                "status" => 200,
            ]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $data = $request->all();

        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['product_garage'] = $request->product_garage;
        $data['product_route'] = $request->product_route;
        $data['expire_date'] = $request->expire_date;
        $data['import_price'] = $request->import_price;
        $data['export_price'] = $request->export_price;

        // if ($request->hasFile('product_image')) {
        //     $image = $request->file('product_image');
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images/products/'), $image_name);
        //     $data['product_image'] = $image_name; // remove old image
        //     $old_image = public_path('images/products/' . $product->product_image);
        //     if (file_exists($old_image)) {
        //         @unlink($old_image);
        //     }
        // } else if ($request->product_image) {
        //     $base64_string = $request->product_image;
        //     $image = base64_decode($base64_string);

        //     $file_name = time() . '.' . 'png';
        //     $file_path = public_path('images/products/' . $file_name);
        //     file_put_contents($file_path, $image);
        //     $data['product_image'] = $file_name; // remove old image
        //     $old_image = public_path('images/products/' . $product->product_image);
        //     if (file_exists($old_image)) {
        //         @unlink($old_image);
        //     }
        // }

        // upload image to storage for Cloudinary
        if ($request->hasFile('product_image')) {

            //check if old image exist
            $old_image = Cloudinary::getImage($product->product_image);
            if ($old_image->getPublicId() != null) {
                Cloudinary::destroy($old_image->getPublicId());
            }

            //set image to response json
            $imagePath = $request->file('product_image')->getRealPath();
            $uploadedImage = Cloudinary::upload($imagePath)->getSecurePath();
            $data['product_image'] = $uploadedImage;


        } else if ($request->product_image) {
            //check if old image exist
            $old_image = Cloudinary::getImage($product->product_image);
            if ($old_image->getPublicId() != null) {
                Cloudinary::destroy($old_image->getPublicId());
            }
            //set image to response json
            $imageBase64 = $request->product_image;
            $uploadedImage = Cloudinary::upload("data:image/png;base64," . $imageBase64)->getSecurePath();
            $data['product_image'] = $uploadedImage;
        }

        $product->update($data);


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