@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Project') }}</div>

                <div class="card-body">
                    <form id="assignProjectForm" method="POST" action="{{ route('projects.assign') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="created_by" class="col-md-4 col-form-label text-md-end">{{ __('Created By') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='user_id' id='user_id'>
                                    <option value=""></option>
                                    @foreach($users as $user)
                                          <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="created_by" class="col-md-4 col-form-label text-md-end">{{ __('Created By') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='project_id' id='project_id'>
                                    <option value=""></option>
                                    @foreach($projects as $project)
                                          <option value="{{$project->id}}">{{$project->name}}</option>
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
		jQuery('#assignProjectForm').validate({
		    rules: {
                user_id: {
                    required: true,
                },
                project_id: {
                    required: true,
                }
		    }
		});
	});  
</script> 
@endsection

