<div >

	<div style="height:20px;"><div id="updateMessage"></div></div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm1','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('code', 'Code', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[table.code]', App\Business::get('table.code'), array('id'=>'code','class'=>'form-control','placeholder'=>'Enter Code'))!!}
		</div>
		Your business page URL => http://bizinfo2u.com/<span id=urlcode></span>		
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm2','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('domain', 'Domain', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::text('fn[table.domain]', App\Business::get('table.domain'), array('id'=>'domain','class'=>'form-control','placeholder'=>'Enter Domain Name'))!!}
		</div>
		Your business page URL => http://<span id=domainname></span>
		{!!Form::close()!!}
	</div>		
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm3','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('lg', 'Default', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!! Form::select('fn[business.language_id]',App\Language::activeid(), App\Business::get('business.language_id'),array('id'=>'defaultlanguage','class'=>'form-control')) !!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm4','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('chainstore', 'Chain Store Code', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10" id="bcs">
		{!! App\Business_chainstore::select() !!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>	
	
	<div class="form-group">
		{!!Form::open(['id'=>'bizForm5','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('taglabel', 'Tag', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!!Form::select('fn[table.businesstag][]',App\Business::get('table.bselectedtag'),App\Business::get('table.businesstag'), array('id'=>'taglist','class'=>'form-control','multiple'))!!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>

	<div class="form-group">
		{!!Form::open(['id'=>'bizForm6','url'=>'/dashboard/updatebusiness'])!!} 
		{!!Form::label('template', 'Template', array('class'=>'col-md-2 control-label'))!!}
		<div class="col-md-10">	
		{!! Form::select('fn[business.template_id]',App\Template::listid(), App\Business::get('business.template_id'),array('id'=>'defaulttemplate','class'=>'form-control')) !!}
		</div>
		&nbsp;
		{!!Form::close()!!}
	</div>
	
</div>

@section('link')
<link href="/select2/css/select2.min.css" type="text/css" rel="stylesheet" />
@endsection

@section('script')
<script type="text/javascript" src="/select2/js/select2.full.js"></script>
<script>
$(document).ready(function() {
    var options = {
				beforeSubmit:	showRequest,
				success:		showResponse,
				dataType:		'json' 
        };

	 showLatest();
	
     $('body').delegate('#code','change', function(){
         $('#bizForm1').ajaxForm(options).submit();
     });
	 
	 $('body').delegate('#domain','change', function(){
         $('#bizForm2').ajaxForm(options).submit();
     });

	 $('body').delegate('#defaultlanguage','change', function(){
         $('#bizForm3').ajaxForm(options).submit();
     });

	 $('body').delegate('#chainstorecode','change', function(){
         $('#bizForm4').ajaxForm(options).submit();
     });

	 $('body').delegate('#taglist','change', function(){
         $('#bizForm5').ajaxForm(options).submit();
     });

	 $('body').delegate('#defaulttemplate','change', function(){
         $('#bizForm6').ajaxForm(options).submit();
     });
	 
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
		showLatest();
		$.get( "/dashboard/business/bcs", function( data ){
			$("#bcs").html(data);	
		});
    }
}
function showLatest(){
	$.get( "/dashboard/business/code", function( data ){
		$("#urlcode").html(data);	
	});
	$.get( "/dashboard/business/domainname", function( data ){
		$("#domainname").html(data);	
	});
}
function updatecode(){	
	var options = {
				beforeSubmit:	showRequest,
				success:		showResponse,
				dataType:		'json' 
        };
	$("#chainstorecode").val($("#selectbcs").val());
	$('#bizForm').ajaxForm(options).submit();		
}
</script> 
@endsection