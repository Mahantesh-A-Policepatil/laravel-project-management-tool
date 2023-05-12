<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

// ...

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($taskId)
    {                  
        $activities = Activity::where('task_id',$taskId)->get();
        $activitiesData = $activities->map(function ($item, $key) {
            return [
                "id" => $item->id,
                "task_name" => $item->task->name,
                "hours" => $item->hours,
                "deadline_hours" => $item->deadline_hours,
                "comment" => $item->comment,   
            ];
        }); 
        
        return view('activities.index', compact('activitiesData'));         
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_chart($projectId)
    {                  
        $taksChartData = Activity::
            select(
                'users.name as assigned_user',
                'activities.project_id',
                'activities.task_id',
                'tasks.name as task_name',
                 DB::raw('SUM(activities.hours) as hours') ,
                'activities.deadline_hours'
            )->join('tasks', 'activities.task_id', '=', 'tasks.id')
             ->join('users', 'tasks.assignee', '=', 'users.id')
             ->where('activities.project_id',$projectId)
             ->groupBy("activities.task_id")
             ->get();    
        // echo "<pre>";
        // print_r($taksChartData); exit;         
        $project =  Activity::where('activities.project_id',$projectId)->first();  
        $projectName = $project->project->name;     
        return view('activities.chart', compact('taksChartData', 'projectName'));         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        return view('activities.create', compact('users'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $request->validate([
            'hours'=>'required',
            'comment'=>'string'
        ]);
        $user = Auth::user();
        $project = Task::select('project_id')->where('id', $request['task_id'])->first();
        
        Activity::create([
            'hours' => $request->hours,
            'deadline_hours' => isset($request->deadline_hours) ? $request->deadline_hours : NULL,
            'comment' => $request->comment,
            'task_id' => $request->task_id,
            'created_by' => $user->id,
            'project_id' => $project['project_id'],
        ]);          
        
        return redirect()->route('activities',['task_id'=>$request['task_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = Activity::find($id);
        return view('activities.edit', compact('activity')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hours'=>'required',
            'comment'=>'string'
        ]);
        
        $activity = Activity::find($id);
         
        $activity->hours =  $request->hours;
        $activity->deadline_hours = isset($request->deadline_hours) ? $request->deadline_hours : NULL;
        $activity->comment = isset($request->comment) ? $request->comment : NULL;           
        $activity->update();

        return redirect()->route('activities',['task_id'=>$activity['task_id']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        $activity = Activity::find($request->activity_id);
        $activity->delete();
        
        return redirect()->route('activities',['task_id'=>$activity['task_id']]);        
    }
}
