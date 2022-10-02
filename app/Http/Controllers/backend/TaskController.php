<?php

namespace App\Http\Controllers\backend;

use App\Events\TaskEvent;
use App\Http\Controllers\Controller;
use App\Models\Flag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return view('backend/task/data',[
            'users' => User::get(),
            'flag' => Flag::get(),
            'task' => Task::with(['user','flag'])->get()
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
        
        // if (!$task->save()) {
        if (!$task->save()) {
        
            $code = 1;
            $err_msg = "Some problem";
        
        }else{

            $task = Task::select('*')->addSelect(DB::raw('count(user_id) as count_task, user_id, status'))
                                 ->with('user')
                                 ->where("status","!=","finish")
                                 ->groupBy('user_id')
                                 ->orderBy('count_task','DESC')
                                 ->get();

            $html = "";
            foreach ($task as $key => $value) {
                $count        = $value->count_task;
                $name         = $value->user->name;
                $project_name = $value->user->project_name;
                
                $html .= "<div class='col-md-3 p-3'>
                            <div class='card'>
                                <div class='card-body'>
                                    <div class='profile-header'>
                                        <div class='row'>
                                            <p class='center nameof'>
                                                $name
                                            </p>
                                            <span class='job-title'>
                                                <b class='bg-green'>$project_name</b>
                                            </span>
                                        </div>
                                    </div>
                                    <div class='count-task'>
                                        $count
                                    </div>
                                </div>
                            </div>
                        </div>";

            }

            $data = [
                'html_task' => $html
            ];
    
            TaskEvent::dispatch($data);
        
        };

        $return = [
            "code"    => $code,
            "err_msg" => $err_msg,
        ];

        return json_encode($return);

    }

    public function get_task($id)
    {
        $data = Task::with(['user','flag'])->where('id', $id)->first();
        return json_encode($data);
    }
}
