<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Transection;

class StoreController extends Controller
{
    //

    public function index(){

        $search = \Request::get('s');

        // $store = Store::orderBy('id','desc')
        // ->where('name','LIKE',"%{$search}%")
        // ->get();

        // return $store;


        $store = Store::orderBy('id','desc')
        ->where('name','LIKE',"%{$search}%")
        ->paginate(15)
        ->toArray();

        return array_reverse($store);
    }

    public function add(Request $request){

        try{

            //return $request;

            if($request->file('file')){

                $upload_path = "assets/img";
                $generate_new_name = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path($upload_path),$generate_new_name);


                $store = new Store(); 
                $store->name = $request->name;
                $store->image = $generate_new_name;
                $store->amount = $request->amount;
                $store->price_buy = $request->price_buy;
                $store->price_sell = $request->price_sell;
                $store->save();

                $product_id = $store->id;


            } else {


                $store = new Store(); 
                $store->name = $request->name;
                $store->amount = $request->amount;
                $store->price_buy = $request->price_buy;
                $store->price_sell = $request->price_sell;
                $store->save();

                $product_id = $store->id;

            }


            /// ບັນທຶກລາຍຈ່າຍສັ່ງຊື້ສິນຄ້າ

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
            $resault->product_id = $product_id;
            $resault->tran_type = $request->acc_type;
            $resault->amount = $request->amount;
            $resault->price = $request->amount*$request->price_buy;
            $resault->tran_detail = 'ສັ່ງຊື້ສິນຄ້າ '.$request->name;
            $resault->save();

            

            $success = true;
            $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";


        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);

    }

    public function edit($id){

        $store = Store::find($id);
        return $store;

    }

    public function update($id, Request $request){

        try{

            $store = Store::find($id);
            $upload_path = "assets/img";
            // ກວດຊອບວົ່າຮູບໄດ້ອັບໂຫຼດມາຫຼືບໍ່
            if($request->file('file')){

                // ລຶບຮູບພາບເກົ່າ
                if($store->image){
                    if(file_exists($upload_path.'/'.$store->image)){
                        unlink($upload_path.'/'.$store->image);
                    }
                }

                $generate_new_name = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path($upload_path),$generate_new_name);

                $store->update([
                    'name'=> $request->name,
                    'image'=> $generate_new_name,
                    'amount'=> $request->amount,
                    'price_buy'=> $request->price_buy,
                    'price_sell'=> $request->price_sell,
                ]);

            } else {

                if($request->file){

                    $store->update([
                        'name'=> $request->name,
                        // 'image'=> $generate_new_name,
                        'amount'=> $request->amount,
                        'price_buy'=> $request->price_buy,
                        'price_sell'=> $request->price_sell,
                    ]);

                } else {

                    // ລຶບຮູບພາບເກົ່າ
                    if($store->image){
                        if(file_exists($upload_path.'/'.$store->image)){
                            unlink($upload_path.'/'.$store->image);
                        }
                    }
                    /// ອັບເດດຂໍ້ມູນ
                    $store->update([
                        'name'=> $request->name,
                        'image'=> '',
                        'amount'=> $request->amount,
                        'price_buy'=> $request->price_buy,
                        'price_sell'=> $request->price_sell,
                    ]);



                }

            }

            $store->update([
                'name'=> $request->name,
                'amount'=> $request->amount,
                'price_buy'=> $request->price_buy,
                'price_sell'=> $request->price_sell,
            ]);

            $success = true;
            $message = "ອັບເດດຂໍ້ມູນສຳເລັດ!";


        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);

    }

    public function detele($id){


        try{

            $store = Store::find($id);
            $store->delete();

            $success = true;
            $message = "ລຶບຂໍ້ມູນສຳເລັດ!";


        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);

    }
}
