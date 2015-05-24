<div class="form-group">
@IF(Input::get('sp'))
@include('user.subpageedit')
@ELSE
@include('user.subpageslist')
@ENDIF	
</div>