<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function index()
    {
        $task = Task::select('*')->addSelect(DB::raw('count(user_id) as count_task, user_id, status'))
                                     ->with('user')
                                     ->where("status","!=","finish")
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

                "count"        => $value->count_task,
                "name"         => $value->user->name,
                "project_name" => $value->user->project_name,
                "class_count"  => $class_count
            
            ];
        }

        $projectList = Task::select('*')->addSelect(DB::raw('count(user_id) as all_task, user_id, status'))
                                        ->with('user')
                                        ->groupBy('user_id')
                                        ->orderBy('all_task','DESC')
                                        ->get();

        $html_project = array();

        foreach ($projectList as $key => $valueproject) {

            $finishedTask = Task::select('*')->where('user_id', $valueproject->user_id)->where('status','finish')->get();

            $html_project[] = [
                
                "name"          => $valueproject->user->name,
                "project_name"  => $valueproject->user->project_name,
                "all_task"      => $valueproject->all_task,
                "finished_task" => count($finishedTask)
            
            ];
        }

        $scoreList = Task::select('*')->addSelect(DB::raw('count(user_id) as count_task, user_id, status'))
                                        ->with('user')
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

        return view('frontend/home', [
            "html_task"       => $html_task,
            "html_project"    => $html_project,
            "html_score_task" => $html_score_task
        ]);
    }
}
