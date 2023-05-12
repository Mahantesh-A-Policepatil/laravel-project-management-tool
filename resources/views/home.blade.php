@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <?php
                    $user = Auth::user();
                ?>
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                        @can('isAdmin')                                  
                        <li>
                            <a href="{{ route('usersList') }}" >Users List</a> 
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('projectList') }}" >Projects</a> 
                        </li>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
