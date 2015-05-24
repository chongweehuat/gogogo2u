<div class="widget_content">
	<div class="QR_code"><a href="https://chart.googleapis.com/chart?cht=qr&chs=300&chl={{Request::url()}}" target=_blank><img src="https://chart.googleapis.com/chart?cht=qr&chs=300&chl={{Request::url()}}" width="51" alt=""></a></div>
	<h4><strong>{{trns('general.scanme')}}</strong></h4>
	<h6 class="mt-small"><a href="{{Request::url()}}">{{Request::url()}}</a></h6>
	<div class="mt-small">
		<h6><a href="#">{{trns('general.downloadqr')}}</a></h6>
		<h5 class=""><strong>{{trns('general.cor')}}</strong></h5>
		<h6 class="mt-tiny">
			{{trns('general.scanwechat')}}
		</h6>
	</div>
</div>