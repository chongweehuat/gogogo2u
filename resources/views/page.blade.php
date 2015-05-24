<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('head')

<body data-target=".navbar-fixed-top">
	@include('navigation')

@if(screen_size('r')>1.7)
	@include('page.page980')
@else
	@include('page.page320')
@endif	

<!-- jQuery -->
	<script src="/js/jquery.min.js"></script> 
    <script src="http://malsup.github.com/jquery.form.js"></script> 

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>

    <script src="/js/jquery.easing.min.js"></script>
	
    <script>
		$( window ).resize(function() {
			detectscreen();
			location.reaload();
		});

		detectscreen();

    	$( document ).ready(function() {
			var heights = $(".same_height").map(function() {
				return $(this).height();
			}).get(),
		
			maxHeight = Math.max.apply(null, heights);
		
			$(".same_height").height(maxHeight);															
		});

		function detectscreen(){
			screenwidth=$(window).width();
			screenheight=$(window).height();
			if(screenwidth!={{screen_size('w')}} || screenheight!={{screen_size('h')}}){
				$.get("/api/checkscreen?sw="+screenwidth+"&sh="+screenheight, function( data ){
					location.reload();
				});
			}
		}
    </script>

	@yield('script')
    
</body>

</html>