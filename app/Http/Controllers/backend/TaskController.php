<?php

namespace App\Http\Controllers\backend;

use App\Events\TaskEvent;
use App\Http\Controllers\Controller;
use App\Models\Flag;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        if (Auth::user()->level == 1) {
            $users = User::get();
            $task  = Task::with(['user','flag'])->whereIn('status',['process','finish','new'])->orderBy('id','desc')->paginate(10);
        }else{
            $users = User::where('id', Auth::user()->id)->get();
            $task  = Task::with(['user','flag'])->where('user_id', Auth::user()->id)->whereIn('status',['process','finish','new'])->orderBy('id','desc')->paginate(10);
        }

        return view('backend/task/data',[
            'users' => $users,
            'flag'  => Flag::get(),
            'task'  => $task
        ]);
    }

    public function store(Request $request)
    {

        $code     = 0;
        $err_msg  = "successfully";
        
        $filename = "no image";

        if (!empty($request->id)) {
            
            if($request->file('image')){

                $file     = $request->file('image');
                $filename = date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('backend/images/task'), $filename);
            
            }else{

                $filename = $request->old_image;

            }

            Task::where('id', $request->id)->update([
                'flag_id'     => $request->flag_id,
                'title'       => $request->title,
                'description' => $request->description,
                'user_id'     => $request->user_id,
                'image'       => $filename,
                'rank'        => $request->rank,
                'type'        => $request->type
            ]);

            $this->sync_task($request->user_id, $request->id);

        }else{

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
    
                $this->sync_task($request->user_id, $task->id);
            
            };
            
        }

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

    public function update_status(Request $request,$id)
    {
        Task::where('id',$id)->update([
            'status' => $request->status
        ]);

        $this->sync_task($request->user_id, $id);
        
        return json_encode('success');
    }

    public function destroy(Task $task)
    {
        $id      = $task->id;
        $user_id = $task->user_id;

        Task::where('id',$id)->update([
            'status' => 'deleted'
        ]);

        // $task->delete();
        $this->sync_task($user_id, $id);
        return json_encode('success');
    }

    public function sync_task($user_id, $id)
    {

        //for flag key
        $flag  = Task::with('flag')->where('id', $id)->first();

        $task = Task::select('*')->addSelect(DB::raw('count(user_id) as count_task, user_id, status'))
                                     ->with(['user','flag'])
                                     ->whereHas('flag', function ($q) use ($flag){
                                        $q->where('key', $flag->flag->key);
                                     })
                                     ->whereIn('status',['process','new'])
                                     ->groupBy('user_id')
                                     ->orderBy('count_task','DESC')
                                     ->get();

        $html_task = array();
        foreach ($task as $key => $value) {

            if($value->count_task >= 11){
                $class_count = "count-task-danger";
            }
            if($value->count_task <= 10){
                $class_count = "count-task-medium";
            }
            if($value->count_task <= 5){
                $class_count = "count-task";
            }

            $html_task[] = [

                "user_id"      => $value->user->id,
                "count"        => $value->count_task,
                "name"         => $value->user->name,
                "project_name" => $value->user->project_name,
                "class_count"  => $class_count,
                "key"          => $flag->flag->key

            
            ];
        }

        $projectList = Task::select('*')->addSelect(DB::raw('count(user_id) as all_task, user_id, status'))
                                        ->with(['user','flag'])
                                        ->whereHas('flag', function ($q) use ($flag){
                                            $q->where('key', $flag->flag->key);
                                         })
                                        ->where('status','!=','deleted')
                                        ->groupBy('user_id')
                                        ->orderBy('all_task','DESC')
                                        ->get();

        $html_project = array();

        foreach ($projectList as $key => $valueproject) {

            $finishedTask = Task::select('*')->where('user_id', $valueproject->user_id)->where('status','finish')->get();

            $html_project[] = [
                
                "user_id"       => $valueproject->user->id,
                "name"          => $valueproject->user->name,
                "project_name"  => $valueproject->user->project_name,
                "all_task"      => $valueproject->all_task,
                "finished_task" => count($finishedTask)
            
            ];
        }

        $scoreList = Task::select('*')->addSelect(DB::raw('count(user_id) as count_task, user_id, status'))
                                        ->with(['user','flag'])
                                        ->whereHas('flag', function ($q) use ($flag){
                                            $q->where('key', $flag->flag->key);
                                         })
                                        ->where('status','finish')
                                        ->whereDate('tasks.created_at', Carbon::today())
                                        ->groupBy('user_id')
                                        ->orderBy('count_task','DESC')
                                        ->limit(2)
                                        ->get();

        $html_score_task = array();

        foreach ($scoreList as $key => $valueproject) {

            $html_score_task[] = [
                
                "name"          => $valueproject->user->name,
                "project_name"  => $valueproject->user->project_name,
                "count_task"    => $valueproject->count_task
            
            ];
        }

        $push_notif = [
            "user_id" => $user_id
        ];

        $data = [
            'html_task'       => $html_task,
            'html_project'    => $html_project,
            'html_score_task' => $html_score_task,
            'push_notif'      => $push_notif
        ];

        TaskEvent::dispatch($data);
    }
}
