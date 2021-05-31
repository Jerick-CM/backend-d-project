@extends('layouts.applayout')

@section('content')
	
		<a href="/page/" class="btn btn-success mt-2 mb-2"> Go Back</a>

	<h1>Edit Page</h1>

	{!! Form::open(['action' => ['PageController@update', $datum->id ],'method'=>'POST']) !!}


		<div class="form-group">

			{{Form::label('Menu', 'Menu')}}
			{{Form::text('name', $datum->name,['class' => 'form-control','placeholder' => 'Title'])}}
			
		</div>

		<div class="form-group">

			{{Form::label('title', 'Title')}}
			{{Form::text('title', $datum->title,['class' => 'form-control','placeholder' => 'Title'])}}
			
		</div>

		<div class="form-group">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('content', $datum->content,['id'=> 'article-ckeditor', 'class' => 'hide form-control','placeholder' => 'Body Text'])}}
		</div>


		{{Form::hidden('_method','PUT')}}
		{{Form::submit('Save',['class'=>'btn btn-primary'])}}

	{!! Form::close() !!}
	
	<style>
		/*.note-codable{display: none}*/
	</style>
	<script type="text/javascript">
		$('.faq_link').addClass('text-white').addClass('font-weight-bold');
	</script>

@endsection
