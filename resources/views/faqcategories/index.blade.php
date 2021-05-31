@extends('layouts.applayout')

@section('content')


	<div class="row mb-5 ml-0  pl-0">

		<div class="col-md-6">
			<h1>Faq Categories</h1>
		</div>

		<div class="col-md-6 d-flex flex-row-reverse ">
			<a href="/faqcategory/create" class="btn btn-success mt-2 mb-2 l-1 mr-1"> Create</a>	
		</div>
		
	</div>

	<!-- <div class="row ml-3 mr-3"> -->
		<button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('faqcategoriesdeleteall') }}">Delete All Selected</button>
		<table id="tablelist" class="table table-bordered table-striped">
	        <thead>
	            <tr>
	            	<th width="50px"><input type="checkbox" id="master"></th>
	                <th>Category</th>
	              	<th>Edit </th>
				    <th>Delete</th>
	        	    <th width="100px">Date / Time</th>  
	            </tr>
	        </thead>
	        <tbody>
	        	@if(count($datum) > 0)

					@foreach($datum as $data)
					   	<tr id="{{$data->id}}">
					   	  	<td><input type="checkbox" class="sub_chk" data-id="{{$data->id}}"></td>
			                <td>{{$data->value}}</td>			                
			    			<td><a href="/faqcategory/{{$data->id}}/edit" class="btn btn-primary">Edit</a></td>	
			                <td>			                	
			                	{!!Form::open(['action'=>['FaqCategoriesController@destroy',$data->id],'method' => 'POST','class'=>'pull-right','onsubmit' => 'return confirmDelete()'])!!}
									{{Form::hidden('_method','DELETE')}}
									{{Form::submit('Delete',['class'=>'btn btn-danger'])}}
								{!!Form::close()!!}
			                </td>	
			                <td>{{$data->created_at}}</td>	
			                <input type="hidden" value="{{$data->id}}" id="item" name="item">	      
			            </tr>
					@endforeach

				@else
					<tr>
						No data available
					</tr>
				@endif
			     
	  
	        </tbody>
	    </table>
	<!-- </div> -->

	
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript">
		$('.faqcategory_link').addClass('text-white').addClass('font-weight-bold');
	</script>
<script>

	function confirmDelete() {
	    return confirm('Are you sure you want to delete?');
	}

	$(document).ready(function () {

		$('#master').on('click', function(e) {
			if($(this).is(':checked',true))  
			{
				$(".sub_chk").prop('checked', true);  
			} else {  
				$(".sub_chk").prop('checked',false);  
			}  
		});

		$('[data-toggle=confirmation]').confirmation({
	        rootSelector: '[data-toggle=confirmation]',
	        onConfirm: function (event, element) {
	            element.trigger('confirm');
	        }
	    });
	});

	  var $sortable = $( "#tablelist > tbody" );
	  $sortable.sortable({
	      stop: function ( event, ui ) {
	          var parameters = $sortable.sortable( "toArray" );
	       
	    		var url = '<?php echo $url ?>/faqcategory-sorttable-real';
	    		   $.post(url,{
	    		   	 '_token': $('meta[name=csrf-token]').attr('content'),
	    		   	value:parameters

	    		   },
	    		   	function(result){
	              // alert(result);
	          });
	      }
	  });



	$('.delete_all').on('click', function(e) {


		var allVals = [];  
		$(".sub_chk:checked").each(function() {  
		    allVals.push($(this).attr('data-id'));
		});  


		if(allVals.length <=0)  
		{  
		    alert("Please select row.");  
		}  
		else {  

		    var check = confirm("Are you sure you want to delete this row?");  
		    if(check == true){  


		        var join_selected_values = allVals.join(","); 


		        $.ajax({
		            url: $(this).data('url'),
		            type: 'DELETE',
		            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		            data: 'ids='+join_selected_values,
		            success: function (data) {
		                if (data['success']) {
		                    $(".sub_chk:checked").each(function() {  
		                        $(this).parents("tr").remove();
		                    });
		                    alert(data['success']);
		                } else if (data['error']) {
		                    alert(data['error']);
		                } else {
		                    alert('Whoops Something went wrong!!');
		                }
		            },
		            error: function (data) {
		                alert(data.responseText);
		            }
		        });


		      $.each(allVals, function( index, value ) {
		          $('table tr').filter("[data-row-id='" + value + "']").remove();
		      });
		    }  
		}  
	});



</script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>	
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script type="text/javascript">    
	$(document).ready(function() {
	    $('#tablelist').DataTable( {
		   'columnDefs': [ {
		        'targets': [0,1,2,3,4,5], /* column index */
		        'orderable': false, /* true or false */
		     }]
		} );
	});
</script>

@endsection
