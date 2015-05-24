@extends('admin.admin')

@section('content')
<center>
<a href=/home>Dashboard</a>
<h1>Admin Menu</h1>
<h3><a href="/admin/webpage/">Webpage</a></h3>
<h3><a href="/admin/tags/filter">Tags</a></h3>
<h3><a href="/admin/translation/filter">Translation</a></h3>
<h3><a href="/setup/locales">Get Supported Locales</a></h3>
<h3><a href="/setup/translate/">Setup Translation</a></h3>
<h3><a href="/setup/genlocales/">Generate Locales</a></h3>
</center>
    
@endsection