@extends('layouts.applayout')




@section('content')
	
	<h1>Create Faq category</h1>

	{!! Form::open(['action' => 'FaqFileController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}

		<div class="form-group">

			{{Form::label('Upload File', 'Upload File')}}

		</div>

		<div class="form-group">
			{{Form::file('pdf')}}
		</div>

		<br>

		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}

	{!! Form::close() !!}
	<script type="text/javascript">
		$('.faquploadfile_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
