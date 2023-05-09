<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        $user = Auth::user();
        if($user['user_role'] == "User")
        {
            $tasks = Task::where('assignee',Auth::id())->where('project_id',$projectId)->get();
        }else{
            $tasks = Task::where('project_id',$projectId)->get();
        } 
        //dd($tasks);
        $taskData = $tasks->map(function ($item, $key) {
            return [
                "id" => $item->id,
                "name" => $item->name,
                "assignee" => isset($item->assigned_user->name) ? $item->assigned_user->name : "",
                "status" => $item->status,
                "priority" => $item->priority,
                "created_by" => isset($item->reporter->name) ? $item->reporter->name : "",    
                "project" =>  isset($item->project->name) ? $item->project->name : "",    
                "hours" =>  isset($item->taskActivity) ? $item->taskActivity->sum('hours') : "",         
            ];
        }); 
        return view('tasks.index', compact('taskData'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        $status = ["new" => "New", "in_progress" => "In Progress", "resolved" => "Resolved", "closed" => "Closed"];
        $priority = ["normal" => "Normal", "low" => "Low", "high" => "High", "urgent" => "Urgent"];
        return view('tasks.create', compact('users', 'status', 'priority'));
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
            'name'=>'required',
            'assignee'=>'required',
            'status'=>'required',
            'priority'=>'required',
            'created_by'=>'required',
            'project_id'=>'required'
        ]);

        Task::create([
            'name' => $request['name'],
            'assignee' => $request['assignee'],
            'status' => $request['status'],
            'priority' => $request['priority'],
            'created_by' => $request['created_by'],
            'project_id' => $request['project_id']
        ]);         
        return redirect()->route('projectTaskList',['project_id'=>$request['project_id']]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_task_data()
    {
        return view('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($taskId)
    {
        $task = Task::find($taskId);
        $projectId = $task->project_id;
        $users = User::select('id', 'name')->get();
        $status = ["new" => "New", "in_progress" => "In Progress", "resolved" => "Resolved", "closed" => "Closed"];
        $priority = ["normal" => "Normal", "low" => "Low", "high" => "High", "urgent" => "Urgent"];
        return view('tasks.edit', compact('task','users', 'status', 'priority', 'projectId'));
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
        //
        $request->validate([
            'name'=>'required',
            'assignee'=>'required',
            'status'=>'required',
            'priority'=>'required',
            'created_by'=>'required',
            'project_id'=>'required'
        ]);

        $task = Task::find($id);
         
        $task->name =  $request->get('name');
        $task->assignee = $request->get('assignee');
        $task->status = $request->get('status');
        $task->priority = $request->get('priority');
        $task->created_by = $request->get('created_by');
        $task->project_id = $request->get('project_id');
        
        $task->update();
             
        return redirect()->route('projectTaskList',['project_id'=>$request->get('project_id')]);
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
        $task = Task::find($request->task_id);
        $task->delete();
        
        return redirect()->route('projectTaskList',['project_id'=>$request->get('project_id')]);
        
    }
}
