@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Task') }}</div>

                <div class="card-body">
                    <form id="updateActivityForm" method="post" action="{{ route('activities.update', $activity->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="row mb-3">
                            <label for="hours" class="col-md-4 col-form-label text-md-end">{{ __('Hours') }}</label>
                            <div class="col-md-6">
                                <input id="hours" type="text" class="form-control" name="hours" value="{{$activity->hours}}">
                            </div>
                        </div>
                        @cannot('isUser')
                        <div class="row mb-3">
                            <label for="deadline_hours" class="col-md-4 col-form-label text-md-end">{{ __('Deadline Hours') }}</label>
                            <div class="col-md-6">
                                <input id="deadline_hours" type="text" class="form-control" name="deadline_hours" value="{{$activity->deadline_hours}}">
                            </div>
                        </div>
                        @endcannot
                        <div class="row mb-3">
                            <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}</label>
                            <div class="col-md-6">
                                <textarea rows="3" cols="50" id="comment" name="comment" class="form-control" >{{$activity->comment}}</textarea>
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
		jQuery('#updateActivityForm').validate({
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

