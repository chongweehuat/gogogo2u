<div class="form-group">
	<a href="/dashboard/album/"><h5>Manage Album</h5></a>
	{!!Form::open(['id'=>'bizForm','url'=>'/dashboard/updatebusiness'])!!} 

	<div style="height:20px;"><div id="updateMessage"></div></div>
	<div class="form-group">
		{!!Form::label('album', 'Album', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
			{!! App\Album::select() !!}
		</div>
		&nbsp;
		@if(App\Business::get('mainpages.album_id'))
		<div id='renderimage'>
		<a href="/dashboard/uploadimages/?album_id={{App\Business::get('mainpages.album_id')}}">
		<img src="{{App\Image::url(App\Album::find(App\Business::get('mainpages.album_id'))->image_id)}}" style="max-width:300px;">
		</a>
		</div>
		@endif

	</div>

	{!!Form::close()!!}
	
</div>

@section('script')
<script>
$(document).ready(function() {
    var options = {
				beforeSubmit:	showRequest,
				success:		showResponse,
				dataType:		'json' 
        };
	
     $('body').delegate('#album','change', function(){
         $('#bizForm').ajaxForm(options).submit();
     });	 
});
function showRequest(formData, jqForm, options) { 
	$("#updateMessage").html('');		
	$("#updateMessage").css("display", "block");
	return true; 
} 

function showResponse(response, statusText, xhr, $form)  { 	
    if(response.success == false)
    {
		$("#updateMessage").html('<span style="color:red;font-size:120%;">'+response.error+'</span>');
    } else {
		$("#updateMessage").html('updated');
		$("#updateMessage").delay(5000).fadeOut('slow');
		location.reload();
    }
}
</script> 
@endsection