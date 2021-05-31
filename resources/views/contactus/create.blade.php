@extends('layouts.appfaqcat')



@section('content')
	
	<h1>Create Faq category</h1>

	{!! Form::open(['action' => 'ContactUsController@store','method'=>'POST']) !!}
		<div class="form-group">

			{{Form::label('Category', 'Category')}}

			{{Form::text('value','',['class' => 'form-control','placeholder' => 'text'])}}

		</div>
		<br>
		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}

	{!! Form::close() !!}

@endsection
