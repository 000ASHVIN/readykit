<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    public function getRoles(){
        return Role::all();
    }

    public function getUser($id){
        return json_encode(User::find($id));
    }

    public function getUsersList(){
        $users = User::paginate(10);
        // dd($users);
        return json_encode($users);
    }
    public function getUsersForFormList(){
        $users = User::all();
        return json_encode($users);
    }

    public function create_view(){
        return view('admin.users.create');
    }
    
    public function create(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'temp_password' => 'required|max:30',
            'status_id' => 'required',
            'branch_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email, 
            'temp_password' => $request->temp_password,
            'password' => Hash::make($request->temp_password),
            'status_id' => $request->status_id,
            'branch_id' => $request->branch_id
        ]);
        

        if(!$user){
            return json_encode(false);
        }
        $role = Role::find($request->role_id);
        $user->assignRole($role);
        return json_encode(true);
    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.users.edit',compact('user'));
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'temp_password' => 'max:30',
            'status_id' => 'required',
            'branch_id' => 'required'
        ]);
        
        $user = User::find($id);
        $updated = $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'temp_password' => (($request->temp_password == '') ? $user->temp_password : $request->temp_password ),
            'status_id' => $request->status_id,
            'branch_id' => $request->branch_id, 
            'updated_at' => Carbon::now()
        ]);

        if($updated){
            return json_encode(true);
        }
        return json_encode(false);

    }

    public function delete($id){
        $deleted = User::find($id)->delete();
        if($deleted){
            Cookie::queue('delete_record_from_table', 'User', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'User', 10);
        return redirect()->back();
    }

}
