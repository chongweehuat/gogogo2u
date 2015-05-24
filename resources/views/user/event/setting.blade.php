<div >

	<div style="height:20px;"><div id="updateMessage"></div></div>
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('datestart', 'Date Start', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		<input type="text" id="date_start" class="form-control" placeholder="Enter Date Start" name="fn[events.date_start]" value="{{App\Business::get('events.date_start')}}">	
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm2','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('dateend', 'Date End', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">
		<input type="text" id="date_end" class="form-control" placeholder="Enter Date End" name="fn[events.date_end]" value="{{App\Business::get('events.date_end')}}">	
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('taglabel', 'Tag', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::select('fn[table.eventtag][]',App\Business::get('table.eselectedtag'),App\Business::get('table.eventtag'), array('id'=>'taglist','class'=>'form-control','multiple'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>	
	
</div>

@section('link')
<link rel="stylesheet" href="/css/jquery.datetimepicker.css" />
<link href="/select2/css/select2.min.css" type="text/css" rel="stylesheet" />
@endsection

@section('script')
<script type="text/javascript" src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/select2/js/select2.full.js"></script>
<script>
$(document).ready(function() {
    var options = {
				beforeSubmit:	showRequest,
				success:		showResponse,
				dataType:		'json' 
        };
	    
	 $('body').delegate('#date_start','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });

	 $('body').delegate('#date_end','change', function(){
         $('#bizForm2').ajaxForm(options).submit();
     });
	 
	 $('body').delegate('#taglist','change', function(){
         $('#bizForm3').ajaxForm(options).submit();
     });
	 	 
	 $('#date_start').datetimepicker({format:'Y-m-d H:i:s',step:5,lang:'ch'});
	 $('#date_end').datetimepicker({format:'Y-m-d H:i:s',step:5});

	 $("#taglist").select2({
		ajax: {
        dataType: "json",
		delay: 250,
        url: "/api/selecttag",
        results: function (data) {
				return {results: data};
			}
		},		  
		placeholder: 'Chose a Tag',
		minimumInputLength: 1,
		maximumSelectionLength: 3,
		tags: true
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