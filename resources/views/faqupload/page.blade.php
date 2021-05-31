@extends('layouts.applayout')



@section('content')

	<h1>Faq Categories</h1>
	
	<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Category</th>
                <th>Edit Page</th>
                <th>Date / Time</th>
            </tr>
        </thead>
        <tbody>
        	@if(count($FaqCategories) > 0)

				@foreach($FaqCategories as $FaqCategory)
				   	<tr>
		                <td>{{$FaqCategory->value}}</td>
		                <td><a href="/faqcategory/{{$FaqCategory->id}}">Link</a></td>
		                <td>{{$FaqCategory->created_at}}</td>		      
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
    <script type="text/javascript">
		$('.faquploadfile_link').addClass('text-white').addClass('font-weight-bold');
	</script>


@endsection
