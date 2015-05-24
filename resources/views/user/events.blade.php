<div class="form-group">
	{{App\Event::manage()}}
	<table width=90%>
	<tr>
	<td class="panel-heading">Date Start</td>
	<td class="panel-heading">Date End</td>
	<td class="panel-heading">Title</td>
	<td class="panel-heading">Updated At</td>
	<td class="panel-heading">Created At</td>
	</tr>
	@foreach(App\Event::activelist() as $b)
		<tr>
		<td>{{$b->date_start}}</td>
		<td>{{$b->date_end}}</td>
		<td>{{$b->title}}</td> 
		<td>{{$b->updated_at}}</td> 
		<td><a href="/dashboard/manageevent/?s=basic&ev={{$b->id}}">{{$b->created_at}}</a></td>
		</tr>
	@endforeach
	</table>
</div>