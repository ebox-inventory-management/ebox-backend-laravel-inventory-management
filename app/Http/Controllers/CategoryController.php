<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function saveCategory(Request $request){

        $this->validate($request,[
            "category_name" => 'required|unique:categories'
        ]);

        $category = new Category();
        $category->category_name =  $request->category_name;
        $category->save();
        return response()->json([
            "message"=>"Category added successfully!",
            "status"=>200
        ]);
    }

    public function getCategories(){
        $categories = Category::all();
        return response()->json([
            "categories"=>$categories,
            "status"=>200
        ]);

    }
    public function getCategory($id){
        $category = Category::findOrFail($id);
        return response()->json([
            "supplier" =>$category,"status"=>200,
        ]);
    }
    public function editCategory($id){
        $category = Category::findOrFail($id);
        return response()->json([
            "category"=>$category,
            "status"=>200
        ]);

    }

    public function updateCategory(Request $request,$id){
//        $this->validate($request,[
//            "id" => 'required',
//            "category_name" => 'required|unique:categories'
//        ]);
        $category = Category::findOrFail($id);
        $category->category_name =  $request->category_name;
        $category->update();
        return response()->json([
            "message"=>"Category updated successfully!",
            "status"=>200
        ]);
    }

    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            "message"=>"Category removed successfully!",
            "status"=>200
        ]);

    }
}
