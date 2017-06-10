<html>
<head>
    <title></title>
</head>
<body>
<h2 dir="rtl" style="text-align: center;"><img alt="" width="250" src="{{ asset('img/logo-big.png') }}" /></h2>
<h2 dir="rtl" style="text-align: center;">سامانه اشتغال سازمان منطقه آزاد انزلی</h2>

<h3 dir="rtl" style="text-align: center;">مشخصات شاغل</h3>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 30%; height: 45px;">جنسیت&nbsp;:&nbsp;{{$gender[$info->gender]}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">نام خانوادگی&nbsp;:&nbsp;{{$info->last_name}}</td>
            <td dir="rtl" style="width: 30%; height: 45px;">نام&nbsp;:&nbsp;{{$info->first_name}}</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">کد ملی&nbsp;:&nbsp;{{$info->id_number}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">نام پدر&nbsp;:&nbsp;{{$info->father_name}}</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">تاریخ تولد&nbsp;:&nbsp;{{preg_replace('/-/', '/', $info->birth_date)}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">محل تولد&nbsp;:&nbsp;{{$info->birth_place}}</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">محل سکونت&nbsp;:&nbsp;{{$habitate[$info->habitate]}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">مدت سکونت&nbsp;:&nbsp;{{$info->habitate_years}} سال</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="height: 45px;">آدرس دقیق محل سکونت&nbsp;:&nbsp;{{$info->address}}</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">وضعیت تاهل&nbsp;:&nbsp;{{$marrige[$info->marrige]}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">تعداد افراد تحت تکفل&nbsp;:&nbsp;{{$info->dependents}} نفر</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">رشته تحصیلی&nbsp;:&nbsp;{{$field[$info->field]}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">مدرک تحصیلی&nbsp;:&nbsp;{{$degree[$info->degree]}}</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="width: 60%; height: 45px;">عنوان شغلی&nbsp;:&nbsp;{{$job[$info->job]}}</td>
            <td dir="rtl" style="width: 40%; height: 45px;">مدت سابقه کار&nbsp;:&nbsp;{{$info->experience}} ماه</td>
        </tr>
    </tbody>
</table>

<table align="center" border="0" style="width:80%;">
    <tbody>
        <tr>
            <td dir="rtl" style="height: 45px;">کارگاه&nbsp;:&nbsp;{{$unitTitle}}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
