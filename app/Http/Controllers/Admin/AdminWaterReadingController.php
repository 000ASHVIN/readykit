<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\HouseLot;
use App\Models\Admin\WaterMeterReading;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Exports\WaterReadingExport;
use App\Models\Core\Auth\User;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class AdminWaterReadingController extends Controller
{
    protected $pdfmaker;
    public function index()
    {
        // $water_readings = WaterMeterReading::with(['branch', 'house_lot', 'user'])->get();
        $water_readings = collect();
        return view('admin.water_readings.index', compact('water_readings'));
    }

    public function getWaterReadingsList()
    {
        $water_readings = WaterMeterReading::with(['branch', 'house_lot','user'])->paginate(10);
        return response()->json($water_readings);
    }

    public function getWaterReadingsListAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = WaterMeterReading::select('water_meter_readings.id', 'house_lot.house_lot_num', 'branch.name as branch', 'house_lot.serial_num', 'current_reading', 'last_reading', 'water_meter_readings.created_at', 'users.first_name', 'image')
                        ->leftJoin('house_lot', 'water_meter_readings.house_lot_id', '=', 'house_lot.id')
                        ->leftJoin('branch', 'water_meter_readings.branch_id', '=', 'branch.id')
                        ->leftJoin('users', 'water_meter_readings.user_id', '=', 'users.id');
            // $data = WaterMeterReading::with(['branch', 'house_lot','user'])->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                    ->editColumn('created_at', function ($row) {
                            return date('Y/m/d',strtotime($row->created_at));
                    })
                    ->addColumn('image', function($row) {
                        return view('admin.water_readings.includes.image', ['image' => $row->image]);
                    })
                    ->addColumn('action', function($row) {
                        return view('admin.water_readings.includes.table_buttons', ['id' => $row->id]);
                    })
                    ->rawColumns(['image', 'action'])
                    ->make(true);
        }

        return response()->json([false]);
    }

    public function create_view()
    {
        return view('admin.water_readings.create');
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image:jpg,jpeg,png',
            'current_reading' => 'required|max:50',
            'serial_num' => 'required',
            'house_lot_id' => 'required|exists:house_lot,id',
            'branch_id' => 'required|exists:branch,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->get('user_id')) {
                Cookie::queue('error_for_create_reading_field', 'User', 10);
                Cookie::queue('error_for_create_reading', $errors->get('user_id')[0], 10);
            }
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
            return redirect()->route('admin.water_readings.create-view');
        }

        if ($last_reading = WaterMeterReading::where('serial_num', $request->serial_num)->latest()->first()) {
            $request->merge(['last_reading' => $last_reading->current_reading]);
        }

        $destination_path = 'public/images/meter_readings';
        $image = $request->file('image');
        $image_name = "reading_" . Carbon::now()->format('YmdHs') . "." . $image->getClientOriginalExtension();
        $path = $image->storeAs($destination_path, $image_name);
        $request->merge(['image_name' => $image_name]);

        WaterMeterReading::create([
            'user_id' => $request->user_id,
            'house_lot_id' => $request->house_lot_id,
            'branch_id' => $request->branch_id,
            'serial_num' => $request->serial_num,
            'current_reading' => $request->current_reading,
            'last_reading' => $request->last_reading ? $request->last_reading : null,
            'image' => $request->image_name
        ]);

        Cookie::queue('reading_created', true, 10);

        return redirect()->route('admin.water_readings.index');
    }

    public function edit($id)
    {
        $water_reading = WaterMeterReading::with(['branch', 'house_lot', 'user'])->where('id',$id)->first();
        // dd($water_reading);
        return view('admin.water_readings.edit', compact('water_reading'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'image' => 'image:jpg,jpeg,png',
            'current_reading' => 'required|max:50',
            'serial_num' => 'required',
            'house_lot_id' => 'required|exists:house_lot,id',
            'branch_id' => 'required|exists:branch,id'
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
            return redirect()->route('admin.water_reading-edit',$id);
        }

        $old = WaterMeterReading::find($id);

        if($request->image){
            $destination_path = 'public/images/meter_readings';
            $image = $request->file('image');
            $image_name = "reading_" . Carbon::now()->format('YmdHs') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs($destination_path, $image_name);
            if ( File::exists(public_path("storage\images\meter_readings\\" . $old->image)) ) {
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
        }else{
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
            return redirect()->route('admin.water_readings.index');
        }
        Cookie::queue('reading_not_updated', true, 10);
        return redirect()->back();
    }

    public function delete($id)
    {
        $reading = WaterMeterReading::find($id);
        if (File::exists(public_path("storage\images\meter_readings\\" . $reading->image))) {
            File::delete(public_path("storage\images\meter_readings\\" . $reading->image));
        }
        $deleted = $reading->delete();
        if ($deleted) {
            Cookie::queue('delete_record_from_table', 'Water Reading', 10);
            return redirect()->back();
        }
        Cookie::queue('not_delete_record_from_table', 'Water Reading', 10);
        return redirect()->back();
    }

    public function getReadingInfo($id){
        $data = [];
        $data['water_reading'] = WaterMeterReading::find($id);
        $data['branch'] = Branch::find($data['water_reading']->branch_id);
        $data['house_lot'] = HouseLot::find($data['water_reading']->house_lot_id);
        $pdf =new PDF();
        $pdf = PDF::loadView('report.water_reading_info', $data);

        return $pdf->download('water_reading_'. Carbon::now()->format('YmdHs').'.pdf');
        
    }

    public function getAllExportData(){

        $water_readings = WaterMeterReading::with(['branch', 'house_lot'])->get();
        $all_records = [
            [
                'House Lot',
                'Branch',
                'Serial No',
                'Current Reading',
                'Last Reading',
                'Date Submitted',
                'Image uploaded',
                'Remark',
            ]];
        foreach($water_readings as $reading){
            // dd(Carbon::parse($reading->created_at)->format('d/m/Y h:m'));
            $record = [
                $reading->house_lot ? $reading->house_lot->house_lot_num : 'N/A',
                $reading->branch ? $reading->branch->name : 'N/A',
                $reading->serial_num,
                $reading->current_reading,
                $reading->last_reading ?? 'N/A',
                Carbon::parse($reading->created_at)->format('d/m/Y h:m'),
                $reading->image ? 'yes' : 'no',
                $reading->remark ?? 'N/A'
            ];
            array_push($all_records,$record);
        }

        $export = new WaterReadingExport($all_records);
        return Excel::download($export, 'Water_readings.xlsx');

    }

    // public function get
}
