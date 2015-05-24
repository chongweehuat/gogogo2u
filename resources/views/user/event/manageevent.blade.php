@extends('page')

@section('content')
<center>
<table>
<tr>
<td>
<span style="font-size:200%;">Setup <a href="/dashboard/managebusiness/?s=events">Event</a></span>
</td>
<td style="padding-left:20px;">
@include('selectlanguage')
</td>
</tr>
</table>
<h4>{!!$event['section']!!}
</h4>
<span>
{{App\Business::get('mainpages.title')}} 
@if(App\Business_code::code())
<a href="http://bizinfo2u.com/{{App\Business_code::code()}}" target=_blank>Preview</a>
<br><a href="/dashboard/managebusiness">Back to Business Setup</a>
@endif
</span>
<div class="">
@include('user.event.'.$event['s'])
</div>
</center>
@endsection