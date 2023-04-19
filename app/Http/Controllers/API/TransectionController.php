<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Store;
use App\Models\Bills;
use App\Models\BillsList;

class TransectionController extends Controller
{
    //

    public function index(Request $request){

        $month_type = $request->month_type;
        $date = $request->date;

        if($date == ''){
            $tran = Transection::orderBy('id','desc')
            ->paginate(10)
            ->toArray();

            return array_reverse($tran);
        } else {

            $m = explode("-",$date)[1];
            $y = explode("-",$date)[0];

            if($month_type == 'm'){

                $tran = Transection::orderBy('id','desc')
                ->whereYear('created_at','=',$y)
                ->whereMonth('created_at','=',$m)
                ->paginate(10)
                ->toArray();
                return array_reverse($tran);
    
                } else if($month_type == 'y'){
    
                $tran = Transection::orderBy('id','desc')
                ->whereYear('created_at','=',$y)
                ->paginate(10)
                ->toArray();
                return array_reverse($tran);
    
                }

        }

    }

    public function add(Request $request){
        try{


            $number_bill = '';
            $bills = Bills::all()->sortByDesc('id')->take(1)->toArray();
            
            foreach($bills as $new){
                $number_bill = $new["bill_id"]; // INC0001
            }
      
            // ຕົວຢ່າງ INC00001
            if($number_bill !=''){
                // $number1 = str_replace("INC","",$number); // 00001
                // $number2 = str_replace("EXP","",$number1);
                $number_bill1 = (int)$number_bill+1; // 1+1 = 2
                $length = 5;
                $number_bill = substr(str_repeat(0,$length).$number_bill1, - $length); //00002
            } else {
                $number_bill = 1;
                $length = 5;
                $number_bill = substr(str_repeat(0,$length).$number_bill, - $length); //00001
            }
            // return $number_bill;

            $bills = new Bills();
            $bills->bill_id = $number_bill;
            $bills->customer_name = $request->customer_name;
            $bills->customer_tel = $request->customer_tel;
            $bills->save();

          // ວົນລູບ ບັນທຶກແຕ່ລະລາຍການ
            foreach($request->listorder as $item){

                $number = '';
                $tran = Transection::all()->sortByDesc('id')->take(1)->toArray();

                foreach($tran as $new){
                    $number = $new["tran_id"]; // INC0001
                }
                // ຕົວຢ່າງ INC00001
                if($number !=''){
                    $number1 = str_replace("INC","",$number); // 00001
                    $number2 = str_replace("EXP","",$number1);
                    $number3 = (int)$number2+1; // 1+1 = 2
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00002
                } else {
                    $number = 1;
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number, - $length); //00001
                }

                // ກວດຊອບປະເພດທຸລະກຳ
                if($request->acc_type == "income") {
                    $tnum = "INC"; //INC
                } elseif($request->acc_type == "expense") {
                    $tnum = "EXP"; // EXP
                }


                $resault = New Transection();
                $resault->tran_id = $tnum.$number; // INC00001, EXP00002
                $resault->product_id = $item['id'];
                $resault->tran_type = $request->acc_type;
                $resault->amount = $item['order_amount'];
                $resault->price = $item['order_amount']*$item['price_sell'];
                $resault->tran_detail = $item['name'];
                $resault->save();

                /// ຕັດສະຕ໋ອກສິນຄ້າ

                $store = Store::find($item['id']);
                
                $store_update = Store::find($item['id']);

                $store_update->update([
                    'amount'=> $store->amount - $item['order_amount'],
                ]);
                

                // ບັນທຶກລາຍການໃບບິນ

                $bl = new BillsList();
                $bl->bill_id = $number_bill;
                $bl->name = $item['name'];
                $bl->amount = $item['order_amount'];
                $bl->price = $item['order_amount']*$item['price_sell'];
                $bl->save();


            }
            

            $success = true;
            $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";


        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
            $number_bill = '';
        }

        $response = [
            "number_bill" => $number_bill,
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);
    }
}
