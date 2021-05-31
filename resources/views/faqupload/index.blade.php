@extends('layouts.applayout')


@section('content')


	<div class="row mb-5 ml-0  pl-0">

		<div class="col-md-6">
			<h1>Faq Upload Pdf</h1>
		</div>

		<div class="col-md-6 d-flex flex-row-reverse ">
			<!-- <a href="/faqfile/create" class="btn btn-success mt-2 mb-2 l-1 mr-1"> Create</a>	 -->
		</div>
		
	</div>

	<!-- <div class="row ml-3 mr-3"> -->
		<table id="table" class="table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>Pdf File</th>
	                <th>Edit Page</th>
	                <th>Date / Time</th>	  
	            </tr>
	        </thead>
	        <tbody>
				@if(count($datum) > 0)
					@foreach($datum as $data)
					   	<tr>
			                <td>{{$data->pdf}}</td>
			                <td><a href="/faqfile/{{$data->id}}/edit" class="btn btn-primary">Edit</a></td>
			                <td>{{$data ->created_at}}</td>		      
			            </tr>
					@endforeach

				@else
					<tr>
						<td colspan="3" class="text-center">No data available</tr>
					</tr>
				@endif
			     
	  
	        </tbody>
	    </table>
	<!-- </div> -->

	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
		<script type="text/javascript">
		$('.faquploadfile_link').addClass('text-white').addClass('font-weight-bold');
	</script>
    <script type="text/javascript">    
		$(document).ready(function() {
		    $('#table').DataTable();
		} );
    </script>

@endsection
