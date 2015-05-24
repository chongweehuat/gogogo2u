<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('head_admin')
<body data-target=".navbar-fixed-top" onLoad="initialize()">
	@include('navigation_admin')

<!--HTML Section for Screens larger than 980px-->
   <div class="container-fixed content_area web_view hidden-xs hidden-sm">
		<div class="perfect_layout clearfix">			
			<div class="ml-large mr-large">
				<div class="container-fluid">
					@include('flash::message')
				</div>
				@yield('content')
			</div>			
		</div>   
        <div class="footer clearfix">
        	<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            	@include('contactus')
            </div>
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            	@include('popularlinks')
            </div>
            <div class="col-lg-4 col-md-4 col-sm-2 col-xs-12 text-right">
			@include('selectlanguage')
            </div>
        </div>
        @include('footstrip')
   </div>
<!--HTML Section for Screens larger than 980px-->

<!--HTML Section for Screens larger than 320px-->
    <div class="container-fixed content_area mobile_view visible-sm visible-xs">
		<div class="container-fluid">
				@include('flash::message')
		</div>
		<div class="perfect_layout clearfix">
			@yield('content')
		</div>   
        <div class="footer clearfix">
        	<div class="col-sm-12 col-xs-12">
            	@include('contactus')
            </div>			

            <div class="col-sm-12 col-xs-12">
            	@include('popularlinks')
            </div>
            <div class="col-sm-12 col-xs-12 mt-large">
       	    	@include('selectlanguage')
            </div>
        </div>
		@include('footstrip')
        
   </div>
<!--HTML Section for Screens smaller than 980px-->

<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/jquery.easing.min.js"></script>
    <script>
    	$( document ).ready(function() {
			var heights = $(".same_height").map(function() {
				return $(this).height();
			}).get(),
		
			maxHeight = Math.max.apply(null, heights);
		
			$(".same_height").height(maxHeight);
		
			
		});
    </script>

	<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	</script>

	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
   {{ Rapyd::scripts() }}
	
</body>

</html>