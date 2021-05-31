@extends('layouts.applayout')


@section('content')

	<a href="/faqfile" class="btn btn-success mt-2 mb-2"> Go Back</a>
	<h1>{{$datum->pdf}}</h1>
	
	<div>
		{{$datum->pdf}}
	</div>
	<hr>
	<small>Written on {{$datum->created_at}}</small>
	<hr>

	<a href="/faqfile/{{$datum->id}}/edit" class="btn btn-primary">Edit</a>
	
	{!!Form::open(['action'=>['FaqCategoriesController@destroy',$datum->id],'method' => 'POST','class'=>'pull-right'])!!}
		{{Form::hidden('_method','DELETE')}}
		{{Form::submit('Delete',['class'=>'btn btn-danger'])}}
	{!!Form::close()!!}
	<script type="text/javascript">
		$('.faquploadfile_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
