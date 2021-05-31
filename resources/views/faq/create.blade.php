@extends('layouts.applayout')
@section('content')
	
	<h1>Create Faq</h1>

	{!! Form::open(['action' => 'FaqsController@store','method'=>'POST']) !!}
		<div class="form-group">
			{{Form::label('title', 'Title')}}
			{{Form::text('value', '',['class' => 'form-control','placeholder' => 'Title'])}}
		</div>
		<div class="form-group d-none">

			{{Form::label('title', 'Priority')}}

			<?php 

				$priority = [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
					7 => 7,
					8 => 8,
					9 => 9,
					10 => 10,
					11 => 11,
					12 => 12,
					13 => 13,
					14 => 14,
					15 => 15,
					16 => 16,
					17 => 17,
					18 => 18,
					19 => 19,
					20 => 20,
				]

			?>
			
			{!! Form::select('priority', $priority, "") !!}

		</div>
		<div class="form-group">
			{!! Form::select('category_id', $Faqscategory, null ) !!}
		</div>
		<div class="form-group">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('body', '',['id'=> 'article-ckeditor', 'class' => 'form-control','placeholder' => 'Body Text'])}}
		</div>
		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}
	{!! Form::close() !!}

	<script type="text/javascript">
		$('.faq_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
