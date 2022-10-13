<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flag;

class FlagController extends Controller
{
    public function index()
    {
        return view('backend.flag.data');
    }

    public function show()
    {
        return json_encode(Flag::withCount('task')->latest()->get());
    }

    public function store(Request $request)
    {
        $code     = 0;
        $err_msg  = "successfully";

        $flag           = new Flag();
        $flag->name     = $request->name;
        $flag->key      = strtolower(str_replace(" ", "_", $request->name));
        
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

    public function update(Request $request)
    {
        $code     = 0;
        $err_msg  = "successfully";

        $flag           = Flag::find($request->id);
        $flag->name     = $request->name;
        $flag->key      = str_replace(" ", "_", $request->name);
        
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

    public function destroy(Flag $flag)
    {
        $code     = 0;
        $err_msg  = "successfully";
        
        if (!$flag->delete()) {
        
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
