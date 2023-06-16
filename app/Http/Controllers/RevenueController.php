<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function getRevenues()
    {
        $Expense = Revenue::sum('revenue');
        return response()->json([
            "Total Expense" =>$Expense,
            "status"=>200,
        ]);
    }


    public function getTodayRevenue()
    {

        $todayExpense = Revenue::whereDate('created_at', today())->sum('revenue');
        return response()->json(['today_expense' => $todayExpense]);
    }

    public function getMonthRevenue()
    {
        $now = Carbon::now();
        $summonthExpense = Revenue::whereMonth('created_at', $now->month)->sum('revenue');
        return response()->json([
            "total"=> $summonthExpense,
            'status' => 200
        ]);
    }


    public function getYearRevenue()
    {
        $now = Carbon::now();
        $sumyearIncome = Revenue::whereYear('created_at', $now->year)->sum('revenue');
        return response()->json([

            "total" => $sumyearIncome,
            'status' => 200
        ]);
    }
    public function getRevenueInRange($formDate, $toDate)
    {

        $formDate = date_format(date_create($formDate), "Y-m-d 0:0:0");
        $toDate = date_format(date_create($toDate), "Y-m-d 0:0:0");

        $total_revenue = Revenue::whereBetween('created_at', [$formDate, $toDate])
            ->sum('revenue');

        $revenueInRange = Revenue::whereBetween('created_at', [$formDate, $toDate])
            ->get();

        return response()->json([
            "ExpenseInRange" => $revenueInRange,
            "total_expense" => $total_revenue,
            'status' => 200
        ]);
    }
}
