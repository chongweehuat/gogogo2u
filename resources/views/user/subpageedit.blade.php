<br>
<a href="?s=subpages">Back To Subpages List</a>
<div>
	<div style="height:20px;"><div id="updateMessage"></div></div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('pagetype', 'Type', array('class'=>'col-sm-2 control-label required'))!!}
		<div class="col-md-10">	
		{!! App\Subpage::selectpagetype() !!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('title', 'Title', array('class'=>'col-sm-2 control-label required'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[subpages.title]', App\Business::get('subpages.title'), array('id'=>'title','class'=>'form-control','placeholder'=>'Enter Title'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">

		{!!Form::open(['id'=>'bizForm2','url'=>'/dashboard/updatebusiness'])!!} 

	
		{!!Form::label('album', 'Album', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
			{!! App\Album::select('subpages') !!}
		</div>
		&nbsp;
		@if(App\Business::get('subpages.album_id'))
		<div id='renderimage'>
		<a href="/dashboard/uploadimages/?album_id={{App\Business::get('subpages.album_id')}}">
		<img src="{{App\Image::url(App\Album::find(App\Business::get('subpages.album_id'))->image_id)}}" style="max-width:300px;">
		</a>
		</div>
		@endif

		&nbsp;

		{!!Form::close()!!}
	</div>
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('content', 'Content', array('class'=>'col-sm-2 control-label required'))!!}
		<div class="col-md-10">	
		{!!Form::textarea('fn[subpages.body]', App\Business::get('subpages.body'), array('id'=>'subpagebody','class'=>'form-control','rows'=>14,'placeholder'=>'Enter Content'))!!}
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
	
	 $('body').delegate('#pagetype','change', function(){
         $('#bizForm').ajaxForm(options).submit();
     });	

     $('body').delegate('#title','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });

	 $('body').delegate('#album','change', function(){
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

		$.get( "/api/subpageimage", function( data ){
			$("#renderimage").html(data);	
		});
    }
}
</script>

<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
	selector: "#subpagebody",
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
						$('#subpagebody').val(ed.getContent());
						$('#bizForm3').ajaxForm(options).submit();
                  });
            }
});
</script>
@endsection