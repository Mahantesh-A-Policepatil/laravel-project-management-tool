#Laravel Project Managment Tool
 - php artisan make:migration create_role_user_table
 - php artisan make:migration create_project_user_table
# Gates
```
--------------------------------------------------------
/app/Providers/AuthServiceProvider.php
--------------------------------------------------------
public function boot()
{
    $this->registerPolicies();

    //
    Gate::define('isAdmin', function($user) {
        return $user->user_role == 'Admin';
     });
    
     /* define a manager user role */
     Gate::define('isManager', function($user) {
         return $user->user_role == 'Manager';
     });
   
     /* define a user role */
     Gate::define('isUser', function($user) {
         return $user->user_role == 'User';
     });
}

--------------------------------------------------------
Controller
--------------------------------------------------------
use Illuminate\Support\Facades\Gate;


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    if(Gate::allows('isUser')) {
        abort(403);
    }
    $users = User::get();
    return view('projects.create', compact('users'));
}
--------------------------------------------------------
Blade
--------------------------------------------------------
@can('isAdmin')                                  
	<li>
	    <a href="{{ route('usersList') }}" >Users List</a> 
	</li>
@endcan
--------------------------------------------------------
```
   
