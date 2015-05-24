@extends('page')

@section('content')
<div style="text-align:center;">
<h2>Business List</h2>
@if(Session::has('business.id') and Session::get('business.id'))
<a href=/dashboard/managebusiness/?id={{Session::get('business.id')}}><h4>Setup Business Page</h4></a>
@endif
<center>
<table width=90%>
<tr>
<td class="panel-heading">Title</td>
<td class="panel-heading">Role</td>
<td class="panel-heading">Created At</td>
</tr>
@foreach ($business as $b)
<tr>
<td>{{$b->title}}</td> 
<td>{{$b->role}}</td>
<td><a href="/dashboard/managebusiness/?id={{$b->id}}">{{$b->created_at}}</a></td>
</tr>
@endforeach
</table>
</center>
</div>
@endsection