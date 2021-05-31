@extends('layouts.applayout')



@section('content')
	
	<h1>Edit PDF File</h1>

	{!! Form::open(['action' => ['FaqFileController@update', $datum->id ],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
		<div class="form-group">
			{{Form::label('Pdf File', 'Pdf File')}}
		</div>
		<div class="form-group">
			{{Form::file('pdf')}}
		</div>


		{{Form::hidden('_method','PUT')}}
		{{Form::submit('Save',['class'=>'btn btn-primary'])}}
	{!! Form::close() !!}
	<script type="text/javascript">
		$('.faquploadfile_link').addClass('text-white').addClass('font-weight-bold');
	</script>
@endsection
