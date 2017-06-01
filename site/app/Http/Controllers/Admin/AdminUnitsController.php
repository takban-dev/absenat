<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminUnitsController extends Controller
{
    public function list(Request $request, $page=0, $size=10)
    {
        $group_code = 1;
        $units = DB::table('units')->skip($page*$size)->limit($size)->get();
        $unitCount = DB::table('units')->count();

        $pageCount = ceil($unitCount / $size);

        return view('units.list', [
            'units'         => $units, 
            'pageCount'     => $pageCount,
            'currentPage'   => $page,
            'group_code'    => $group_code,
            'pageSize'      => $size,
            'pagination'    => $this->generatePages($pageCount, $page)
            ]);
    }

    public function editPost(Request $request, $id){
        $group_code = 1;
        $validator = $this->myValidate($request);
        if($validator->fails()){
            $oldInputs = $request->all();
            $oldInputs['id'] = $id;
            

            if( isset($oldInputs['has_certificate']))
                $oldInputs['has_certificate'] = 1;
            if( isset($oldInputs['has_licence']))
                $oldInputs['has_licence'] = 1;

            return view('units.edit', [
                'group_code'                => $group_code,
                'oldInputs'                 => $oldInputs,

                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'months'                     => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = 'admin';
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            DB::table('units')->where(['id' => $id])->update(
                [
                    'user'                  => $username,
                    'title'                 => $request->input('title'),
                    'product'               => $request->input('product'),
                    'manager_title'         => $request->input('manager_title'),
                    'manager_gender'        => $request->input('manager_gender'),
                    'manager_id_number'     => $request->input('manager_id_number'),
                    'address'               => $request->input('address'),
                    'zip_code'              => $request->input('zip_code'),
                    'phone'                 => $request->input('phone'),
                    'cell_phone'            => $request->input('cell_phone'),
                    'has_certificate'       => $has_certificate ? '1': '0',
                    'certificate_id'        => $has_certificate ? $request->input('certificate_id') : '###',
                    'certificate_date'      => $has_certificate ? $request->input('certificate_date_year') . '-' . $request->input('certificate_date_month') . '-' . $request->input('certificate_date_day') : '###',
                    'certificate_type'      => $request->input('certificate_type'),
                    'has_licence'           => $has_licence ? '1' : '0',
                    'licence_id'            => $has_licence ? $request->input('licence_id') : '###',
                    'licence_date'          => $has_licence ? $request->input('licence_date_year') . '-' . $request->input('licence_date_month') . '-' . $request->input('licence_date_day') : '###',
                    'licence_source'        => $has_licence ? $request->input('licence_source') : 0,
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/unit/' . $id);
        }
    }
    public function editGet(Request $request, $id){
        $group_code = 1;
        $unit = get_object_vars(DB::table('units')->where('id', '=', $id)->first());

        if($unit['certificate_date'] != '###'){
            $certificate_date = explode('-', $unit['certificate_date']);
            $unit['certificate_date_day']   = $certificate_date[2];
            $unit['certificate_date_month'] = $certificate_date[1];
            $unit['certificate_date_year']  = $certificate_date[0];
        }

        if($unit['licence_date'] != '###'){
            $licence_date = explode('-', $unit['licence_date']);
            $unit['licence_date_day']   = $licence_date[2];
            $unit['licence_date_month'] = $licence_date[1];
            $unit['licence_date_year']  = $licence_date[0];
        }

        return view('units.edit', [
            'group_code'                => $group_code,
            'oldInputs'                 => $unit,

            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'months'                     => config('constants.months')
            ]);
    }

    public function remove(Request $request, $id){
        DB::table('units')->where('id', '=', $id)->delete();   
        return back();
    }

    public function newGet(Request $request){
        $group_code = 1;
        return view('units.new', [
            'group_code'                => $group_code,
            'genders'                   => DB::table('genders')                     ->get(),
            'certificateTypes'          => DB::table('certificate_types')           ->get(),
            'business_license_sources'  => DB::table('business_license_sources')    ->get(),
            'months'                     => config('constants.months')
            ]);
    }

    public function newPost(Request $request){
        $group_code = 1;
        $validator = $this->myValidate($request);
        if($validator->fails()){

            return view('units.new', [
                'group_code'                => $group_code,
                'genders'                   => DB::table('genders')                     ->get(),
                'certificateTypes'          => DB::table('certificate_types')           ->get(),
                'business_license_sources'  => DB::table('business_license_sources')    ->get(),
                'oldInputs'                 => $request->all(),
                'months'                     => config('constants.months')
                ])->withErrors($validator);

        }else{
            $username = 'admin';
            
            $has_certificate = $request->input('has_certificate');
            $has_licence = $request->input('has_licence');

            $id = DB::table('units')->insertGetId(
                [
                    'user'                  => $username,
                    'title'                 => $request->input('title'),
                    'product'               => $request->input('product'),
                    'manager_title'         => $request->input('manager_title'),
                    'manager_gender'        => $request->input('manager_gender'),
                    'manager_id_number'     => $request->input('manager_id_number'),
                    'address'               => $request->input('address'),
                    'zip_code'              => $request->input('zip_code'),
                    'phone'                 => $request->input('phone'),
                    'cell_phone'            => $request->input('cell_phone'),
                    'has_certificate'       => $has_certificate ? '1': '0',
                    'certificate_id'        => $has_certificate ? $request->input('certificate_id') : '###',
                    'certificate_date'      => $has_certificate ? $request->input('certificate_date_year') . '-' . $request->input('certificate_date_month') . '-' . $request->input('certificate_date_day') : '###',
                    'certificate_type'      => $request->input('certificate_type'),
                    'has_licence'           => $has_licence ? '1' : '0',
                    'licence_id'            => $has_licence ? $request->input('licence_id') : '###',
                    'licence_date'          => $has_licence ? $request->input('licence_date_year') . '-' . $request->input('licence_date_month') . '-' . $request->input('licence_date_day') : '###',
                    'licence_source'        => $has_licence ? $request->input('licence_source') : 0,
                    'created_at'            => time()[0],
                    'updated_at'            => time()[0]
                ]
            );

            return redirect('admin/unit/' . $id);
        }
    }
    public function myValidate($request){
        Validator::extend('checkIf', function ($attribute, $value, $parameters, $validator) {
            return !(in_array($parameters[0], array('on', 'true', 1, '1')));
        });
        $messages = [
            'title.*'                     => 'خطا در فیلد عنوان کارگاه',
            'product.*'                   => 'خطا در فیلد نوع فعالیت یا محصول',

            'manager_title.*'             => 'خطا در نام مدیریت کارگاه',
            'manager_gender.*'           => 'خطا در جنسیت مدیر کارگاه',
            'manager_id_number.*'         => 'خطا در کد ملی مدیریت کارگاه',

            'address.*'                   => 'خطا در آدرس',
            'zip_code.*'                  => 'خطا در کد پستی',

            'phone.*'                     => 'خطا در شماره تلفن همراه',
            'cell_phone.*'                => 'خطا در شماره تماس ثابت',

            'certificate_id.*'            => 'خطا در شماره مجوز',
            'certificate_type.*'          => 'نوع مجوز نامعتبر است',

            'licence_id.*'                => 'پروانه کسب نامعتبر',
            'licence_source.*'            => 'مربج پروانه کسب نامعتبر است',
        ];

        $rules = [
            'title'                     => 'required|min:5',
            'product'                   => 'required|min:5',

            'manager_title'             => 'required|min:5',
            'manager_gender'           => 'required|in:2,3',
            'manager_id_number'         => 'required|size:10',

            'address'                   => 'required|min:5',
            'zip_code'                  => 'required|size:10',

            'phone'                     => 'required|size:11',
            'cell_phone'                => 'required|size:11',

            'certificate_id'            => 'required_with:has_certificate',

            'certificate_date_day'      => 'required|numeric|min:1|max:30',
            'certificate_date_month'    => 'required|numeric|min:1|max:12',
            'certificate_date_year'     => 'required|numeric|min:1380|max:1400',

            'licence_id'                => 'required_with:has_licence',

            'licence_date_day'          => 'required|numeric|min:1|max:30',
            'licence_date_month'        => 'required|numeric|min:1|max:12',
            'licence_date_year'         => 'required|numeric|min:1380|max:1400',
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