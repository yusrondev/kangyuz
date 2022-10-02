<?php

namespace App\Http\Controllers\backend;

use App\Events\TaskEvent;
use App\Http\Controllers\Controller;
use App\Models\Flag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('backend/task/data',[
            'users' => User::get() ,
            'flag' => Flag::get() 
        ]);
    }

    public function store(Request $request)
    {

        $code     = 0;
        $err_msg  = "successfully";
        
        $filename = "no image";
        
        if($request->file('image')){
            $file     = $request->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('backend/images/task'), $filename);
        }

        $task              = new Task();
        $task->flag_id     = $request->flag_id;
        $task->title       = $request->title;
        $task->description = $request->description;
        $task->user_id     = $request->user_id;
        $task->image       = $filename;
        $task->rank        = $request->rank;
        $task->type        = $request->type;
        
        if (!$task->save()) {
        
            $code = 1;
            $err_msg = "Some problem";
        
        }else{

            $data = [
                'user_id'     => $request->user_id,
                'description' => $request->description,
            ];
    
            TaskEvent::dispatch($data);
        
        };

        $return = [
            "code"    => $code,
            "err_msg" => $err_msg,
        ];

        return json_encode($return);

    }
}
