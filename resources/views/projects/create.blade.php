@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Project') }}</div>

                <div class="card-body">
                    <form id="createProjectForm" method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Project Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea rows="3" cols="50" id="description" name="description" class="form-control" ></textarea>
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
		jQuery('#createProjectForm').validate({
		    rules: {
                name: {
                    required: true,
                    minlength: 5
                },
                description: {
                    required: false,
                },
                created_by: {
                    required: true
                }
		    }
		});
	});  
</script> 
@endsection

