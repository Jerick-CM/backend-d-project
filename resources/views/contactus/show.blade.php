@extends('layouts.appcontactus')

@section('content')
	<a href="/contactus" class="btn btn-success mt-2 mb-2"> Go Back</a>
	<h1>View</h1>
	
	<div>	

		<li class="list-group-item"><strong>Full Name placeholder </strong>: + {{$datum->fullname}} </li>	
		<li class="list-group-item"><strong>E-mail placeholder </strong>:+ {{$datum->email}} </li>
		<li class="list-group-item"><strong>Role </strong>: + {{$datum->role}} </li>
		<li class="list-group-item"><strong>Options </strong>: + {{$datum->type}} </li>
		<li class="list-group-item"><strong>Attachment Label </strong>: + {{$datum->attachmentlabel}} </li>

	</div>

	<hr>
	<small>Written on {{$datum->created_at}}</small>
	<hr>
	<a href="/contactus/{{$datum->id}}/edit" class="btn btn-primary">Edit</a>
	
	{!!Form::open(['action'=>['ContactUsController@destroy',$datum->id],'method' => 'POST','class'=>'pull-right'])!!}

		{{Form::hidden('_method','DELETE')}}
		{{Form::submit('Delete',['class'=>'btn btn-danger'])}}

	{!!Form::close()!!}

@endsection
