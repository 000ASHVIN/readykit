<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use DataTables;

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
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'temp_password' => (($request->temp_password == '') ? $user->temp_password : $request->temp_password ),
            'status_id' => $request->status_id,
            'branch_id' => $request->branch_id, 
            'updated_at' => Carbon::now()
        ];

        if($request->temp_password && $request->temp_password != '') {
            $data['password'] = Hash::make($request->temp_password);
        }

        $updated = $user->update($data);

        if($updated){
            return json_encode(true);
        }
        return json_encode(false);

    }

    public function delete($id){
        $deleted = User::with('water_readings')->find($id);
        if(count($deleted->water_readings) > 0){
            Cookie::queue('not_delete_user_record_from_table', true, 10);
            return redirect()->back();
        }
        $delete = $deleted->delete();
        if($delete){
            Cookie::queue('delete_record_from_table', 'User', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'User', 10);
        return redirect()->back();
    }

    public function getListAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('users.id', 'users.email', 'users.first_name', 'users.last_name', 'users.status_id as status', 'branch.name as branch', 'users.created_at')
                        ->leftJoin('branch', 'users.branch_id', '=', 'branch.id');
            // $data = WaterMeterReading::with(['branch', 'house_lot', 'user'])->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                    ->editColumn('first_name', function ($row) {
                        return $row->first_name. " ". $row->last_name;
                    })
                    ->editColumn('status', function ($row) {
                        return $row->status == 1 ? 'Active': 'Inactive';
                    })
                    // ->editColumn('created_at', function ($row) {
                    //         return date('Y/m/d', strtotime($row->created_at));
                    // })
                    ->addColumn('action', function($row) {
                        return view('admin.users.includes.table_buttons', ['id' => $row->id]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->json([false]);
    }
}
