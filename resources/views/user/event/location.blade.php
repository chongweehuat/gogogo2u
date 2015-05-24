<div class="form-group">
	 

	<div style="height:20px;"><div id="updateMessage"></div></div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!}
		{!!Form::label('address', 'Address', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.address]', App\Business::get('events.address'), array('id'=>'address','class'=>'form-control','placeholder'=>'Enter Address'))!!}
		</div>
		{!!Form::close()!!}
		&nbsp;
	</div>
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!}
		{!!Form::label('gpslabel', 'GPS', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">
		{!!Form::text('fn[eventgps.latlng]', App\Business::get('eventgps.latlng'), array('id'=>'gpsinput', 'class'=>'form-control','placeholder'=>'Enter GPS Coordinate'))!!}
		</div>
		{!!Form::close()!!}
		&nbsp;
	</div>

	<div class="form-group">
		{!!Form::label('gpsaddress', 'GPS Address', array('class'=>'col-md-2 control-label'))!!}
		<div id='rendergps' class="col-md-10"></div>	
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

	 showLatest();

     $('body').delegate('#address','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });
	 
	 $('body').delegate('#country_id','change', function(){
         $('#bizForm2').ajaxForm(options).submit();
     });

	 $('body').delegate('#gpsinput','change', function(){
         $('#bizForm3').ajaxForm(options).submit();
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
		$("#rendergps").html('');
		$.get("/dashboard/business/eventgpslatlng", function( data ){
			$("#gpsinput").val(data);
		});
		showLatest();
    }
}
function showLatest(){
	$.get( "/dashboard/business/gps", function( data ){
		$("#rendergps").html(data);	
	});	
}
</script> 
@endsection