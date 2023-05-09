@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New User') }}</div>

                <div class="card-body">
                    <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <select class="form-control select2" name='user_role' id='user_role'>
                                    <option value=""></option>
                                    @foreach($roles as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="confirm_password" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password" >
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
		jQuery('#createUserForm').validate({
		    rules: {
                name: {
		        	required: true,
		            minlength: 5
		        },
                email: {
		        	required: true,
		            email: true
		        },
                user_role: {
		        	required: true,
		        },
		        password: {
		        	required: true,
		            minlength: 5,
		        },
		        confirm_password: {
		        	required: function(element) {
				        return $("#password").val() != '';
			        },
		            minlength: 5,
		            equalTo: "#password"
		        }
		    }
		});
	});  
</script> 
@endsection
