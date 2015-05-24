@extends('page')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Dashboard</div>

				<div class="panel-body">
				Welcome {{ Auth::user()->name }}!<br><br>
					You are logged in!
					<br><br>
					<a href=/dashboard/album/>Manage Album</a>
					<br><br>
					<a href=/dashboard/business/>Manage Business</a>
					<br><br>
					@if(Auth::user()->id==1)
						<a href=/admin/>Admin Menu</a>
						<br><br>
					@endif
					<a href="{{ url('/auth/logout') }}">Logout</a>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				@foreach(['facebook','google'] as $providerName)
				<div class="col-sm-6">
					<h3>{{ ucwords($providerName) }}</h3>
					Status:
					@if($currentUser->providerConnected($providerName))
						Connected <a href="{{ url('provider/disconnect/' . $providerName) }}">Disconnect</a>
					@else
						Not connected <a href="{{ url('provider/login/' . $providerName) }}">Connect</a>
					@endif
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
