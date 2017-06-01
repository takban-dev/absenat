<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Unit extends Controller{
    public function getAll(Request $request){
        $units = DB::table('units')->select(['id', 'title'])->get();
        return json_encode($units);
    }
}