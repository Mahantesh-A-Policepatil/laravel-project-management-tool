@extends('layouts.app')
@section('content')
<div class="container">
<?php 
  $taskId = request()->route()->parameters['task_id']; 
  $url = url('') . '/' . http_build_query(['task_id' => $taskId]);
  
?>
<div class="row">
  <div class="col-sm-12">
    @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}  
      </div>
    @endif
  </div>
  
<div class="col-sm-12" style="margin-top:50px;">
  <h1 class="display-8">Activities : Log the hours for your task</h1>
  <div alin="left">  <a href="{{ url('activities/create/'.$taskId) }}" class="btn btn-primary">Create Activity</a> </div>    
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <th>SL.No</th>
          <th>Task Name</th>
          <th>Hours</th>
          <th>Comments</th>
          <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activitiesData as $row)
        <tr>         
            <td>{{$loop->index+1}}</td>
            <td>{{$row['task_name']}}</td>
            <td>{{$row['hours']}}</td>
            <td>{{$row['comment']}}</td>
            <td>
              <div>
                  <div style="float:left;margin-left:5px;">
                    <a href="{{ route('activityEdit',$row['id'])}}" class="btn btn-primary">Edit</a>
                  </div>

                  <div style="float:left;margin-left:5px;">
                    <form action="{{ route('deleteActivity', $row['id'])}}" method="post">
                        @csrf
                        <input id="task_id" name="task_id" type="hidden" class="form-control" value="{{ $taskId }}" >
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