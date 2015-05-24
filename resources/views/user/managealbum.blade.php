@extends('page')
@section('content')
<div style="text-align:center;">
<h1>Album List</h1>
@if(Session::has('business.id') and Session::get('business.id'))
<a href=/dashboard/managebusiness/?id={{Session::get('business.id')}}&s=album><h4>Setup Business Page</h4></a>
@endif
{!!$tlist!!}
</div>
@endsection