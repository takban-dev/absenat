<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Time;
class AdminEmployeesController extends Controller
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
            ->offset($page * $size);

        if($request->has('sort')){
            $orders = preg_split('/,/', $request->input('sort'));
            foreach($orders as $order)
            $employees = $employees->orderBy($order, 'asc');
        }
        
        if($request->has('first_name')){
            $search = $request->input('first_name');
            $employees = $employees->whereRaw("employees.first_name LIKE '%$search%'");
        }
        if($request->has('last_name')){
            $search = $request->input('last_name');
            $employees = $employees->whereRaw("employees.last_name LIKE '%$search%'");
        }

        $employees = $employees->get();

        $employeeCount = DB::table('employees')->count();
        $pageCount = ceil($employeeCount / $size);

        return view('admin.employees.list', [
            'employees'     => $employees, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
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
            DB::table('work_history')->insert([
              'employee_id'     => $id,
              'unit_id'         => DB::table('units')->where('title', '=', $request->input('unit_track_title'))->first()->id,
              'time'            => $time,
              'type'            => $request->input('track_type'),
            ]);
            return redirect('admin/employee/' . $id);
          }else if($request->input('track') == 'edit'){
            $time = Time::jmktime(12,12,12, $request->input('track_date_month_' . $request->input('track_id')),$request->input('track_date_day_' . $request->input('track_id')),$request->input('track_date_year_' . $request->input('track_id')));
            DB::table('work_history')
              ->where('id', $request->input('track_id'))
              ->update([
                'unit_id'         => DB::table('units')->where('title', '=', $request->input('unit_track_title_' . $request->input('track_id')))->first()->id,
                'time'            => $time,
                'type'            => $request->input('track_type_' . $request->input('track_id')),
              ]);
            return redirect('admin/employee/' . $id);
          }
        }
        $validator = $this->myValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;
            $oldInputs['unit_title'] = $request->input('unit_title');

            return view('admin.employees.edit', [
                'group_code'                => $group_code,
                'oldInputs'                 => $oldInputs,

                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'months'                    => config('constants.months'),
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
                    'phone'                 => $request->input('phone'),
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/employee/' . $id);
        }
    }
    public function editGet(Request $request, $id){
        $group_code = Auth::user()->group_code;
        $employee = get_object_vars(DB::table('employees')->where('id', '=', $id)->first());

        $employee['unit_title'] = DB::table('units')->where('id', '=', $employee['unit_id'])->first()->title;
        $employee['field_title'] = DB::table('study_fields')->where('id', '=', $employee['field'])->first()->title;
        $employee['work_history'] = DB::table('work_history')
          ->join('units', 'units.id', '=', 'work_history.unit_id')
          ->select('work_history.*', 'units.title')
          ->where('employee_id', '=', $employee['id'])
          ->get();
        for($i=0; $i<sizeof($employee['work_history']); $i++){
          $employee['work_history'][$i]->time = Time::jgetdate($employee['work_history'][$i]->time);
        }
        // return json_encode($employee['work_history']);
        $birth_date = explode('-', $employee['birth_date']);
        $employee['birth_date_day']   = $birth_date[2];
        $employee['birth_date_month'] = $birth_date[1];
        $employee['birth_date_year']  = $birth_date[0];

        return view('admin.employees.edit', [
            'group_code'                => $group_code,
            'oldInputs'                 => $employee,

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

    public function removeSelf(Request $request, $id){
        DB::table('employees')->where('id', '=', $id)->delete();
        return redirect('admin/employees/');;
    }

    public function newGet(Request $request, $unitId=0){
        $group_code = Auth::user()->group_code;
        $unitTitle = '';
        if($unitId != 0)
            $unitTitle = DB::table('units')->where('id', '=', $unitId)->first()->title;
        

        return view('admin.employees.new', [
            'unit_title'                => $unitTitle,
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

    public function newPost(Request $request){
        $validator = $this->myValidate($request);
        $group_code = Auth::user()->group_code;
        if($validator->fails()){

            return view('admin.employees.new', [
                'group_code'                => $group_code,
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'habitates'                 => DB::table('cities')                      ->get(),
                'degrees'                   => DB::table('degrees')                     ->get(),
                'study_fields'              => DB::table('study_fields')                ->get(),
                'job_fields'                => DB::table('job_fields')                  ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'oldInputs'                 => $request->all(),
                'months'                    => config('constants.months'),
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
                    'phone'                 => $request->input('phone'),
                    'created_at'            => time()[0],
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/employee-new/' . $unitId);
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

}