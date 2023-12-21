<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // Get chart data
        // Get tasks count group by date
        $task_by_date = Task::query()->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))->groupBy('date')->get();

        // Get total tasks and total done tasks
        $total_tasks = Task::count();
        $total_done_tasks = Task::where('done',1)->count();

        $total_tasks_total_done = [['name'=>'done','total'=>$total_done_tasks],['name'=>'total','total'=>$total_tasks]];
        
        return inertia('Dashboard', compact('task_by_date','total_tasks_total_done'));
    }
}
