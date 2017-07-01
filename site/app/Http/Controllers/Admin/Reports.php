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
                $report->type);
        }else{
            return $this->useGet(
                $request,
                $id,
                $group_code,
                $report->title,
                $columns,
                $fields,
                $report->type);
        }
    }
    private function usePost($request, $id, $group_code, $title, $columns, $fields, $reportType){
        if($reportType == 1){
            /* preparing the query to run */
            $results = DB::table('employees');

            $groupByArray = array();
            $lastColumn = '';
            foreach($columns as $column){
                array_push($groupByArray, $column->name);
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

            $results = DB::table('employees')
                        ->select(DB::raw(implode(', ', $groupByArray) . ", count($lastColumn) as count"));

            foreach($groupByArray as $group){
                $results = $results->groupBy($group);
            }

            foreach($whereArray as $where){
                $results = $results->where($where['c'], '=', $where['v']);
            }

            if($request->has('sort')){
                $results = $results->orderBy($request->input('sort'));
            }
            $results = $results->get();

            for($i=0; $i<sizeof($results); $i++){
                foreach($columns as $column){
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
        }else if($report->type == 2){
            return view('reports.list-base', [
                    'group_code'    => $group_code,
                    'title'         => $title,
                    'query'         => $this->generateQuery($request),
                ]);
        }
    }
    private function useGet($request, $id, $group_code, $title, $columns, $fields, $reportType){
        if($reportType == 1){
            return view('admin.reports.count-base', [
                    'group_code'    => $group_code,
                    'reportId'      => $id,
                    'title'         => $title,
                    'columns'       => $columns,
                    'fields'        => $fields,
                    'query'         => $this->generateQuery($request),
                ]);
        }else if($report->type == 2){
            return view('reports.list-base', [
                    'group_code'    => $group_code,
                    'title'         => $title,
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
}