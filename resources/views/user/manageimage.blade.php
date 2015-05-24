@extends('page')
@section('content')
<div style="text-align:center;">
<h1>Manage Image</h1>
<a href="/dashboard/uploadimages/?album_id={{$tlist['id']}}">Back To Album</a><br><br>
{!!$tlist['html']!!}
</div>
@endsection