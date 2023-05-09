@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
  <div class="col-sm-12">
    @if(session()->get('success'))
      <div class="alert alert-success">
        {{ session()->get('success') }}  
      </div>
    @endif
  </div>
<div class="col-sm-12" style="margin-top:50px;">
  <h1 class="display-8">Users</h1>
  <div alin="left">  <a href="{{ route('users.create')}}" class="btn btn-primary">Add New User</a> </div>    
  <table class="table table-striped" style="margin-top:40px;">
    <thead>
        <tr>
          <td>ID</td>
          <td>User Name</td>
          <td>Email</td>
          <td>User Role</td>
          <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
         
            <td>{{$loop->index+1}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{ucfirst($user->user_role)}}</td>
            <td>
              <div>
                <div style="float:left;">
                  <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                </div>

                <div style="float:left;margin-left:5px;">
                  <form action="{{ route('users.destroy', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
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