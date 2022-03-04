<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use DataTables;

class AdminBranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::with('area')->get();
        // dd($branches);
        return view('admin.branches.index',compact('branches'));
    }

    public function getBranchesList()
    {
        $users = Branch::with('area')->paginate(10);
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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:50',
            'area_id' => 'required|max:50'
        ]);

        $branch = Branch::create([
            'name' => $request->name,
            'area_id' => $request->area_id
        ]);
        if(!$branch){
            return json_encode(false);
        }
        return json_encode(true);
    }

    public function edit($id)
    {
        $branch = Branch::with('area')->find($id);
        // dd($branch);
        return view('admin.branches.Edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|max:50',
            'area_id' => 'required'
        ]);

        $user = Branch::find($id);
        $updated = $user->update([
            'name' => $request->name,
            'area_id' => $request->area_id,
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
    public function getListAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = Branch::select('branch.id', 'branch.name', 'area.name as area', 'branch.created_at')
                ->leftJoin('area', 'branch.area_id', '=', 'area.id');
            // $data = WaterMeterReading::with(['branch', 'house_lot', 'user'])->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                    ->editColumn('created_at', function ($row) {
                            return date('Y/m/d',strtotime($row->created_at));
                    })
                    ->addColumn('action', function($row) {
                        return view('admin.branches.includes.table_buttons', ['id' => $row->id]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->json([false]);
    }
}
