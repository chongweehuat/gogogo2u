<!--HTML Section for Screens larger than 980px-->
   <div id="d980" class="container-fixed content_area web_view">
		<div class="perfect_layout clearfix">
			<div class="col-lg-8 col-md-8 slider_section">			
			@yield('content')
			</div>
            <div class="col-lg-4 col-md-4 search_section">
				
            	<div class="same_height search_area_box">
					@include('flash::message')
               		@include('searcharea')
                </div>
                <div class="widgets widget_gps">
            		@include('gps')
                </div>
				<div class="">
					<div class="col-sm-12 col-xs-12 widgets widget_business">
						@include('addbusiness')
					</div>
					<div class="col-sm-12 col-xs-12 widgets widget_scan">
						@include('qrcode')
					</div>
				</div>
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
