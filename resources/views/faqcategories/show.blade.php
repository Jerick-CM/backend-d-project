@extends('layouts.applayout')
@section('content')
	<a href="/faqcategory" class="btn btn-success mt-2 mb-2"> Go Back</a>
	<h1>{{$FaqCategories->value}}</h1>
	
	<div>
		{{$FaqCategories->value}}
	</div>
	<hr>
	<small>Written on {{$FaqCategories->created_at}}</small>
	<hr>
	<a href="/faqcategory/{{$FaqCategories->id}}/edit" class="btn btn-primary">Edit</a>
	
	{!!Form::open(['action'=>['FaqCategoriesController@destroy',$FaqCategories->id],'method' => 'POST','class'=>'pull-right'])!!}
		{{Form::hidden('_method','DELETE')}}
		{{Form::submit('Delete',['class'=>'btn btn-danger'])}}
	{!!Form::close()!!}
	<script type="text/javascript">
		$('.faqcategory_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
