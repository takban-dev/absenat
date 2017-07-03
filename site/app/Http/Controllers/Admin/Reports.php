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
    /* ========================================================================
                                using a report form
       ======================================================================== */
    public function use(Request $request, $id){
        $report = DB::table('reports')
                    ->where('id', '=', $id)
                    ->first();
        $group_code = Auth::user()->group_code;
        $title = $report->title;

        if($report == Null){
            return view('errors.custom', [
                'group_code'    => $group_code,
                'status'        => 404,
                'message'       => 'فرم گزارشگیری مورد نظر یافت نشد!']);
        }

        $properties = json_decode($report->properties);
        $columns = $properties->columns;
        $fields = $properties->fields;
        $limits = $properties->limits;

        for($i=0; $i<sizeof($fields); $i++){
            if($fields[$i]->input == 'select'){
                if($fields[$i]->values->type == 'refrenced'){
                    $fields[$i]->values->vars = 
                        DB::table(
                                $fields[$i]->values->table)
                            ->get();
                }
            }
        }

        for($i=0; $i<sizeof($columns); $i++){
            if($columns[$i]->values->type == 'refrenced'){
                $columns[$i]->values->vars = 
                    DB::table(
                            $columns[$i]->values->table)
                        ->get();
            }
        }

        if(sizeof($request->all())){
            return $this->usePost(
                $request,
                $id,
                $group_code,
                $report->title,
                $columns,
                $fields,
                $limits,
                $report->type);
        }else{
            return $this->useGet(
                $request,
                $id,
                $group_code,
                $report->title,
                $columns,
                $fields,
                $limits,
                $report->type);
        }
    }
    private function usePost($request, $id, $group_code, $title, $columns, $fields, $limits, $reportType){
        /* preparing the query to run */
        $results = DB::table('employees');

        $columnsArray = array();
        $lastColumn = '';
        foreach($columns as $column){
            array_push($columnsArray, $column->name);
            $lastColumn = $column->name;
        }

        $whereArray = array();
        foreach($fields as $field){
            $fieldName = $field->name;
            $fieldType = $field->input;
            if($request->has($fieldName)){
                $input = $request->input($fieldName);
                if($fieldType == 'select'){
                    if($input == '0')
                        continue;
                }else if($fieldType == 'autocomplete'){
                    $input = DB::table($field->values->table)
                                ->where('title', '=', $input)
                                ->first()->id;
                }
                array_push($whereArray, ['c' => $fieldName, 'v' => $input]);
            }
        }
        
        foreach($whereArray as $where){
            $results = $results->where($where['c'], '=', $where['v']);
        }

        foreach($limits as $limit){
            $results = $results->where($limit->field, '=' , $limit->value);
        }

        if($request->has('sort')){
            $results = $results->orderBy($request->input('sort'));
        }
        if($reportType == 1){
            $results = DB::table('employees')
                        ->select(DB::raw(implode(', ', $columnsArray) . ", count($lastColumn) as count"));

            foreach($columnsArray as $group){
                $results = $results->groupBy($group);
            }

            

            
            $results = $results->get();

            for($i=0; $i<sizeof($results); $i++){
                foreach($columns as $column){
                    if($column->values->type == 'direct')
                        continue;

                    $columnName = $column->name;
                    $results[$i]->{$columnName} = DB::table($column->values->table)
                            ->where('id', '=', $results[$i]->{$columnName})
                            ->first()
                            ->title;
                }
            }
            
            return view('admin.reports.count-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'fields'        => $fields,
                    'results'       => $results,
                    'query'         => $this->generateQuery($request),
                ]);
        }else if($reportType == 2){
            $results = DB::table('employees')
                        ->select($columnsArray);
            
            var_dump($whereArray);
            
            $results = $results->get();

            for($i=0; $i<sizeof($results); $i++){
                foreach($columns as $column){
                    if($column->values->type == 'direct')
                        continue;
                    
                    $columnName = $column->name;
                    $results[$i]->{$columnName} = DB::table($column->values->table)
                            ->where('id', '=', $results[$i]->{$columnName})
                            ->first()
                            ->title;
                }
            }
            
            return view('admin.reports.list-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'fields'        => $fields,
                    'results'       => $results,
                    'query'         => $this->generateQuery($request),
                ]);
        }
    }
    private function useGet($request, $id, $group_code, $title, $columns, $fields, $limits, $reportType){
        if($reportType == 1){
            return view('admin.reports.count-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'fields'        => $fields,
                    'query'         => $this->generateQuery($request),
                ]);
        }else if($reportType == 2){
            return view('admin.reports.list-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'fields'        => $fields,
                    'query'         => $this->generateQuery($request),
                ]);
        }
    }

    private function generateQuery(Request $request){
        $fields = $request->all();
        unset($fields['sort']);
        $fieldArray = [];
        foreach($fields as $key => $value)
            array_push($fieldArray, "$key=$value");
        $query = $request->url() . '?' . implode('&', $fieldArray); 
        return $query;
    }
    /* ========================================================================
                                      list
       ======================================================================== */
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = Auth::user()->group_code;
        $reports = DB::table('reports')
            ->limit($size)
            ->offset($page * $size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $reports = $reports->orderBy($order, 'asc');
        }
        $reports = $reports->get();

        $employeeCount = DB::table('reports')->count();

        $pageCount = ceil($employeeCount / $size);

        return view('admin.reports.list', [
            'reports'     => $reports, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'types'         => [
                1   => 'تعداد',
                2   => 'لیست'
            ],
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page),
            'pageCount'     => ceil($employeeCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }
    function generatePages($total, $current){
        if($total > 1){
            $total=intval($total);

            $output=[];
            $current_page= (false == isset($current)) ? 0 : $current;
            $lastPage = -1;
            $lower = $current_page -3;
            $upper = $current_page +3;
            for($page=0;$page<$total;$page++){
                if(($page > $lower && $page < $upper) || $page < 1 || $page > ($total-2)){
                    if($lastPage + 1 != $page)
                        array_push($output, '#');
                    array_push($output, $page+1);
                    $lastPage = $page;
                }
            }
            return $output;
        }else{
            return [];
        }
    }
    /* ========================================================================
                                      remove
       ======================================================================== */
    public function remove(Request $request, $id){
        DB::table('reports')->where('id', '=', $id)->delete();   
        return back();
    }
    /* ========================================================================
                                 create new report
       ======================================================================== */
    public function newGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.new', [
            'group_code'                => $group_code,
            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'habitates'                 => DB::table('cities')                      ->get(),
            'degrees'                   => DB::table('degrees')                     ->get(),
            'study_fields'              => DB::table('study_fields')                ->get(),
            'job_fields'                => DB::table('job_fields')                  ->get(),
            'marriges'                  => DB::table('merrige_types')               ->get(),
            'months'                    => config('constants.months')
            ]);
    }
    public function newPost(Request $request, $id){
        
    }
}