<div class="search_area">
	<div class="input-group">

		{!! Form::open(array('url'=>'search','method'=>'post', 'id'=>'search')) !!}
		<div class="" style="color:#ffffff;font-size:14px;">
			{!! App\Tag::searchmode() !!}						
		</div>
		<div style="width:70%;">			
			<span class="input-group-btn">
				<input type=text name=q value="{{Session::get('search.q')}}" placeholder="{{trns('general.entertag')}}" size=30 class='form-control textbox'>
				<input type="submit" name=searchtype value="{{trns('general.go')}}" class="btn btn-orange">						
				<input type="submit" name=searchtype value="{{trns('general.listall')}}" class="btn btn-green" style="margin-left:20px;">
			</span>
		</div>
		{!! Form::close()!!}
		{!! Form::open(array('url'=>'search','method'=>'post', 'id'=>'category')) !!}
		<div>
			@include('hashtags')	
			<br>
			{!! App\Category::categorylist() !!}
			{!! App\Category::subcategorylist() !!}												
		</div>
		
	
		{!! Form::close()!!}

	</div>
</div>