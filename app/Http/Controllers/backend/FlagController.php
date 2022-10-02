<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flag;

class FlagController extends Controller
{
    public function index()
    {
        return view('backend.flag.data', [
            'flags' => Flag::all()
        ]);
    }

    public function store(Request $request)
    {
        $code     = 0;
        $err_msg  = "successfully";

        $flag           = new Flag();
        $flag->name     = $request->name;
        
        if (!$flag->save()) {
        
            $code = 1;
            $err_msg = "Some problem";
        
        }

        $return = [
            "code"    => $code,
            "err_msg" => $err_msg,
        ];

        return json_encode($return);
    }
}
