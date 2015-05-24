<!doctype html>
<html lang="{{App::getLocale()}}">
@include('head')

<body data-target=".navbar-fixed-top">
	@include('navigation')
    
@if(screen_size('r')>1.7)
	@include('go32u980')
@else
	@include('go32u320')
@endif

    <!-- jQuery -->
	<script src="/js/jquery.min.js"></script>

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

	@if(Session::has('gpsautodetect'))
	<script src="/js/geolocation.js"></script>
	<script>
		$(document).ready(function()
		{			
			$.geolocation(function (lat, lng) {							
				$.ajax({url: "/gps/?gpsaddr="+lat+","+lng, success: function(result){
					window.location.reload(true);
				}});
			});			

		}, function (error_codes) {
			alert('GPS error '+error_codes);
		});
	</script>
	@endif
    
</body>

</html>