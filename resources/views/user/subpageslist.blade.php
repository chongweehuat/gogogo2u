	{{App\Subpage::manage()}}
	<table width=90%>
	<tr>
	<td class="panel-heading">Page Type</td>
	<td class="panel-heading">Title</td>
	<td class="panel-heading">Updated At</td>
	<td class="panel-heading">Created At</td>
	</tr>
	@foreach(App\Subpage::activelist() as $b)
		<tr>
		<td>{{$b->pagetype}}</td>
		<td>{{$b->title}}</td> 
		<td>{{$b->updated_at}}</td> 
		<td><a href="/dashboard/managebusiness/?s=subpages&sp={{$b->id}}">{{$b->created_at}}</a></td>
		</tr>
	@endforeach
	</table>
