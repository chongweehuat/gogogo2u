@extends('page')

@section('content')
<center>
<table>
<tr><td>
<span style="font-size:200%;">Setup <a href="/dashboard/business/">Business</a> Page</span>
</td><td style="padding-left:20px;">
@include('selectlanguage')
</td></tr>
</table>
<h4>{!!$business['section']!!}
</h4>
<span>
{{App\Business::get('mainpages.title')}} 
@if(App\Business_code::code())
<a href="http://bizinfo2u.com/{{App\Business_code::code()}}" target=_blank>Preview</a>
@endif
</span>
<div class="">
@include('user.business.'.$business['s'])
</div>
</center>
@endsection