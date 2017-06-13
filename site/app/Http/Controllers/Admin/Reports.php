<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class Reports extends Controller
{
    private $columnDictionary = [
        'gender'    => 'جنسیت',
        'job'       => 'عنوان شغلی',
        'field'     => 'رشته تحصیلی',
        'degree'    => 'مدرک تحصیلی',
        'habitate'  => 'محل سکونت',
        'marrige'   => 'وضعیت تعحل'
    ];

    public function showPanelGet(Request $request){
        $group_code = Auth::user()->group_code;
        return view('admin.reports-show', [
            'group_code'    => $group_code
            ]);
    }

    
}