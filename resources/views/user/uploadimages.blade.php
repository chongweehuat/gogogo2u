@extends('page')
@section('content')
<div>
	<center>
	<h1>Manage Album</h1>
	<a href="/dashboard/album/">Back To Album List</a><br><br>
	<div id="validation-errors"></div>
	{!! Form::open(array('url'=>'/dashboard/uploadimages','method'=>'POST', 'files'=>true,'id'=>'upload')) !!}	
	Upload Images {!! Form::file('images[]', array('multiple'=>true,'id'=>'image')) !!}
	<input type=submit name=uploadimages value=Save>
		
	<div>
		
	{!!$tlist!!}
		
	</div>
	{!! Form::close()!!}
	</center>
</div>
@endsection