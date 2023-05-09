<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Http\Request;

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
                "comment" => $item->comment,   
            ];
        }); 
        
        return view('activities.index', compact('activitiesData'));         
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
            'hours' => $request['hours'],
            'comment' => $request['comment'],
            'task_id' => $request['task_id'],
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
         
        $activity->hours =  $request->get('hours');
        $activity->comment = $request->get('comment');           
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
