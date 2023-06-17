<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function saveCategory(Request $request)
    {

        $this->validate($request, [
            "name" => 'required|unique:categories'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return response()->json([
            "message" => "Category added successfully!",
            "status" => 200
        ]);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            "categories" => $categories,
            "status" => 200
        ]);

    }
    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            "category" => $category,
            "status" => 200,
        ]);
    }
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            "category" => $category,
            "status" => 200
        ]);

    }

    public function updateCategory(Request $request, $id)
    {
        //        $this->validate($request,[
//            "id" => 'required',
//            "name" => 'required|unique:categories'
//        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->update();
        return response()->json([
            "message" => "Category updated successfully!",
            "status" => 200
        ]);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            "message" => "Category removed successfully!",
            "status" => 200
        ]);

    }

    public function getByName($Category)
    {
        $category = Category::where('name', '=',  $Category)->first();

        if ($category) {
            return response()->json( [
                "category" =>$category,"status"=>200,
            ]);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }
}
