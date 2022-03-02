<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Area;
use App\Models\Admin\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(){
        $branches = Branch::with(['area', 'houseLot'])->get();
        // dd(count($branches->first()->houseLot));
        return view('admin.dashboard.index', compact('branches'));
    }

    public function reports() {
        $areas = Area::all();
        foreach($areas as $area) {
            $branches = Branch::select(
                'branch.id',
                'branch.name', 
                DB::raw('(select COUNT(branch_house_lot.branch_id) as total_house from branch_house_lot where branch_house_lot.branch_id = branch.id group by branch_house_lot.branch_id) as total_houselot')
                )
                ->where('area_id', $area->id)
                ->get();
            $area->branches = $branches;
        }
        // dd($areas);
        return view('admin.dashboard.reports', compact('areas'));
    }
}
