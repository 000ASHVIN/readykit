<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class AdminBranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('admin.branches.index',compact('branches'));
    }

    public function getBranchesList()
    {
        $users = Branch::paginate(10);
        return json_encode($users);
    }

    public function getBranchesForFormList()
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

        $branch = Branch::create([
            'name' => $request->name
        ]);
        if(!$branch){
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
        $branch = Branch::find($id);

        if(count($branch->houseLot) > 0 || count($branch->users) > 0) {
            Cookie::queue('not_delete_branch_record_from_table', true, 10);
            return redirect()->back();
        }
        $deleted = $branch->delete();
        if ($deleted) {
            Cookie::queue('delete_record_from_table', 'Branch', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'Branch', 10);
        return redirect()->back();
    }
}
