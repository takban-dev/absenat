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
        $filters = $this->createFiltes();
        return view('admin.reports-show', [
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
            array_push($columns, "$item,IFNULL(COUNT($item), 0)");
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
        $query = "select $columns from employees " . (sizeof($whereArray) > 0 ? "where " . $whereClauses : "") .(sizeof($groupsArray) > 0 ? "group by " . $groups : "");

        $queryResults = DB::select(DB::raw($query));

        $results = $this->convertQueryResultToTable($queryResults);

        if($request->has("show")){
            return view('admin.reports-show', [
            'group_code'    => $group_code,
            'filters'       => $filters,
            'oldInputs'     => $request->All(),
            'results'       => $results,
            'headers'       => $this->columnDictionary,
            ]);
        }else if($request->has("print")){
            return view('admin.reports-print', [
            'results'       => $results,
            ]);
        }
    }

    function createFiltes(){
        $filters = [
            'field'             => [ 'data' => DB::table('study_fields')    ->get(), 'title' => 'رشته ی تحصیلی'],
            'degree'            => [ 'data' => DB::table('degrees')         ->get(), 'title' => 'مدرک تحصیلی'],
            'job'               => [ 'data' => DB::table('job_fields')      ->get(), 'title' => 'عنوان شغلی'],
            'marrige'           => [ 'data' => DB::table('merrige_types')   ->get(), 'title' => 'وضعیت تاهل'],
            'habitate'          => [ 'data' => DB::table('cities')          ->get(), 'title' => 'محل سکونت'],
            'gender'            => [ 'data' => DB::table('genders')         ->get(), 'title' => 'جنسیت'],
        ];
        return $filters;
    }

    function prettify($data){
        $result = [];
        foreach($data as $item){
            $result[$item->id] = $item->title;
        }
        return $result;
    }

    function convertQueryResultToTable($queryResults){
        $dics = [
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
        ];
        if(sizeof($queryResults) > 0){
            $headers = [];
            foreach($queryResults[0] as $key => $value){
                if(isset($this->columnDictionary[$key])){
                    array_push($headers, $this->columnDictionary[$key]);
                    $headerIndex[$key] = sizeof($headers)-1;
                }
            }
            array_push($headers, 'تعداد');

            $data = array();
            $chart = ['series' => [], 'data' => []];
            foreach($queryResults as $row){
                $lastInspect = null;
                $r = [];
                foreach($row as $key => $value){
                    if(isset($this->columnDictionary[$key])){
                        array_push($r, $dics[$key][$value]);
                    }else{
                        $lastInspect = $key;
                    }
                }
                array_push($r, $row->$key);
                array_push($data, $r);

                $s = [];
                for($i=0; $i<sizeof($r)-1; $i++){
                    array_push($s, $r[$i]);
                }
                array_push($chart['series'], implode(' - ', $s));
                array_push($chart['data'], $r[sizeof($r)-1]);
            }
            return [
                'headers'   => $headers,
                'data'      => $data,
                'chart'     => $chart,
            ];
        }else{
            return null;
        }
    }
}