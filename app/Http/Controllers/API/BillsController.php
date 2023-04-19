<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bills;
use App\Models\BillsList;

class BillsController extends Controller
{
    //

    public function print($id){
        $bills = Bills::where('bill_id',$id)->get();
        $billslist = BillsList::where('bill_id',$id)->get();

        return view('print_bill')->with('bills',$bills)->with('billslist',$billslist);
    }
}
