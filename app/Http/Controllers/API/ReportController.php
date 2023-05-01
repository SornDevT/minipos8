<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Store;

class ReportController extends Controller
{
    //
    public function created_report(Request $request){

        $month_type = $request->month_type;
        $date = $request->date;

        $m = explode("-",$date)[1];
        $y = explode("-",$date)[0];

        if($month_type == "m"){

            $income = Transection::where("tran_type","income")
            ->whereYear("created_at",$y)
            ->whereMonth("created_at",$m)
            ->get();

            $expense = Transection::where("tran_type","expense")
            ->whereYear("created_at",$y)
            ->whereMonth("created_at",$m)
            ->get();

        } else if($month_type == "y"){

            $income = Transection::where("tran_type","income")
            ->whereYear("created_at",$y)
            ->get();

            $expense = Transection::where("tran_type","expense")
            ->whereYear("created_at",$y)
            ->get();

        }

        $response = [
            "income" => $income,
            "expense" => $expense
        ];

        return response()->json($response);

    }

    public function GetDataDashboard(){

        // ສົ່ງລາຍການຂໍ້ມູນໄປຄຳນວນຢູ່ Font-end
        // $income = Transection::where("tran_type","income")->get();
        // $expense = Transection::where("tran_type","expense")->get();
        // $store = Store::where("amount","!=","0")->get();

        // ຄຳນວນສົ່ງຜົນລັບໄປ
        $income = Transection::where("tran_type","income")->sum("price");
        $expense = Transection::where("tran_type","expense")->sum("price");
        $store = Store::sum("amount");

        $response = [
            "income" => $income,
            "expense" => $expense,
            "store" => $store
        ];

        return response()->json($response);
    }
}
