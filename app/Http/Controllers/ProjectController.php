<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();
        if($user['user_role'] == "User")
        {
            $projects = Project::where('created_by',$user->id)->get();
        }else{
            $projects = Project::get();
        }
        $results = $projects->map(function ($item, $key) {
            return [
                "id" => $item->id,
                "name" => $item->name,
                "description" => $item->description,
                "created_by" => isset($item->user->name) ? $item->user->name : "",                
            ];
        }); 
        return Datatables::of($results)->setRowId('id')->make(true);
    }

    public function showProjecList()
    {
        return view('projects.index');
    }

    public function assigned_projects()
    {
        $user = Auth::user();
        if($user['user_role'] == "User")
        {
            $projects = Project::where('created_by',$user->id)->with('projectUsers')->get();
        }else{
            $projects = Project::with('projectUsers')->get();
        }
        
        $results= [];
        foreach ($projects as $target) {
            $results[$target->id] = [
                "id" => $target->id,
                "name" => $target->name,
            ];
            foreach($target->projectUsers as $users){
                $results[$target->id]["users"][] = [ "id"=> $users->id, "name"=>$users->name];
            }
        }
        return view('assignedprojects.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('isUser')) {
            abort(403);
        }
        $users = User::get();
        return view('projects.create', compact('users'));
    }
    //assign
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'project_id'=>'string',
        ]);

        $project = Project::find($request->project_id);
        // Project::create([
        //     'name' => $request['name'],
        //     'description' => $request['description'],
        //     'created_by' => $request['created_by'],
        // ]);
        return redirect('/projectList')->with('success', 'Project has been created successfully!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::allows('isUser')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required',
            'description'=>'string',
            'created_by'=>'required',
        ]);

        Project::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'created_by' => $request['created_by'],
        ]);
        
        return redirect('/projectList')->with('success', 'Project has been created successfully!');
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
        if(Gate::allows('isUser')) {
            abort(403);
        }
        $project = Project::find($id);
        $users = User::select('id', 'name')->get();
        return view('projects.edit', compact('project', 'users'));
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
        if(Gate::allows('isUser')) {
            abort(403);
        }
        $request->validate([
            'name'=>'required',
            'description'=>'string',
            'created_by'=>'required',
        ]);

        $project = Project::find($id);
         
        $project->name =  $request->get('name');
        $project->description = $request->get('description');
        $project->created_by = $request->get('created_by');
           
        $project->update();
        return redirect('/projectList')->with('success', 'Project has been updated successfully!');
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
        if(Gate::allows('isUser')) {
            abort(403, "You are not authorized to delete");
        }
        $project = Project::find($request->project_id);
        $project->delete();
        
        echo 'Project has been deleted successfully!';
        
    }
}
