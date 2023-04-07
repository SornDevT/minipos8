<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

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
        ->paginate(5)
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


            } else {


                $store = new Store(); 
                $store->name = $request->name;
                $store->amount = $request->amount;
                $store->price_buy = $request->price_buy;
                $store->price_sell = $request->price_sell;
                $store->save();

            }

            

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
