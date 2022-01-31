<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\HouseLot;
use Illuminate\Http\Request;

class HouseLotController extends Controller
{
    public function getHouseLot($id){
        $house_lot = HouseLot::where('serial_num', $id)->first();
        if(!$house_lot){
            return response()->json(false,422);
        }
        return json_encode($house_lot) ;
    }
}
