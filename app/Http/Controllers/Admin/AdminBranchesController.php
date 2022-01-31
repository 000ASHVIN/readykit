<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Branch;
use Carbon\Carbon;

class AdminBranchesController extends Controller
{
    public function index()
    {
        return view('admin.branches.index');
    }

    public function getBranchesList()
    {
        $users = Branch::all();
        return json_encode($users);
    }

    public function create_view()
    {
        return view('admin.branches.create');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $user = Branch::create([
            'name' => $request->name
        ]);
        if(!$user){
            return json_encode(false);
        }
        return json_encode(true);
    }

    public function edit($id)
    {
        $branch = Branch::find($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $user = Branch::find($id);
        $updated = $user->update([
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ]);

        if ($updated) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function delete($id)
    {
        $deleted = Branch::find($id)->delete();
        if ($deleted) {
            return json_encode(true);
        }
        return json_encode(false);
    }
}
