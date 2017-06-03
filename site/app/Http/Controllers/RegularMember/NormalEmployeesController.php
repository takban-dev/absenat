<?php

namespace App\Http\Controllers\RegularMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
            ->where('employees.user', '=', Auth::user()->name)
            ->get();
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
            ]);
    }

    public function editPost(Request $request, $id){
        $group_code = Auth::user()->group_code;
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
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            DB::table('employees')->where(['id' => $id])->update(
                [
                    'user'                  => $username,
                    'unit_id'               => $request->input('unit_id'),
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
                    'field'                 => $request->input('field'),
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
        $employee = get_object_vars(DB::table('employees')->where('id', '=', $id)->first());

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
        return view('normal.employees.new', [
            'unitId'                    => $unitId,
            'group_code'                => $group_code,
            'username'                  => Auth::user()->name,
            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'habitates'                 => DB::table('cities')                      ->get(),
            'degrees'                   => DB::table('degrees')                     ->get(),
            'study_fields'              => DB::table('study_fields')                ->get(),
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
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'marriges'                  => DB::table('merrige_types')               ->get(),
                'oldInputs'                 => $request->all(),
                'months'                    => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = Auth::user()->name;
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            $id = DB::table('employees')->insertGetId(
                [
                    'user'                  => $username,
                    'unit_id'               => $request->input('unit_id'),
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
                    'field'                 => $request->input('field'),
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
        $messages = [
            'first_name.*'                => 'لطفا نام خود را وارد کنید',
            'last_name.*'                 => 'لطفا نام خانوادگی خود را وارد کنید',
            
            'gender.*'                    => 'جنسیت وارد نشده است',
            'id_number.*'                 => 'کد ملی شاغل وارد نشده است',
            'father_name.*'               => 'نام ‍پدر وارد نشده است',
            
            'birth_date_day.*'            => 'روز تولد انتخاب نشده است',
            'birth_date_month.*'          => 'ماه تولد انتخاب نشده است',
            'birth_date_year.*'           => 'سال تولد انتخاب نشده است',

            'birth_place.*'               => 'محل تولد انتخاب نشده است',

            'habitate.*'                  => 'محل سکونت را انتخاب کنید',
            'habitate_years.*'            => 'مدت سال های سکونت را انتخاب کنید',

            'degree.*'                    => 'مدرک تحصیلی انتخاب نشده است',
            'field.*'                     => 'رشته تحصیلی انتخاب نشده است',

            'marrige.*'                   => 'خطا در وضعیت تاهل',
            'dependents.*'                => 'تعداد افراد تحت تکفل نامعتبر است',

            'experience.*'                => 'تعداد ماه های سابقه کاری را وارد کنید',
            'address.*'                   => 'آدرس را وارد کنید',
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
            'field'                     => 'required|numeric',

            'marrige'                   => 'required|numeric',
            'dependents'                => 'required|numeric',

            'experience'                => 'required|numeric',
            'address'                   => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

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
}