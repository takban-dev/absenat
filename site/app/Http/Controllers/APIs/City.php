<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class City extends Controller{
    public function getAll(Request $request){
        $cities = DB::table('cities')->get();
        return json_encode($cities);
    }
}