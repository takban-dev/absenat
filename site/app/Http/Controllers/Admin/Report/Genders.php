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
    public function all(Request $request){
        $group_code = Auth::user()->group_code;

        $sortInput = $request->input('sort');
        $query = "SELECT gender, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender";
        if($sortInput != Null){
            $query = "SELECT gender, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender ORDER BY " . $sortInput;
        }

        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());

        for($i=0; $i<sizeof($queryResults); $i++)
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];

        return view('admin.reports.count', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'headers'       => 
                [
                    'gender'    => 'جنسیت', 
                    'count'     => 'تعداد'
                ],
            'query'         => $request->url() . $this->createQueryButSort($request),
            'title'         => 'تعداد شاغلین به تفکیک جنسیت',
        ]);
    }

    public function allList(Request $request){
        $form = [
            // genders
            [
                'title'     => 'جنسیت',
                'name'      => 'gender',
                'type'      => 'simple-select',

                'md'        => 6,
                'sm'        => 12,
                'title-sz'  => 4,

                'values'    => DB::table('genders')
                                ->get()
            ],
            // offset
            [
                'title'     => 'از ردیف',
                'name'      => 'offset',
                'type'      => 'number',

                'md'        => 3,
                'sm'        => 12
            ],
            // offset
            [
                'title'     => 'به تعداد',
                'name'      => 'limit',
                'type'      => 'number',

                'md'        => 3,
                'sm'        => 12
            ],
        ];
        if(sizeof($request->all()) > 0){
            return $this->allListPost($request, $form);
        }else{
            return $this->allListGet($request, $form);
        }
    }
    private function allListGet(Request $request, $form){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.list', [
            'group_code'    => $group_code,
            'fields'        => $form,
            'formAction'    => 'genders-list',
            'title'         => 'لیست شاغلین به تفکیک جنسیت',
        ]);
    }

    private function allListPost(Request $request, $form){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender');

        if($genderInput != '1'){
            $queryResults = $queryResults->where('gender', '=', $genderInput);
            $rowCount = $rowCount->where('gender', '=', $genderInput);
        }

        if($request->has('sort')){
            $queryResults = $queryResults
                                ->orderBy($request->input('sort'), 'ASC');
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders = $this->prettify(DB::table('genders')->get());
        for($i=0; $i<sizeof($queryResults); $i++)
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];

        return view('admin.reports.list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'fields'        => $form,
            'headers'       => [
                'first_name'    => 'نام',
                'last_name'     => 'نام خانوادگی',
                'gender'        => 'جنسیت',
                ],
            'formAction'    => 'genders-list',
            'title'         => 'لیست شاغلین به تفکیک جنسیت',
            'oldInputs'     => $request->all(),
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);   
    }

    /* ==============================================
                   study fields / gender
    ============================================== */
    public function studyField(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, field, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, field";

        if($request->has('sort')){
            $query = "SELECT gender, field, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, field ORDER BY " . $request->get('sort');
        }

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
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);
    }

    public function studyFieldList(Request $request){
        if(sizeof($request->all()) > 0){
            return $this->studyFieldListPost($request);
        }else{
            return $this->studyFieldListGet($request);
        }
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
        $fieldTitle     = $request->input('field_title');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'field');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'field');

        if($genderInput != '1'){
            $queryResults = $queryResults->where('gender', '=', $genderInput);
            $rowCount = $rowCount->where('gender', '=', $genderInput);
        }

        if($fieldTitle != Null){
            $field = DB::table('study_fields')->where('title', '=', $fieldTitle)->first()->id;
            $queryResults = $queryResults->where('field', '=', $field);
            $rowCount = $rowCount->where('field', '=', $field);   
        }
        if($request->has('sort')){
            $queryResults = $queryResults
                                ->orderBy($request->input('sort'), 'ASC');
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
            'headers'       => [
                'first_name'    => 'نام',
                'last_name'     => 'نام خانوادگی',
                'gender'        => 'جنسیت',
                'field'         => 'رشته تحصیلی'
                ],
            'oldInputs'     => $request->all(),
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);   
    }

    /* ==============================================
                     degree / gender
    ============================================== */
    public function degree(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, degree, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, degree";

        if($request->has('sort')){
            $query = "SELECT gender, degree, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, degree ORDER BY " . $request->get('sort');
        }

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
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);
    }

    public function degreeList(Request $request){
        if(sizeof($request->all()) > 0){
            return $this->degreeListPost($request);
        }else{
            return $this->degreeListGet($request);
        }
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

        if($request->has('sort')){
            $queryResults = $queryResults
                                ->orderBy($request->input('sort'), 'ASC');
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
            'headers'       => 
                [
                    'first_name'    => 'نام', 
                    'last_name'     => 'نام خانوادگی', 
                    'gender'        => 'جنسیت', 
                    'degree'        => 'مدرک تحصیلی'
                ],
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'degrees'       => DB::table('degrees')->where('id', '>', 1)->get(),
            'oldInputs'     => $request->all(),
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);   
    }

    /* ==============================================
                     habitate / gender
    ============================================== */
    public function habitate(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, habitate, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, habitate";

        if($request->has('sort')){
            $query = "SELECT gender, habitate, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, habitate ORDER BY " . $request->get('sort');
        }

        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());
        $cities = $this->prettify(DB::table('cities')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->habitate = $cities[$queryResults[$i]->habitate];
        }

        return view('admin.reports.gender-habitate', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);
    }

    public function habitateList(Request $request){
        if(sizeof($request->all()) > 0){
            return $this->habitateListPost($request);
        }else{
            return $this->habitateListGet($request);
        }
    }

    public function habitateListGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.gender-habitate-list', [
            'group_code'    => $group_code,
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'cities'       => DB::table('cities')->where('id', '>', 1)->get(),
        ]);
    }

    public function habitateListPost(Request $request){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $cityTitle      = $request->input('city_title');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'habitate');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'habitate');

        if($genderInput != '1'){
            $queryResults = $queryResults->where('gender', '=', $genderInput);
            $rowCount = $rowCount->where('gender', '=', $genderInput);
        }

        if($cityTitle != Null){
            $habitate = DB::table('cities')->where('title', '=', $cityTitle)->first()->id;
            $queryResults = $queryResults->where('habitate', '=', $habitate);
            $rowCount = $rowCount->where('habitate', '=', $habitate);   
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders  = $this->prettify(DB::table('genders')->get());
        $cities = $this->prettify(DB::table('cities')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->habitate = $cities[$queryResults[$i]->habitate];
        }

        return view('admin.reports.gender-habitate-list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'gender'        => $genderInput,
            'headers'       => 
                [
                'first_name'    => 'نام', 
                'last_name'     => 'نام خانوادگی', 
                'gender'        => 'جنسیت', 
                'habitate'      => 'محل سکونت'
                ],
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'cities'        => DB::table('cities')->where('id', '>', 1)->get(),
            'oldInputs'     => $request->all(),
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);   
    }

    /* ==============================================
                     job field / gender
    ============================================== */
    public function job(Request $request){
        $group_code = Auth::user()->group_code;


        $query = "SELECT gender, job, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, job";

        if($request->has('sort')){
            $query = "SELECT gender, job, COUNT(gender)'COUNT' FROM `employees` GROUP BY gender, job ORDER BY " . $request->get('sort');
        }

        $queryResults = DB::select(DB::raw($query));
        $genders = $this->prettify(DB::table('genders')->get());
        $jobFields = $this->prettify(DB::table('job_fields')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->job = $jobFields[$queryResults[$i]->job];
        }

        return view('admin.reports.gender-job', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'query'         => $request->url() . $this->createQueryButSort($request) ,
        ]);
    }

    public function jobList(Request $request){
        if(sizeof($request->all()) > 0){
            return $this->jobListPost($request);
        }else{
            return $this->jobListGet($request);
        }
    }

    public function jobListGet(Request $request){
        $group_code = Auth::user()->group_code;

        return view('admin.reports.gender-habitate-list', [
            'group_code'    => $group_code,
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'jobFields'     => DB::table('job_fields')->where('id', '>', 1)->get(),
        ]);
    }

    public function jobListPost(Request $request){
        $group_code = Auth::user()->group_code;

        $genderInput    = $request->input('gender');
        $jobTitle       = $request->input('city_title');
        $limit          = $request->input('limit');
        $offset         = $request->input('offset');

        $queryResults = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'job');
        $rowCount = DB::table('employees')
            ->select('first_name', 'last_name', 'gender', 'job');

        if($genderInput != '1'){
            $queryResults = $queryResults->where('gender', '=', $genderInput);
            $rowCount = $rowCount->where('gender', '=', $genderInput);
        }

        if($jobTitle != Null){
            $job = DB::table('job_fields')->where('title', '=', $jobTitle)->first()->id;
            $queryResults = $queryResults->where('job', '=', $job);
            $rowCount = $rowCount->where('job', '=', $job);   
        }

        $queryResults = $queryResults
            ->limit($limit)
            ->offset($offset)
            ->get();
        $rowCount = $rowCount->count();

        $genders   = $this->prettify(DB::table('genders')->get());
        $jobFields = $this->prettify(DB::table('job_fields')->get());

        for($i=0; $i<sizeof($queryResults); $i++){
            $queryResults[$i]->gender = $genders[$queryResults[$i]->gender];
            $queryResults[$i]->job = $jobFields[$queryResults[$i]->job];
        }

        return view('admin.reports.gender-job-list', [
            'group_code'    => $group_code,
            'results'       => $queryResults,
            'gender'        => $genderInput,
            'headers'       => 
                [
                'first_name'    => 'نام', 
                'last_name'     => 'نام خانوادگی', 
                'gender'        => 'جنسیت', 
                'job'           => 'عنوان شغلی'],
            'genders'       => DB::table('genders')->where('id', '>', 1)->get(),
            'jobFields'     => DB::table('job_fields')->where('id', '>', 1)->get(),
            'oldInputs'     => $request->all(),
            'query'         => $request->url() . $this->createQueryButSort($request) ,
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
    
    function createQueryButSort(Request $request){
        $inputArray = $request->all();
        $queryArray = [];
        foreach($inputArray as $key=>$value)
            if($key != 'sort')
                array_push($queryArray, "$key=$value");

        $query = implode('&', $queryArray);
        if(sizeof($queryArray) > 0){
            return '?' . $query . '&';
        }else{
            return '?';
        }
    }
}