<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\HouseLot;
use App\Models\Admin\WaterMeterReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WaterTankReadingsController extends Controller
{
    public function create_view(){
        $user = auth()->user();
        $branch = Branch::find($user->branch_id);
        return view('user-side.water_tank_reading.create',compact('user', 'branch'));
    }

    public function showReading($id){
        $water_reading = WaterMeterReading::find($id);
        $branch = Branch::find($water_reading->branch_id);
        $house_lot = HouseLot::find($water_reading->house_lot_id);
        return view('user-side.water_tank_reading.show',compact('water_reading', 'branch', 'house_lot'));
    }

    public function editReading($id){
        $water_reading = WaterMeterReading::with(['branch', 'house_lot', 'user'])->where('id', $id)->first();
        return view('user-side.water_tank_reading.edit',compact('water_reading'));
    }

    public function create(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpg,jpeg,png',
            'current_reading' => 'required|max:50',
            'serial_num' => 'required',
            'house_lot_id' => 'required|exists:house_lot,id',
            'branch_id' => 'required|exists:branch,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if($errors->get('branch_id')){
                Cookie::queue('error_for_create_reading_field', 'Branch', 10);
                Cookie::queue('error_for_create_reading', $errors->get('branch_id')[0], 10);
            }
            if ($errors->get('current_reading')) {
                Cookie::queue('error_for_create_reading_field', 'Current Reading', 10);
                Cookie::queue('error_for_create_reading', $errors->get('current_reading')[0], 10);
            }
            if ($errors->get('house_lot_id')) {
                Cookie::queue('error_for_create_reading_field', 'House Lot', 10);
                Cookie::queue('error_for_create_reading', $errors->get('house_lot_id')[0], 10);
            }
            if ($errors->get('serial_num')) {
                Cookie::queue('error_for_create_reading_field', 'Serial No', 10);
                Cookie::queue('error_for_create_reading', $errors->get('serial_num')[0], 10);
            }
            if ($errors->get('image')) {
                Cookie::queue('error_for_create_reading_field', 'Reading Image', 10);
                Cookie::queue('error_for_create_reading', $errors->get('image')[0], 10);
            }
            return redirect()->route('create.reading');
        } 

        if($last_reading = WaterMeterReading::where('house_lot_id',$request->house_lot_id)->latest()->first()){
            $request->merge(['last_reading' => $last_reading->current_reading]);
        }
        
        $destination_path = 'public/images/meter_readings/';
        $image = $request->file('image');
        $image_name = "reading_" . Carbon::now()->format('YmdHs') . "." . $image->getClientOriginalExtension();
        $img = Image::make($image->path());
        $img->resize(350, 350, function ($constraint) {
            $constraint->aspectRatio();
        });
        // $img->resize(350, 350);
        $img->stream();
        // ->save(storage_path($destination_path . $image_name) );
        Storage::put($destination_path . $image_name, $img);
        $request->merge(['image_name' => $image_name]);

        $water_reading = WaterMeterReading::create([
            'user_id' => auth()->user()->id,
            'house_lot_id' => $request->house_lot_id,
            'branch_id' => $request->branch_id,
            'serial_num' => $request->serial_num,
            'current_reading' => $request->current_reading,
            'last_reading' => $request->last_reading ? $request->last_reading : null ,
            'image' => $request->image_name
        ]);

        Cookie::queue('reading_created', true, 10);

        return redirect()->route('show-reading', $water_reading);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image:jpg,jpeg,png',
            'current_reading' => 'required|max:50',
            'serial_num' => 'required',
            'house_lot_id' => 'required|exists:house_lot,id',
            'branch_id' => 'required|exists:branch,id',
            'remark' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->get('branch_id')) {
                Cookie::queue('error_for_create_reading_field', 'Branch', 10);
                Cookie::queue('error_for_create_reading', $errors->get('branch_id')[0], 10);
            }
            if ($errors->get('current_reading')) {
                Cookie::queue('error_for_create_reading_field', 'Current Reading', 10);
                Cookie::queue('error_for_create_reading', $errors->get('current_reading')[0], 10);
            }
            if ($errors->get('house_lot_id')) {
                Cookie::queue('error_for_create_reading_field', 'House Lot', 10);
                Cookie::queue('error_for_create_reading', $errors->get('house_lot_id')[0], 10);
            }
            if ($errors->get('serial_num')) {
                Cookie::queue('error_for_create_reading_field', 'Serial No', 10);
                Cookie::queue('error_for_create_reading', $errors->get('serial_num')[0], 10);
            }
            if ($errors->get('image')) {
                Cookie::queue('error_for_create_reading_field', 'Reading Image', 10);
                Cookie::queue('error_for_create_reading', $errors->get('image')[0], 10);
            }
            if ($errors->get('remark')) {
                Cookie::queue('error_for_create_reading_field', 'Remark', 10);
                Cookie::queue('error_for_create_reading', $errors->get('remark')[0], 10);
            }
            return redirect()->route('edit-reading',$id);
        }

        $old = WaterMeterReading::find($id);

        if ($request->image) {
            $destination_path = 'public/images/meter_readings';
            $image = $request->file('image');
            $image_name = "reading_" . Carbon::now()->format('YmdHs') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs($destination_path, $image_name);
            if (File::exists(public_path("storage\images\meter_readings\\" . $old->image))) {
                File::delete(public_path("storage\images\meter_readings\\" . $old->image));
            }
            $updated = WaterMeterReading::find($id)->update([
                'house_lot_id' => $request->house_lot_id,
                'branch_id' => $request->branch_id,
                'serial_num' => $request->serial_num,
                'current_reading' => $request->current_reading,
                'image' => $image_name,
                'remark' => $request->remark,
                'updated_at' => Carbon::now()
            ]);
        } else {
            $updated = WaterMeterReading::find($id)->update([
                'house_lot_id' => $request->house_lot_id,
                'branch_id' => $request->branch_id,
                'serial_num' => $request->serial_num,
                'current_reading' => $request->current_reading,
                'remark' => $request->remark,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($updated) {
            Cookie::queue('reading_updated', true, 10);
            return redirect()->route('user.water-tank.reading');
        }
        Cookie::queue('reading_not_updated', true, 10);
        return redirect()->back();
    }
}
