@extends('admin.admin')

@section('content')
<center><h1>{{$title}}</h1></center>
    <p>
		<center>{!! $filter !!}</center>
        {!! $data !!}
        
        
    </p>
@endsection