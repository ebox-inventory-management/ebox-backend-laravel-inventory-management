<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class IncomeController extends Controller
{
    public function saveIncome(Request $request){
        $income = new Income();
        $income->income_details = $request->income_details;
        $income->income_amount = $request->income_amount;
        $income->date = date("d");
        $income->month = date("m");
        $income->year = date("Y");
        $income->save();
        return response()->json([
            "message"=>"Income data saved successfully!",'status'=>200,
        ]);
    }

    public function getIncome($id){
        $income = Income::findOrFail($id);
        return response()->json([
            "income"=>$income,'status'=>200
        ]);
    }

    public function updateIncome(Request $request,$income_id){
        $income = Income::findOrFail($income_id);
        $income->income_details = $request->income_details;
        $income->income_amount = $request->income_amount;
        $income->update();
        return response()->json([
            "message"=>"Income data updated successfully!",'status'=>200
        ]);

    }

     public function getIncomes(){
         $income = Income::all();
         return response()->json([
             "Income"=>$income,'status'=>200
         ]);
     }

     public function getTodayIncome(){

         $date = date("09/06/2023");
         $todayIncome = DB::table('incomes')
             ->where('date','=',$date)
             ->get();
         return response()->json([
             "todayIncome"=>$todayIncome,'status'=>200
         ]);
     }

     public function getMonthIncome($month){
         $year = date("Y");
         $monthIncome = DB::table('incomes')
             ->where('month','=',$month)
             ->where('year','=',$year)
             ->get();
         return response()->json([
             "monthIncome"=>$monthIncome,'status'=>200
         ]);
     }

    public function getIncomeInRange($formDate,$toDate){

        $formDate = date_format(date_create($formDate),"d-m-Y");
        $toDate = date_format(date_create($toDate),"d-m-Y");

        $total_income = Income::whereBetween('date', [$formDate, $toDate])
            ->sum('income_amount');

        $incomeInRange = Income::whereBetween('date', [$formDate, $toDate])
            ->get();

        return response()->json([
            "IncomeInRange"=>$incomeInRange,"total_income"=>$total_income,'status'=>200
        ]);
    }

     public function getYearIncome(){
         $year = date("Y");
         $yearIncome = DB::table('incomes')
             ->where('year','=',$year)
             ->get();
         return response()->json([
             "yearIncome"=>$yearIncome,'status'=>200
         ]);
     }

    public function delete($id){
        $income = Income::findOrFail($id);
        $income->delete();
        return response()->json([
            "message"=>"Income data deleted successfully!",'status'=>200
        ]);
    }
}
