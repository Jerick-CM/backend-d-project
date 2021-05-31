@extends('layouts.appcontactus')


@section('content')

	<div class="row mb-5 ml-0  pl-0">

		<div class="col-md-6">
			<h1>Contact Us</h1>
		</div>

		<div class="col-md-6 d-flex flex-row-reverse ">
			<!-- <a href="/contactus/create" class="btn btn-success mt-2 mb-2 l-1 mr-1"> Create</a>	 -->
		</div>
		
	</div>

	<div class="row">
		<div class="col-md-12">

		<table id="example" class="table table-striped table-bordered" style="width:100%">
	        <thead>
	            <tr>
	                <th>Full name</th>
	                <th>Email</th>                
	                <th>Role</th>
	                <th>Type</th>
	                <th>Options</th>
	                <th>Attachment Label</th>
	                <th>Edit Page</th>
	                <th>Date / Time</th>
	  
	            </tr>
	        </thead>
	        <tbody>
				@if(count($datum) > 0)
					@foreach($datum as $data)
					   	<tr>
			                <td>{{$data->fullname}}</td>
			                <td>{{$data->email}} </td>
			                <td>{{$data->role}} </td>		  
			                <td>{{$data->type}}  </td>		  
			                <td>{{$data->option}}  </td>		  
			                <td>{{$data->attachmentlabel}} </td>		  
			                <td><a href="/contactus/{{$data->id}}">Link</a> </td>		  	      
			                <td>{{$data->created_at}}</td>		      
			            </tr>
					@endforeach
				@else
					<tr>
						No data available
					</tr>
				@endif
	     
	   
	        </tbody>
	    </table>
		</div>
	</div>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript">
		$(document).ready(function() {
		    $('#example').DataTable();
		} );
    </script>





@endsection
