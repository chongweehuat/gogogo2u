<div class="form-group">
	
	<div style="height:20px;"><div id="updateMessage"></div></div>
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 	
		{!!Form::label('name', 'Name', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.name]', App\Business::get('events.name'), array('id'=>'name','class'=>'form-control','placeholder'=>'Enter Name'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm2','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('jobtitle', 'Job Title', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.jobtitle]', App\Business::get('events.jobtitle'), array('id'=>'jobtitle','class'=>'form-control','placeholder'=>'Enter Job Title'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('hpno', 'HP No.', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.hpno]', App\Business::get('events.hpno'), array('id'=>'hpno','class'=>'form-control','placeholder'=>'Enter HP No.'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm4','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('telno', 'Tel. No.', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.telno]', App\Business::get('events.telno'), array('id'=>'telno','class'=>'form-control','placeholder'=>'Enter Tel. No.'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm5','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('email', 'Email', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::email('fn[events.email]', App\Business::get('events.email'), array('id'=>'email','class'=>'form-control','placeholder'=>'Enter Email'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm6','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('wechat_url', 'Wechat URL', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::email('fn[events.wechat_url]', App\Business::get('events.wechat_url'), array('id'=>'wechat_url','class'=>'form-control','placeholder'=>'Enter Wechat URL'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm7','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('wechat_qrcode', 'Wechat QR Code', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">
			{!! App\Image::select('events') !!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div id='renderimage'></div>

	
	
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
	
     $('body').delegate('#name','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });
	 
	 $('body').delegate('#jobtitle','change', function(){
         $('#bizForm2').ajaxForm(options).submit();
     });

	 $('body').delegate('#hpno','change', function(){
         $('#bizForm3').ajaxForm(options).submit();
     });

	 $('body').delegate('#telno','change', function(){
         $('#bizForm4').ajaxForm(options).submit();
     });

	 $('body').delegate('#email','change', function(){
         $('#bizForm5').ajaxForm(options).submit();
     });

	 $('body').delegate('#wechat_url','change', function(){
         $('#bizForm6').ajaxForm(options).submit();
     });

	 $('body').delegate('#wechat_image_id','change', function(){
         $('#bizForm7').ajaxForm(options).submit();
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
		$("#renderimage").html('');
		showLatest();
    }
}
function showLatest(){
	$.get( "/dashboard/business/eventwechat", function( data ){
		$("#renderimage").html(data);	
	});	
}
</script> 
@endsection