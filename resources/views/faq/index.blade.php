@extends('layouts.applayout')

@section('content')

	<div class="row mb-5 ml-0  pl-0">

		<div class="col-md-6">
			<h1>Faq</h1>
		</div>

		<div class="col-md-6 d-flex flex-row-reverse ">
			<a href="/faq/create" class="btn btn-success mt-2 mb-2 l-1 mr-1"> Create</a>	
		</div>
		
	</div>

	<div class="row ml-3 mr-3">	

		<button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('faqdeleteall') }}">Delete All Selected</button>
		<table id="tablelist" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="50px"><input type="checkbox" id="master"></th>
				    <th>Category</th>
				    <th>Label</th>                
				    
				    <th>Edit </th>
				    <th >Delete</th>
				    <th width="100px">Date / Time</th>
				
				</tr>
			</thead>
			<tbody>
				@if(count($Faqs) > 0)
					@foreach($Faqs as $faq)
					   	<tr id="{{$faq->id}}">
					   		 <td><input type="checkbox" class="sub_chk" data-id="{{$faq->id}}"></td>
				            <td>{{$faq->categoryname}}</td>
				            <td>{{$faq->value}}</td>
				            <!-- <td>{{$faq->priority}}</td>		       -->
				            <td><a href="/faq/{{$faq->id}}/edit" class="btn btn-primary">Edit</a></td>	
				            <td>


								{!!Form::open(['action'=>['FaqsController@destroy',$faq->id],'method' => 'POST','class'=>'pull-right','onsubmit' => 'return confirmDelete()'])!!}
									{{Form::hidden('_method','DELETE')}}
									{{Form::submit('Delete',['class'=>'btn btn-danger'],['onclick' => 'ConfirmDelete()'])}}
								{!!Form::close()!!}

		            			<!--    <a href="{{ url('faqdelete',$faq->id) }}" class="btn btn-danger btn-sm"
		                           data-tr="tr_{{$faq->id}}"
		                           data-toggle="confirmation"
		                           data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
		                           data-btn-ok-class="btn btn-sm btn-danger"
		                           data-btn-cancel-label="Cancel"
		                           data-btn-cancel-icon="fa fa-chevron-circle-left"
		                           data-btn-cancel-class="btn btn-sm btn-default"
		                           data-title="Are you sure you want to delete ?"
		                           data-placement="left" data-singleton="true">
		                            Delete
		                        </a> -->
		                    </td>	      
				            <td>{{$faq->created_at}}</td>	
				          
				            <input type="hidden" value="{{$faq->id}}" id="item" name="item">
		 	      
				        </tr>
					@endforeach

				@else
					<tr>
						No data available
					</tr>
				@endif
			</tbody>
		</table>
		<span>Note: Drag table row to change the table order</span>
	</div>

	
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     
	<script type="text/javascript">
		$('.faq_link').addClass('text-white').addClass('font-weight-bold');
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
		      console.log(parameters);
				var url = '<?php echo $url ?>/faq-sorttable-real';
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
