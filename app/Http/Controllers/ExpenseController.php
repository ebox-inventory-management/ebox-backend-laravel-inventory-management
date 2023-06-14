<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function getExpenses()
    {
        $Expense = Products::sum('total_import');
        return response()->json([
            "Total Expense" =>$Expense,
            "status"=>200,
        ]);
    }

    public function getExpense($id_product){
        $Expense = Products::where('id', $id_product)->sum('total_import');
        return response()->json([
            "Total Expense" =>$Expense,
            "status"=>200,
        ]);
    }

    public function getExpenseByName($product_name){
        $Expense = Products::where('product_name', $product_name)->sum('total_import');
        return response()->json([
            "Total Expense" =>$Expense,
            "status"=>200,
        ]);
    }

    public function getTodayExpense()
    {

        $todayExpense = Products::whereDate('created_at', today())->sum('total_import');
        return response()->json(['today_expense' => $todayExpense]);
    }

    public function getMonthExpense()
    {
        $now = Carbon::now();
        $summonthExpense = Products::whereMonth('created_at', $now->month)->sum('total_import');
        return response()->json([
            "total"=> $summonthExpense,
            'status' => 200
        ]);
    }


    public function getYearExpense()
    {
        $now = Carbon::now();
        $sumyearIncome = Products::whereYear('created_at', $now->year)->sum('total_import');
        return response()->json([

            "total" => $sumyearIncome,
            'status' => 200
        ]);
    }
    public function getExpenseInRange($formDate, $toDate)
    {

        $formDate = date_format(date_create($formDate), "Y-m-d 0:0:0");
        $toDate = date_format(date_create($toDate), "Y-m-d 0:0:0");

        $total_expense = Products::whereBetween('created_at', [$formDate, $toDate])
            ->sum('total_import');

        $expenseInRange = Products::whereBetween('created_at', [$formDate, $toDate])
            ->get();

        return response()->json([
            "ExpenseInRange" => $expenseInRange,
            "total_expense" => $total_expense,
            'status' => 200
        ]);
    }

}
