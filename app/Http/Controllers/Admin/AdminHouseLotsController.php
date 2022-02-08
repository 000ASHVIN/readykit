<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\HouseLot;
use App\Models\Admin\WaterMeterReading;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminHouseLotsController extends Controller
{
    public function index()
    {
        return view('admin.house_lots.index');
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
        $validated = $request->validate([
            'serial_no' => 'required|max:50',
            'house_lot_no' => 'required|max:50',
        ]);

        $houselot = HouseLot::create([
            'serial_num' => $request->serial_no,
            'house_lot_num' => $request->house_lot_no,
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
        $validated = $request->validate([
            'serial_no' => 'required|max:50',
            'house_lot_no' => 'required|max:50'
        ]);

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
            return json_encode(true);
        }
        return json_encode(false);
    }
}
