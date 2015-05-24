<!--HTML Section for Screens larger than 320px-->
    <div class="container-fixed content_area mobile_view">
		<div class="perfect_layout clearfix">
        	<div class="col-sm-12 col-xs-12 search_section">
				<div class="search_area_box">
            	@include('searcharea')
				</div>
                <div class="widgets widget_gps">
					@include('gps')
                </div>
                <div class="col-sm-12 col-xs-12 widgets widget_business">
                        @include('addbusiness')
                </div>
                <div class="col-sm-12 col-xs-12 widgets widget_scan">
                        @include('qrcode')
                </div>
            </div>
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
<!--HTML Section for Screens smaller than 320px-->