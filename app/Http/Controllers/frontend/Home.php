<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Task;
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

        return view('frontend/home', compact('html'));
    }
}
