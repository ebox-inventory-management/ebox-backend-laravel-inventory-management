<?php

use App\Http\Controllers\Auth\UserAuthController;

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Customer
Route::post("customer/add",[CustomerController::class,"saveCustomer"])->name("add-customer");
Route::get("customers",[CustomerController::class,"getCustomers"])->name("all-customers");
Route::get("customer/view/{id}",[CustomerController::class,"getCustomer"])->name("customer");
Route::post("customer/update/{id}",[CustomerController::class,"updatedCustomer"])->name("update-customer");
Route::get("customer/delete/{id}",[CustomerController::class,"deleteCustomer"])->name("delete-customer");

//Supplier
Route::post("supplier/add",[SupplierController::class,"saveSupplier"])->name("add-supplier");
Route::get("suppliers",[SupplierController::class,"getSuppliers"])->name("all-suppliers");
Route::get("supplier/view/{id}",[SupplierController::class,"getSupplier"])->name("suppliers");
Route::post("supplier/update/{id}",[SupplierController::class,"updateSupplier"])->name("update-supplier");
Route::get("supplier/delete/{id}",[SupplierController::class,"deleteSupplier"])->name("delete-supplier");


//Category
Route::post("category/add",[CategoryController::class,"saveCategory"])->name("addCategory");
Route::get("categories",[CategoryController::class,"getCategories"])->name("categories");
Route::get("category/view/{id}",[CategoryController::class,"getCategory"])->name("category");
Route::post("category/update/{id}",[CategoryController::class,"updateCategory"])->name("updateCategory");
Route::get("category/delete/{id}",[CategoryController::class,"deleteCategory"])->name("deleteCategory");

//Brand
Route::post("brand/add",[BrandController::class,"saveBrand"])->name("addBrand");
Route::get("brands",[BrandController::class,"getBrands"])->name("brands");
Route::post("brand/update/{id}",[BrandController::class,"updateBrand"])->name("updateBrand");
Route::get("brand/view/{id}",[BrandController::class,"getBrand"])->name("viewBrand");
Route::get("brand/delete/{id}",[BrandController::class,"deleteBrand"])->name("deleteBrands");

//Product
Route::post("product/add",[ProductController::class,"saveProduct"])->name("addProduct");
Route::get("products",[ProductController::class,"getProducts"])->name("products");
Route::post("product/update/{id}",[ProductController::class,"updateProduct"])->name("editProduct");
Route::get("product/view/{id}",[ProductController::class,"getProduct"])->name("viewProduct");
Route::get("product/name/{product_name}",[ProductController::class,"getByName"])->name("viewProductName");
Route::get("product/delete/{id}",[ProductController::class,"deleteProduct"])->name("deleteProduct");

//Expense
Route::get("expense",[ExpenseController::class,"getExpenses"])->name("expenses");
Route::get("expense/view/{id_product}",[ExpenseController::class,"getExpense"])->name("viewProductExpenseByID");
Route::get("expense/name/{product_name}",[ExpenseController::class,"getExpenseByName"])->name("viewProductExpenseByName");
Route::get("expense/{formDate}/{toDate}",[ExpenseController::class,"getExpenseInRange"])->name("expenseInRange");
Route::get("expense/today",[ExpenseController::class,"getTodayExpense"])->name("todayExpense");
Route::get("expense/month",[ExpenseController::class,"getMonthExpense"])->name("monthlyExpense");
Route::get("expense/year",[ExpenseController::class,"getYearExpense"])->name("yearlyExpense");

//Income
Route::post("income/add",[IncomeController::class,"saveIncome"])->name("addIncome");
Route::get("incomes",[IncomeController::class,"getIncomes"])->name("Income");
Route::post("income/update/{id}",[IncomeController::class,"updateIncome"])->name("updateIncome");
Route::get("incomes/{formDate}/{toDate}",[IncomeController::class,"getIncomeInRange"])->name("incomeInRange");
Route::get("income/today",[IncomeController::class,"getTodayIncome"])->name("todayIncome");
Route::get("income/month/{month}",[IncomeController::class,"getMonthIncome"])->name("monthlyIncome");
Route::get("income/year",[IncomeController::class,"getYearIncome"])->name("yearlyIncome");

//Import
Route::post("import/add",[ImportController::class,"saveImport"])->name("addImport");
Route::get("imports",[ImportController::class,"getImports"])->name("Imports");

//Get Category
Route::get("products/category/{cat_id}",[ProductController::class,"getProductByCategory"])->name("productsByCategory");
Route::get("products/category/brand/{cat_id}/{brand_id}",[ProductController::class,"getProductByCategoryAndBrand"])->name("productsByCategoryAndBrand");
Route::get("products/category/supplier/{cat_id}/{sup_id}",[ProductController::class,"getProductByCategoryAndSupplier"])->name("productsByCategoryAndSupplier");


Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/user/{id}', [UserAuthController::class, 'update']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user', [UserAuthController::class, 'show']);
