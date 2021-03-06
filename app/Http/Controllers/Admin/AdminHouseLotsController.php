<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\HouseLot;
use App\Models\Admin\WaterMeterReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use DataTables;
use Illuminate\Support\Facades\DB;

class AdminHouseLotsController extends Controller
{
    public function index()
    {
        $houselots = HouseLot::all();
        return view('admin.house_lots.index',compact('houselots'));
    }

    public function getHouseLotsList()
    {
        $houselots = HouseLot::paginate(10);
        return json_encode($houselots);
    }

    public function create_view()
    {
        return view('admin.house_lots.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial_no' => 'required|max:50|unique:house_lot,serial_num',
            'house_lot_no' => 'required|max:50',
            'branch' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->get('serial_no')) {
                Cookie::queue('error_for_create_reading_field', 'Serial no', 10);
                Cookie::queue('error_for_create_reading', $errors->get('serial_no')[0], 10);
            }
            if ($errors->get('house_lot_no')) {
                Cookie::queue('error_for_create_reading_field', 'House lot no', 10);
                Cookie::queue('error_for_create_reading', $errors->get('house_lot_no')[0], 10);
            }
            if ($errors->get('branch')) {
                Cookie::queue('error_for_create_reading_field', 'Branch', 10);
                Cookie::queue('error_for_create_reading', $errors->get('branch')[0], 10);
            }
            return json_encode('error');
        }

        $branch_ids = [];
        $branch = json_decode($request->branch);
        foreach($branch as $data) {
            $branch_ids[] = $data->value;
        }

        $houselot = HouseLot::create([
            'serial_num' => $request->serial_no,
            'house_lot_num' => $request->house_lot_no
        ]);

        $houselot->branch()->sync($branch_ids);

        if (!$houselot) {
            return json_encode(false);
        }
        return json_encode(true);
    }

    public function edit($id)
    {
        $houselot = HouseLot::with('branch')->find($id);
        return view('admin.house_lots.edit', compact('houselot'));
    }

    public function update(Request $request, $id)
    {
        // $validated = $request->validate([
        //     'serial_no' => 'required|max:50',
        //     'house_lot_no' => 'required|unique:branch,house_lot_no|max:50'
        // ]);
        
        $validator = Validator::make($request->all(), [
            'serial_no' => 'required|max:50',
            'house_lot_no' => 'required|max:50',
            'branch' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->get('serial_no')) {
                Cookie::queue('error_for_create_reading_field', 'Serial no', 10);
                Cookie::queue('error_for_create_reading', $errors->get('serial_no')[0], 10);
            }
            if ($errors->get('house_lot_no')) {
                Cookie::queue('error_for_create_reading_field', 'House lot no', 10);
                Cookie::queue('error_for_create_reading', $errors->get('house_lot_no')[0], 10);
            }
            if ($errors->get('branch')) {
                Cookie::queue('error_for_create_reading_field', 'Branch', 10);
                Cookie::queue('error_for_create_reading', $errors->get('branch')[0], 10);
            }
            return json_encode('error');
        }

        $checkForUnique = HouseLot::where('id', '!=', $id)->where('serial_num', $request->serial_no)->first();
        if($checkForUnique) {
            $message = "This Serial Number Has already been taken, Please use another one.";
            Cookie::queue('error_for_create_reading_field', 'Serial no', 10);
            Cookie::queue('error_for_create_reading', $message, 10);

            return json_encode('error');
        }

        $houselot = HouseLot::find($id);
        $branch_ids = [];
        $branch = json_decode($request->branch);
        foreach($branch as $data) {
            $branch_ids[] = $data->value;
        }
        $houselot->branch()->sync($branch_ids);
        
        $updated = $houselot->update([
            'serial_num' => $request->serial_no,
            'house_lot_num' => $request->house_lot_no,
            'updated_at' => Carbon::now()
        ]);

        $update_reading = WaterMeterReading::where('house_lot_id', $houselot->id)->update([
            'serial_num' => $request->serial_no
        ]);
        
        if ($updated) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function delete($id)
    {
        $houseLot = HouseLot::find($id);
        if(count($houseLot->water_readings) > 0) {
            Cookie::queue('not_delete_houselot_record_from_table', true, 10);
            return redirect()->back();
        }
        $deleted = $houseLot->delete();
        if ($deleted) {
            Cookie::queue('delete_record_from_table', 'House Lot', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'House Lot', 10);
        return redirect()->back();
    }

    public function getListAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = HouseLot::select(
                'house_lot.id',
                'house_lot.house_lot_num',
                'house_lot.serial_num',
                'house_lot.created_at',
                DB::raw('(SELECT GROUP_CONCAT(name) FROM `branch` WHERE id IN ( SELECT branch_id from branch_house_lot WHERE house_lot_id = house_lot.id )) as branch')
            )->get();
            
            return DataTables::of($data)
                    ->editColumn('created_at', function ($row) {
                            return date('Y/m/d',strtotime($row->created_at));
                    })
                    // ->addColumn('branch', function($row) {
                    //     $branches = $row->branch->pluck('name')->toArray();
                    //     return implode(", ", $branches);
                    // })
                    ->addColumn('action', function($row) {
                        return view('admin.house_lots.includes.table_buttons', ['id' => $row->id]);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->json([false]);
    }
}
