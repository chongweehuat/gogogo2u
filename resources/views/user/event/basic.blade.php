<div>
	<div style="height:20px;"><div id="updateMessage"></div></div>
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('title', 'Title', array('class'=>'col-sm-2 control-label required'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[events.title]', App\Business::get('events.title'), array('id'=>'title','class'=>'form-control','placeholder'=>'Enter Title'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>	
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('content', 'Content', array('class'=>'col-sm-2 control-label required'))!!}
		<div class="col-md-10">	
		{!!Form::textarea('fn[events.body]', App\Business::get('events.body'), array('id'=>'content','class'=>'form-control','rows'=>14,'placeholder'=>'Enter Content'))!!}
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
	
     $('body').delegate('#title','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
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

<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
	selector: "#content",
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	
	setup : function(ed) {
                  ed.on('change', function(e) {
						var options = {
								beforeSubmit:	showRequest,
								success:		showResponse,
								dataType:		'json' 
						};
						$('#content').val(ed.getContent());
						$('#bizForm3').ajaxForm(options).submit();
                  });
            }
});
</script>
@endsection