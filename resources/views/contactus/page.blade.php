@extends('layouts.appcontactus')


@section('content')

	<h1>Contact Us</h1>
	
	@if(count($datum) > 0)
		@foreach($datum as $data)
			<div class="row"> 		
				<div class="col-md-12">  			
					<div class="card ">  		

						<div class="card-header">

							<p><a href="/contactus/{{$data->id}}">View</a></p>

						</div>

						<ul class="list-group list-group-flush">

							<li class="list-group-item"><strong>Full Name placeholder </strong>: + {{$data->fullname}} </li>
							<li class="list-group-item"><strong>E-mail placeholder </strong>:+ {{$data->email}} </li>
							<li class="list-group-item"><strong>Role </strong>: + {{$data->role}} </li>
							<li class="list-group-item"><strong>Types </strong>: + {{$data->type}} {{$data->type}} </li>
							<li class="list-group-item"><strong>Options  </strong>: + {{$data->option}} </li>
							<li class="list-group-item"><strong>Attachment Label </strong> : + {{$data->attachmentlabel}} </li>

							<div class="mb-1 mt-1 ml-1 mr-1">
							<small>Written on {{$data->created_at}}</small>
							</div>
						</ul>

					</div>
				</div>
			</div>
		@endforeach
	
	@else
		<p>
			No Posts found
		</p>
	@endif



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


	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript">
    
		$(document).ready(function() {
		    $('#example').DataTable();
		} );
    </script>


@endsection
