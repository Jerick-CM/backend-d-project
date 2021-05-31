@extends('layouts.applayout')
@section('content')
	
	<h1>Create Faq category</h1>

	{!! Form::open(['action' => 'FaqCategoriesController@store','method'=>'POST']) !!}
		<div class="form-group">

			{{Form::label('Category', 'Category')}}

			{{Form::text('value','',['class' => 'form-control','placeholder' => 'text'])}}

		</div>
		<br>
		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}

	{!! Form::close() !!}
	<script type="text/javascript">
		$('.faqcategory_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
