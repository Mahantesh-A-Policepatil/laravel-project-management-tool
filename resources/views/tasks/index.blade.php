@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<?php 
  $projectId = request()->route()->parameters['project_id']; 
  $url = url('') . '/' . http_build_query(['project_id' => $projectId]);
  //echo "<pre>"; print_r($taskData); exit;
?>

  <div class="col-sm-12">
    @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}  
      </div>
    @endif
  </div>
<div class="col-sm-12" style="margin-top:50px;">
  <h1 class="display-8">Tasks</h1>
  <div alin="left">  <a href="{{ url('tasks/create/'.$projectId) }}" class="btn btn-primary">Add New Task</a> </div>    
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <th>ID</th>
          <th>task Name</th>
          <th>Asignee</th>
          <th>Status</th>
          <th>Priority</th>
          <th>Created By</th>
          <th>Project</th>
          <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taskData as $task)
        <tr>         
            <td>{{$loop->index+1}}</td>
            <td>{{$task['name']}}</td>
            <td>{{$task['assignee']}}</td>
            <td>{{$task['status']}}</td>
            <td>{{$task['priority']}}</td>
            <td>{{$task['created_by']}}</td>
            <td>{{$task['project']}}</td>
            <td>
                <div>
                    <div style="float:left;">
                      <a href="{{ route('activities',$task['id'])}}" class="btn btn-info">Activities</a>
                    </div>
                    
                    <div style="float:left;margin-left:5px;">
                      <a href="{{ route('tasks.edit',$task['id'])}}" class="btn btn-primary">Edit</a>
                    </div>

                    <div style="float:left;margin-left:5px;">
                      <form action="{{ route('deleteTask', $task['id'])}}" method="post">
                          @csrf
                          <input id="project_id" name="project_id" type="hidden" class="form-control" value="{{ $projectId }}" >
                          <button class="btn btn-danger" type="submit">Delete</button>
                      </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
</div>
@endsection