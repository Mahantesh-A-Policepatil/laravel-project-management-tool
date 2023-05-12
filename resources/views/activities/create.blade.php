@extends('layouts.app')

@section('content')
<div class="container">
<?php $taskId = request()->route()->parameters['task_id']; ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Activity') }}</div>

                <div class="card-body">
                    <form id="createActivityForm" method="POST" action="{{ route('activities.store') }}">
                        @csrf
                        <input id="task_id" name="task_id" type="hidden" class="form-control" value="{{ $taskId }}" >
                        <div class="row mb-3">
                            <label for="hours" class="col-md-4 col-form-label text-md-end">{{ __('Hour') }}</label>
                            <div class="col-md-6">
                                <input id="hours" type="text" class="form-control" name="hours">
                            </div>
                        </div>
                        @cannot('isUser')
                        <div class="row mb-3">
                            <label for="deadline_hours" class="col-md-4 col-form-label text-md-end">{{ __('Hour') }}</label>
                            <div class="col-md-6">
                                <input id="deadline_hours" type="text" class="form-control" name="deadline_hours">
                            </div>
                        </div>
                        @endcannot
                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}</label>
                            <div class="col-md-6">
                                <textarea rows="3" cols="50" id="comment" name="comment" class="form-control" ></textarea>
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
		jQuery('#createActivityForm').validate({
		    rules: {
                hours: {
		        	required: true,
                    digits: true
		        },
                comment: {
		        	required: false,		            
		        }
		    }
		});
	});  
</script> 
@endsection
