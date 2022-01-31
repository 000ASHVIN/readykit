<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\WaterMeterReading;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaterTankReadingsController extends Controller
{
    public function create_view(){
        $user = auth()->user();
        $branch = Branch::find($user->branch_id);
        return view('user-side.water_tank_reading.create',compact('user', 'branch'));
    }

    public function create(Request $request){
        
        $validated = $request->validate([
            'image' => 'required|image:jpg,jpeg,png',
            'current_reading' => 'required|max:50',
            'serial_num' => 'required',
            'house_lot_id' => 'required|exists:house_lot,id',
            'branch_id' => 'required|exists:branch,id'
        ]);
        if($last_reading = WaterMeterReading::where('house_lot_id',$request->house_lot_id)->latest()->first()){
            $request->merge(['last_reading' => $last_reading->last_reading]);
        }

        $destination_path = 'public/images/meter_readings';
        $image = $request->file('image');
        $image_name = "reading_".Carbon::now()->format('YmdHs').".". $image->getClientOriginalExtension();
        $path = $image->storeAs($destination_path,$image_name);
        $request->merge(['image_name' => $image_name]);

        WaterMeterReading::create([
            'user_id' => auth()->user()->id,
            'house_lot_id' => $request->house_lot_id,
            'branch_id' => $request->branch_id,
            'serial_num' => $request->serial_num,
            'current_reading' => $request->current_reading,
            'last_reading' => $request->last_reading ? $request->last_reading : null ,
            'image' => $request->image_name
        ]);

        return redirect()->route('user.water-tank.reading');
    }
}
