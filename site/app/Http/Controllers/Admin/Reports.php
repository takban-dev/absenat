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
    public function showPanelGet(Request $request){
        $group_code = Auth::user()->group_code;
        $filters = $this->createFiltes();
        return view('admin.reports', [
            'group_code'    => $group_code,
            'filters'       => $filters
            ]);
    }

    public function showPanelPost(Request $request){
        $group_code = Auth::user()->group_code;
        $filters = $this->createFiltes();

        $groupsArray = array();
        $whereArray = array();

        foreach($request->all() as $key => $value){
            if(!preg_match('/.*:.*/', $key))
                continue;

            $parts = preg_split('/:/', $key);
            if($parts[1] == 'dct'){
                array_push($groupsArray, $parts[0]);
            }else{
                if(isset($whereArray[$parts[0]])){
                    array_push($whereArray[$parts[0]], $parts[1]);
                }else{
                    $whereArray[$parts[0]] = array($parts[1]);
                }
            }

        }
        $columns = array();
        foreach($groupsArray as $item){
            array_push($columns, "$item,count($item)");
        }
        $columns = implode(',', $columns);

        $whereClauses = array();
        foreach ($whereArray as $key => $value) {
            $stmt = array();
            foreach($value as $item){
                array_push($stmt, "$key = $item");
            }
            $stmt = '( ' . implode(' or ', $stmt) . ' )'; 
            array_push($whereClauses, $stmt);
        }
        $whereClauses = implode(' and ', $whereClauses);

        $groups = implode(',', $groupsArray);
        $query = "select $columns from employees where $whereClauses group by $groups";

        var_dump($query);
        if($request->has("show")){
            echo 'show reports';
        }else if($request->has("print")){
            echo 'print reports';
        }
        return view('admin.reports', [
            'group_code'    => $group_code,
            'filters'       => $filters,
            'oldInputs'     => $request->All(),
            ]);
    }

    function createFiltes(){
        $filters = [
            'study_field'       => [ 'data' => DB::table('study_fields')    ->get(), 'title' => 'رشته ی تحصیلی'],
            'degree'            => [ 'data' => DB::table('degrees')         ->get(), 'title' => 'مدرک تحصیلی'],
            'job'               => [ 'data' => DB::table('job_fields')      ->get(), 'title' => 'عنوان شغلی'],
            'marrige'           => [ 'data' => DB::table('merrige_types')   ->get(), 'title' => 'وضعیت تاهل'],
            'habitate'          => [ 'data' => DB::table('cities')          ->get(), 'title' => 'محل سکونت'],
            'gender'            => [ 'data' => DB::table('genders')         ->get(), 'title' => 'جنسیت'],
        ];
        return $filters;
    }
}