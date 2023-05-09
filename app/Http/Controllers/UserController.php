<?php

namespace App\Http\Controllers;

use Datatables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_new()
    {
        $users = User::get();
        return Datatables::of($users)->setRowId('id')->make(true);
    }

    public function show_data()
    {
        return view('users.user-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = ["admin" => "Admin", "user" => "User", "manager" => "Manager"];
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'user_role'=>'required',
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_role' => $request['user_role'],
        ]);
        return redirect('/usersList')->with('success', 'User has been created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = ["admin" => "Admin", "user" => "User", "manager" => "Manager"];
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'user_role'=>'required',
        ]);

        $user = User::find($id);
         
        $user->name =  $request->get('name');
        $user->email = $request->get('email');
        $user->user_role = $request->get('user_role');
           
        $user->update();
        return redirect('/usersList')->with('success', 'User has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User has been Deleted Successfully!');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();
        
        echo 'User has been deleted successfully!';
        
    }
}
