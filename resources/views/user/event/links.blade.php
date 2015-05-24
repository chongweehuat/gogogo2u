<div class="form-group">
	
	<div style="height:20px;"><div id="updateMessage"></div></div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('website', 'Website', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.website]', App\Business::get('events.website'), array('id'=>'website','class'=>'form-control','placeholder'=>'Enter Website URL'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm2','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('facebook', 'Facebook', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.facebook]', App\Business::get('events.facebook'), array('id'=>'facebook','class'=>'form-control','placeholder'=>'Enter Facebook Business Page URL'))!!}
		</div>
		{!!Form::close()!!}
	</div>	
	
</div>

@section('script')
<script>
$(document).ready(function() {
    var options = {
				beforeSubmit:	showRequest,
				success:		showResponse,
				dataType:		'json' 
        };
	
     $('body').delegate('#website','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });
	 
	 $('body').delegate('#facebook','change', function(){
         $('#bizForm2').ajaxForm(options).submit();
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
    }
}
</script> 
@endsection