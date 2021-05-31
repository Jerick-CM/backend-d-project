@extends('layouts.applayout')
@section('content')
	
	<h1>Create Page</h1>

	{!! Form::open(['action' => 'PageController@store','method'=>'POST']) !!}
		<div class="form-group">
			{{Form::label('title', 'Menu')}}
			{{Form::text('name', '',['class' => 'form-control','placeholder' => 'Menu'])}}
		</div>	
		<div class="form-group">
			{{Form::label('title', 'Title')}}
			{{Form::text('title', '',['class' => 'form-control','placeholder' => 'Title'])}}
		</div>		
	
		<div class="form-group">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('content', '',['id'=> 'article-ckeditor', 'class' => 'form-control','placeholder' => 'Body Text'])}}
		</div>
		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}
	{!! Form::close() !!}

	<script type="text/javascript">
		$('.pagecms_link').addClass('text-white').addClass('font-weight-bold');
	</script>

@endsection
