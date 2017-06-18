<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class Genders extends Controller
{
    public function allGet(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, SUM(gender)'sum' FROM `employees` GROUP BY gender";
        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());

        for($i=0; $i<sizeof($queryResults); $i++)
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];

        return view('admin.reports.gender', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'headers'       => ['جنسیت', 'تعداد'],
        ]);
    }

    public function allListGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.gender-list', [
            'group_code'    => $group_code,
        ]);
    }

    public function allListPost(Request $request){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender');

        if($genderInput == '2'){
            $queryResults = $queryResults->where('gender', '=', 2);
            $rowCount = $rowCount->where('gender', '=', 2);
        }
        if($genderInput == '3'){
            $queryResults = $queryResults->where('gender', '=', 3);
            $rowCount = $rowCount->where('gender', '=', 3);
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders = $this->prettify(DB::table('genders')->get());
        for($i=0; $i<sizeof($queryResults); $i++)
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];

        return view('admin.reports.gender-list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'gender'        => $genderInput,
            'headers'       => ['نام', 'نام خانوادگی', 'جنسیت'],
            'oldInputs'     => $request->all()
        ]);   
    }

    /* ==============================================
                   study fields / gender
    ============================================== */
    public function studyFieldGet(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, field, SUM(gender)'sum' FROM `employees` GROUP BY gender, field";

        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());
        $study_fields = $this->prettify(DB::table('study_fields')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->field = $study_fields[$queryResults[$i]->field];
        }

        return view('admin.reports.gender-field', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
        ]);
    }

    public function studyFieldListGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.gender-field-list', [
            'group_code'    => $group_code,
        ]);
    }

    public function studyFieldListPost(Request $request){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'field');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'field');

        if($genderInput == '2'){
            $queryResults = $queryResults->where('gender', '=', 2);
            $rowCount = $rowCount->where('gender', '=', 2);
        }
        if($genderInput == '3'){
            $queryResults = $queryResults->where('gender', '=', 3);
            $rowCount = $rowCount->where('gender', '=', 3);
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders = $this->prettify(DB::table('genders')->get());
        $fields = $this->prettify(DB::table('study_fields')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->field = $fields[$queryResults[$i]->field];
        }

        return view('admin.reports.gender-field-list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'gender'        => $genderInput,
            'headers'       => ['نام', 'نام خانوادگی', 'جنسیت', 'رشته تحصیلی'],
            'oldInputs'     => $request->all()
        ]);   
    }

    /* ==============================================
                     degree / gender
    ============================================== */
    public function degreeGet(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, degree, SUM(gender)'sum' FROM `employees` GROUP BY gender, degree";

        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());
        $degrees = $this->prettify(DB::table('degrees')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->degree = $degrees[$queryResults[$i]->degree];
        }

        return view('admin.reports.gender-degree', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
        ]);
    }

    public function degreeListGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.gender-degree-list', [
            'group_code'    => $group_code,
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'degrees'       => DB::table('degrees')->where('id', '>', 1)->get(),
        ]);
    }

    public function degreeListPost(Request $request){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $degreeInput    = $request->input('degree');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'degree');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'degree');

        if($genderInput != '1'){
            $queryResults = $queryResults->where('gender', '=', $genderInput);
            $rowCount = $rowCount->where('gender', '=', $genderInput);
        }
        if($degreeInput != '1'){
            $queryResults = $queryResults->where('degree', '=', $degreeInput);
            $rowCount = $rowCount->where('degree', '=', $degreeInput);
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders = $this->prettify(DB::table('genders')->get());
        $degrees = $this->prettify(DB::table('degrees')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->degree = $degrees[$queryResults[$i]->degree];
        }

        return view('admin.reports.gender-degree-list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'gender'        => $genderInput,
            'headers'       => ['نام', 'نام خانوادگی', 'جنسیت', 'مدرک تحصیلی'],
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'degrees'       => DB::table('degrees')->where('id', '>', 1)->get(),
            'oldInputs'     => $request->all()
        ]);   
    }

    /* ====================================================================
                        other utility functions
       ==================================================================== */

    function prettify($data){
        $result = [];
        foreach($data as $item){
            $result[$item->id] = $item->title;
        }
        $result[0] = 'مشخص نشده';
        return $result;
    }
    public function showPanelGet(Request $request){
        $group_code = Auth::user()->group_code;
        return view('admin.reports-show', [
            'group_code'    => $group_code
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
    
}