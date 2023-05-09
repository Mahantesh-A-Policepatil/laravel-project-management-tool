@extends('layouts.app')

@section('content')
<div class="container">
<?php $projectId = request()->route()->parameters['project_id']; ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Activity') }}</div>

                <div class="card-body">
                    <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <input id="project_id" name="project_id" type="hidden" class="form-control" value="{{ $projectId }}" >
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="assignee" class="col-md-4 col-form-label text-md-end">{{ __('Assigned To') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='assignee' id='assignee'>
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='status' id='status'>
                                    <option value=""></option>
                                    @foreach($status as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="priority" class="col-md-4 col-form-label text-md-end">{{ __('Priority') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='priority' id='priority'>
                                    <option value=""></option>
                                    @foreach($priority as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="created_by" class="col-md-4 col-form-label text-md-end">{{ __('Created By') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='created_by' id='created_by'>
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>                   

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() { 
		jQuery('#createTaskForm').validate({
		    rules: {
                name: {
		        	required: true,
		            minlength: 5
		        },
                assignee: {
		        	required: true,		            
		        },
                status: {
		        	required: true,
		        },
		        priority: {
		        	required: true,
		        },
		        created_by: {
		        	required: true,
		        }
		    }
		});
	});  
</script> 
@endsection
