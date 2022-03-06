<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function getBranch($id){
        $branch = Branch::find($id);
        if(!$branch) {
            return json_encode(false);
        }
        return json_encode($branch);
    }

    public function getHouseLotsList($id) {
        $branch = Branch::find($id);
        if($branch) {
            $houseLots = $branch->houseLot;
            return $houseLots;
        }
        return json_encode(false);
    }
}
