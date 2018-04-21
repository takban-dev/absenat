<?php

namespace App\Http\Controllers\RegularMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Time;

class NormalEmployeesController extends Controller
{
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = Auth::user()->group_code;
        $employees = DB::table('employees')
            ->join('degrees', 'employees.degree', '=', 'degrees.id')
            ->join('study_fields', 'employees.field', '=', 'study_fields.id')
            ->join('cities', 'employees.habitate', '=', 'cities.id')
            ->join('units', 'employees.unit_id', '=', 'units.id')
            ->select(DB::raw("employees.id, employees.first_name, employees.last_name, degrees.title'degree', study_fields.title'field', units.title'unit', cities.title'habitate'"))
            ->limit($size)
            ->offset($page * $size)
            ->where('employees.user', '=', Auth::user()->name);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $employees = $employees->orderBy($order, 'asc');
        }
        $employees = $employees->get();

        $employeeCount = DB::table('employees')
            ->where('employees.user', '=', Auth::user()->name)
            ->count();

        $pageCount = ceil($employeeCount / $size);

        return view('normal.employees.list', [
            'employees'     => $employees, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page),
            'pageCount'     => ceil($employeeCount / $size),
            'sort'          => $request->has('sort')? ('?sort=' . $request->input('sort')) : '',
            ]);
    }

    public function remove_track($id){
      DB::table('work_history')->where('id', $id)->delete();
      return redirect()->back();
    }
    public function editPost(Request $request, $id){
        $group_code = Auth::user()->group_code;
        if($request->has('track')){
          if($request->input('track') == 'new'){
            $time = Time::jmktime(12,12,12, $request->input('track_date_month'),$request->input('track_date_day'),$request->input('track_date_year'));
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_track_title'))->first()->id;
            DB::table('work_history')->insert([
              'employee_id'     => $id,
              'unit_id'         => $unitId,
              'time'            => $time,
              'type'            => $request->input('track_type'),
            ]);
            if($request->input('track_type') == 1)
              DB::table('employees')->where(['id' => $id])
                ->update(['unit_id' => $unitId]);

            return redirect('employee/' . $id);
          }else if($request->input('track') == 'edit'){
            $time = Time::jmktime(12,12,12, $request->input('track_date_month_' . $request->input('track_id')),$request->input('track_date_day_' . $request->input('track_id')),$request->input('track_date_year_' . $request->input('track_id')));
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_track_title_' . $request->input('track_id')))->first()->id;
            DB::table('work_history')
              ->where('id', $request->input('track_id'))
              ->update([
                'unit_id'         => $unitId,
                'time'            => $time,
                'type'            => $request->input('track_type_' . $request->input('track_id')),
              ]);
            if($request->input('track_type_' . $request->input('track_id')) == 1)
              DB::table('employees')->where(['id' => $id])
                ->update(['unit_id' => $unitId]);

            return redirect('employee/' . $id);
          }
        }
        $validator = $this->myValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;

            return view('normal.employees.edit', [
                'group_code'                => $group_code,
                'oldInputs'                 => $oldInputs,
                'username'                  => Auth::user()->name,

                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_title'))->first()->id;
            $fieldId = DB::table('study_fields')->where('title', '=', $request->input('field_title'))->first()->id;

            DB::table('employees')->where(['id' => $id])->update(
                [
                    'user'                  => $username,
                    'unit_id'               => $unitId,
                    'first_name'            => $request->input('first_name'),
                    'last_name'             => $request->input('last_name'),
                    'father_name'           => $request->input('father_name'),
                    'id_number'             => $request->input('id_number'),
                    'gender'                => $request->input('gender'),
                    'birth_date'            => $request->input('birth_date_year') . '-' . $request->input('birth_date_month') . '-' . $request->input('birth_date_day'),
                    'birth_place'           => $request->input('birth_place'),
                    'habitate'              => $request->input('habitate'),
                    'habitate_years'        => $request->input('habitate_years'),
                    'degree'                => $request->input('degree'),
                    'field'                 => $fieldId,
                    'job'                   => $request->input('job'),
                    'marrige'               => $request->input('marrige'),
                    'dependents'            => $request->input('dependents'),
                    'experience'            => $request->input('experience'),
                    'address'               => $request->input('address'),
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('employee/' . $id);
        }
    }
    public function editGet(Request $request, $id){
        $group_code = Auth::user()->group_code;
        $employee = DB::table('employees')->where(['id' => $id, 'user' => Auth::user()->name])->first();
        if(!$employee)
          return abort(404);
        $employee = get_object_vars($employee);
        
        $employee['unit_title'] = DB::table('units')->where('id', '=', $employee['unit_id'])->first()->title;
        $employee['field_title'] = DB::table('study_fields')->where('id', '=', $employee['field'])->first()->title;
        $employee['work_history'] = DB::table('work_history')
          ->join('units', ['units.id' => 'work_history.unit_id'])
          ->select('work_history.*', 'units.title')
          ->where(['employee_id' => $employee['id'], 'units.user' => Auth::user()->name])
          ->get();
        for($i=0; $i<sizeof($employee['work_history']); $i++){
          $employee['work_history'][$i]->time = Time::jgetdate($employee['work_history'][$i]->time);
        }

        $birth_date = explode('-', $employee['birth_date']);
        $employee['birth_date_day']   = $birth_date[2];
        $employee['birth_date_month'] = $birth_date[1];
        $employee['birth_date_year']  = $birth_date[0];

        return view('normal.employees.edit', [
            'group_code'                => $group_code,
            'oldInputs'                 => $employee,
            'username'                  => Auth::user()->name,

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

    public function remove(Request $request, $id){
        DB::table('employees')->where('id', '=', $id)->delete();   
        return back();
    }

    public function newGet(Request $request, $unitId=0){
        $group_code = Auth::user()->group_code;

        $unitTitle = '';
        if($unitId != 0)
            $unitTitle = DB::table('units')->where('id', '=', $unitId)->first()->title;
        
        $unitTitle = $request->input('unit');

        return view('normal.employees.new', [
            'unitTitle'                 => $unitTitle,
            'group_code'                => $group_code,
            'fill'                      => ($request->has('unit')? 'new': ''),
            'id_number'                 => $request->input('id'),
            'username'                  => Auth::user()->name,
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

    public function newPost(Request $request){
        $validator = $this->myValidate($request);
        $group_code = Auth::user()->group_code;
        if($validator->fails()){

            return view('normal.employees.new', [
                'group_code'                => $group_code,
                'username'                  => Auth::user()->name,
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'oldInputs'                 => $request->all(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_title'))->first()->id;
            $fieldId = DB::table('study_fields')->where('title', '=', $request->input('field_title'))->first()->id;

            $id = DB::table('employees')->insertGetId(
                [
                    'user'                  => $username,
                    'unit_id'               => $unitId,
                    'first_name'            => $request->input('first_name'),
                    'last_name'             => $request->input('last_name'),
                    'father_name'           => $request->input('father_name'),
                    'id_number'             => $request->input('id_number'),
                    'gender'                => $request->input('gender'),
                    'birth_date'            => $request->input('birth_date_year') . '-' . $request->input('birth_date_month') . '-' . $request->input('birth_date_day'),
                    'birth_place'           => $request->input('birth_place'),
                    'habitate'              => $request->input('habitate'),
                    'habitate_years'        => $request->input('habitate_years'),
                    'degree'                => $request->input('degree'),
                    'field'                 => $fieldId,
                    'job'                   => $request->input('job'),
                    'marrige'               => $request->input('marrige'),
                    'dependents'            => $request->input('dependents'),
                    'experience'            => $request->input('experience'),
                    'address'               => $request->input('address'),
                    'created_at'            => time()[0],
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('employee/' . $id);
        }
    }
    public function myValidate($request){
      Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
          return !(in_array($parameters[0], array('on', 'true', 1, '1')));
      });
      $niceNames = [
        'first_name'                => 'نام',
        'last_name'                 => 'نام خانوادگی',
        'gender'                    => 'جنسیت',
        'id_number'                 => 'کدملی',
        'father_name'               => 'نام پدر',
        'birth_date_day'            => 'روز تولد',
        'birth_date_month'          => 'ماه تولد',
        'birth_date_year'           => 'سال تولد',
        'birth_place'               => 'محل تولد',
        'habitate'                  => 'محل سکونت',
        'habitate_years'            => 'سال های سکونت',
        'degree'                    => 'مدرک تحصیلی',
        'field_title'               => 'رشته تحصیلی',
        'job'                       => 'شغل',
        'marrige'                   => 'وضعیت تاهل',
        'dependents'                => 'تعداد افراد تحت تکفل',
        'unit_title'                => 'کارگاه',
        'experience'                => 'سابقه کار',
        'address'                   => 'آدرس دقیق',
      ];
      $messages = [
        '*.required'                  => 'لطفا :attribute را وارد کنید',
        '*.email'                     => 'آدرس ایمیل وارد شده نامعتبر است',
        '*.min'                       => 'حداقل طول :attribute باید :min حرف باشد',
        '*.numeric'                   => ':attribute باید عدد باشد'
      ];

      $rules = [
          'first_name'                => 'required',
          'last_name'                 => 'required',
          
          'gender'                    => 'required|numeric|int:2,3',
          'id_number'                 => 'required|size:10',
          'father_name'               => 'required',
          
          'birth_date_day'            => 'required|numeric|min:1|max:30',
          'birth_date_month'          => 'required|numeric|min:1|max:12',
          'birth_date_year'           => 'required|numeric',

          'birth_place'               => 'required',

          'habitate'                  => 'required|numeric',
          'habitate_years'            => 'required|numeric',

          'degree'                    => 'required|numeric',
          'field_title'               => 'required',
          'job'                       => 'required|numeric',

          'marrige'                   => 'required|numeric',
          'dependents'                => 'required|numeric',

          'experience'                => 'required|numeric',
          'unit_title'                => 'required',
          'address'                   => 'required',
      ];
      $validator = Validator::make($request->all(), $rules, $messages);
      $validator->setAttributeNames($niceNames);

      return $validator;
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

        function prettify($data){
        $result = [];
        foreach($data as $item){
            $result[$item->id] = $item->title;
        }
        $result[0] = 'مشخص نشده';
        return $result;
    }
    
    public function listPrint(Request $request){
        $startPage  = $request->input('startPage');
        $endPage    = $request->input('endPage');
        $pageSize   = $request->input('pageSize');

        $offset = $startPage * $pageSize;
        $limit = $pageSize * ($endPage - $startPage + 1);
        $employees = DB::table('employees')
            ->where('user', '=', Auth::user()->name)
            ->offset($offset)
            ->limit($limit)
            ->get();

        for($i=0; $i<sizeof($employees); $i++){
            $employees[$i]->unitTitle = DB::table('units')->where('id', '=', $employees[$i]->unit_id)->first()->title;
        }

        return view('prints/list-employee', [
            'employees'         => $employees,
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
            'complete'          => $request->has('complete')? true : false,
            ])->render();
    }

    public function singlePrint($id){
        $employee = DB::table('employees')->where('id', '=', $id)->first();
        $unitTitle = DB::table('units')->where('id', '=', $employee->unit_id)->first()->title;
        return view('prints/single-employee', [
            'info'              => $employee,
            'field'             => $this->prettify(DB::table('study_fields')->get()),
            'degree'            => $this->prettify(DB::table('degrees')->get()),
            'job'               => $this->prettify(DB::table('job_fields')->get()),
            'marrige'           => $this->prettify(DB::table('merrige_types')->get()),
            'habitate'          => $this->prettify(DB::table('cities')->get()),
            'gender'            => $this->prettify(DB::table('genders')->get()),
            'unitTitle'         => $unitTitle,
            ])->render();
    }

    public function access(Request $request){
      $group_code = Auth::user()->group_code;
      $error = 0;
      switch($request->input('error', 0)){
            case 1:
                $error = 'کارگاه را وارد کنید';
            break;
      }
      return view('normal.access', [
        'group_code'    =>   $group_code,
        'error'         => $error,
      ]);
    }

    public function exchange(Request $request){
        // $group_code = Auth::user()->group_code;
        $employee = DB::table('employees')
            ->where('id_number', $request->id_number)
            ->join('units', 'units.id', '=', 'employees.unit_id')
            ->select('employees.*')
            ->first();
        if(!$employee)
            return redirect('/employee-new?id=' . $request->id_number . '&unit=' . $request->unit_title);
        if($employee->user != Auth::user()->name){
            $unitId = DB::table('units')->where('title', '=', $request->input('unit_title'))->first();
            if($unitId){
                $unitId = $unitId->id;
                DB::table('employees')
                    ->where(['id' => $employee->id])
                    ->update(['user' => Auth::user()->name, 'unit_id' => $unitId]);
                
            }else{
                return redirect('/employee-access?error=1');
            }
            return redirect('/employee/' . $employee->id);
        }
        return redirect('/employee/' . $employee->id);
    }
}