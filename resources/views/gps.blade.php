<div class="widget_content" id='gps'>
  <div class="">
	<div class="input-group">
		{!! Form::open(array('url'=>'gps','method'=>'POST', 'id'=>'getgps')) !!}
		<div style="width:55%;">
			<span class="input-group-btn">				
				<input class="form-control textbox" id="gpsaddr" placeholder="{{trns('general.addressorgps')}}" size="36" name="gpsaddr" type="text" value="">
				<button type="button" class="btn btn-orange" id="gpslocation" onClick=submit()>{{trns('general.getlocation')}}</button>
				<a href="/gps"><button type="button" class="btn btn-green">{{trns('general.autodetect')}}</button></a>
			</span>
		</div>
		{!! Form::close()!!}
	</div><!-- /input-group -->
	<div class="result mt-medium clearfix">
		<div class="pull-left icon_gps">
			<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
		</div>
		<div class="pull-left mt-tiny map_inputs">
		<h5 style="height: 38px;">
			<strong>GPS</strong>
			
			{{Session::get('gps.lat')}} , {{Session::get('gps.lng')}} | {!!App\Gps::googlemap(Session::get('gps.lat'),Session::get('gps.lng'))!!} | {!!App\Gps::waze(Session::get('gps.lat'),Session::get('gps.lng'))!!}
			
		</h5>
				
		<h5 style="height: 36px;">
			{{Session::get('gps.gps_address')}}	
		</h5>
	
		</div>
	</div>		
  </div>
</div>