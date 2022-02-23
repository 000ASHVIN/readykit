<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Area;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use DataTables;

class AdminAreasController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('admin.areas.index',compact('areas'));
    }

    public function getAreasList()
    {
        $areas = Area::paginate(10);
        return json_encode($areas);
    }

    public function getBranchesForFormList()
    {
        $areas = Area::all();
        return json_encode($areas);
    }

    public function create_view()
    {
        return view('admin.areas.create');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $area = Area::create([
            'name' => $request->name
        ]);
        if(!$area){
            return json_encode(false);
        }
        return json_encode(true);
    }

    public function edit($id)
    {
        $area = Area::find($id);
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:50'
        ]);

        $area = Area::find($id);
        $updated = $area->update([
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
        $area = Area::find($id);

        // if(count($area->houseLot) > 0 || count($area->users) > 0) {
        //     Cookie::queue('not_delete_branch_record_from_table', true, 10);
        //     return redirect()->back();
        // }
        $deleted = $area->delete();
        // if ($deleted) {
        //     Cookie::queue('delete_record_from_table', 'Branch', 10);
        //     return redirect()->back();
        // }
        // Cookie::queue('not_delete_record_from_table', 'Branch', 10);
        Cookie::queue('delete_record_from_table', 'Area', 10);
        return redirect()->back();
    }
    public function getListAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = Area::query();
            // $data = WaterMeterReading::with(['branch', 'house_lot', 'user'])->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                    ->editColumn('created_at', function ($row) {
                            return date('Y/m/d',strtotime($row->created_at));
                    })
                    ->addColumn('action', function($row) {
                        return view('admin.areas.includes.table_buttons', ['id' => $row->id]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->json([false]);
    }
}
