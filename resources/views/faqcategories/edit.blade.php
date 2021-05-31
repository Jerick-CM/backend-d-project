@extends('layouts.applayout')


@section('content')
	
	<h1>Edit Post</h1>

	{!! Form::open(['action' => ['FaqCategoriesController@update', $FaqCategories->id ],'method'=>'POST']) !!}
		<div class="form-group">
			{{Form::label('title', 'Value')}}
			{{Form::text('value', $FaqCategories->value,['class' => 'form-control','placeholder' => 'Title'])}}
		</div>
		{{Form::hidden('_method','PUT')}}
		{{Form::submit('Save',['class'=>'btn btn-primary'])}}
	{!! Form::close() !!}
	<script type="text/javascript">
		$('.faqcategory_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
