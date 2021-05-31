@extends('layouts.applayout')

@section('content')

	<a href="/faq" class="btn btn-success mt-2 mb-2"> Go Back</a>

	<h1>{{$Faqs->value}}</h1>
	
	<div>
		{!!$Faqs->body!!}
	</div>
	<hr>
	<small>Written on {{$Faqs->created_at}}</small>
	<hr>

	<a href="/faq/{{$Faqs->id}}/edit" class="btn btn-primary">Edit</a>


	{!!Form::open(['action'=>['FaqsController@destroy',$Faqs->id],'method' => 'POST','class'=>'pull-right'])!!}
		{{Form::hidden('_method','DELETE')}}
		{{Form::submit('Delete',['class'=>'btn btn-danger'],['onclick' => 'ConfirmDelete()'])}}
		<!-- <input class="btn btn-danger" type="submit" value="Delete" > -->
	{!!Form::close()!!}
	
	<!-- 
		<script>
		    function ConfirmDelete()
		    {
		      var x = confirm("Are you sure you want to delete?");
		      if (x)
		          return true;
		      else
		        return false;
		    }
		</script>  
	-->
	
	<script type="text/javascript">
		$('.faq_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
