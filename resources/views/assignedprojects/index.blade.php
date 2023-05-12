@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<?php 
//   $projectId = request()->route()->parameters['project_id']; 
//   $url = url('') . '/' . http_build_query(['project_id' => $projectId]);
//  echo "<pre>"; print_r($results); exit;
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
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <th>ID</th>
          <th>Project Name</th>
          <th>Project Team Members</th>
          <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
        <tr>         
            <td>{{$loop->index+1}}</td>
            <td>{{$result['name']}}</td>
            
               @foreach($result as $row)
               <td><?php  print_r($row);   ?></td>
               @endforeach
            
           
            
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
</div>
@endsection