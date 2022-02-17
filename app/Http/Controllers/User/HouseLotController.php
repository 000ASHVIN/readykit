<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\HouseLot;
use Illuminate\Http\Request;

class HouseLotController extends Controller
{
    public function getSerialNum($id){
        // dd($id);
        $serial_num = HouseLot::find($id);
        if(!$serial_num){
            return response()->json(false, 422);
        }
        return json_encode($serial_num);
    }
}
