<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container-fixed">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                <a class="#" href="/"><img src="/images/logo.jpg" width="100" alt=""></a>
          </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
                <div class="dropdown pull-right">
                  <span class=""><img src="/images/dummy_fb_like_share_btns.png" width="105" alt=""></span>
				  @if (Auth::guest())
					  <a href="/auth/login">
					  <button class="btn btn-default login_btn" type="button" aria-expanded="true">
							<img src="/images/login_icon.png" align="absmiddle" alt="" height="14"> {{trns('general.login')}} <span class="caret"></span>
					  </button>
					  </a>
				  @else
					<a href="/admin/menu">
					  <button class="btn btn-default login_btn" type="button" aria-expanded="true">
							<img src="/images/login_icon.png" align="absmiddle" alt="" height="14"> {{trns('general.admin')}} <span class="caret"></span>
					  </button>
					  </a>
				  @endif					 				
              </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>