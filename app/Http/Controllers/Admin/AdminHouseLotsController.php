<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HouseLot;
use App\Models\Admin\WaterMeterReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
            'serial_no' => 'required|max:50',
            'house_lot_no' => 'required|unique:house_lot,house_lot_num|max:50',
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

        $houselot = HouseLot::create([
            'serial_num' => $request->serial_no,
            'house_lot_num' => $request->house_lot_no,
            'branch_id' => $request->branch
        ]);
        if (!$houselot) {
            return json_encode(false);
        }
        return json_encode(true);
    }

    public function edit($id)
    {
        $houselot = HouseLot::find($id);
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
            'house_lot_no' => 'required|max:50|unique:house_lot,house_lot_num,'.$id
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
            return json_encode('error');
        }

        $houselot = HouseLot::find($id);
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
        $deleted = HouseLot::find($id)->delete();
        if ($deleted) {
            Cookie::queue('delete_record_from_table', 'House Lot', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'House Lot', 10);
        return redirect()->back();
    }
}
