{!! Form::open(array('method'=>'get')) !!}
{!! Form::select('lg',App\Language::activelist(), App::getLocale(),array('class'=>'languageform','onchange'=>'submit()')) !!}
{!! Form::close() !!}