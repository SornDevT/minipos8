<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

use App\Models\User;

class UserController extends Controller
{
    //
    public function register(Request $request){
        try{

            $check_email = User::where('email',$request->email);

            if($check_email->count()){
                $success = false;
                $message = "ອີເມວລ໌ນິ້: ".$request->email." ໄດ້ເຄີຍລົງທະບຽນແລ້ວ!";
            } else {

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = hash::make($request->password);
                $user->save();

                $success = true;
                $message = "ລົງທະບຽນສຳເລັດ!";

            }
    
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

    public function login(Request $request){

        try{

            $check_user_login = [
                "email"=> $request->email,
                "password"=>$request->password
            ];

            if(Auth::attempt($check_user_login)){

                $success = true;
                $message = "ເຂົ້າສູ່ລະບົບສຳເລັດ!";

            } else {

                $success = false;
                $message = "ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານ ຂອງທ່ານບໍ່ຖຶກຕ້ອງ!";

            }

          
    
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

    public function logout(){
        Session::flush();
        $response = [
            "success" => true,
            "message" => 'ສຳເລັດ'
        ];
        return response()->json($response);
    }
}
