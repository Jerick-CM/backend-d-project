@extends('layouts.applayout')

@section('content')

<table id="tablelist" class="table table-bordered table-striped">

    <thead>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll</th>
            <th>Position</th>
        </tr>
    
    </thead>
    
    <tbody>

		@if(count($datum) > 0)

			@foreach($datum as $data)
				<tr id="{{$data->Id}}">
		            <td>{{$data->Id}}</td>
		            <td>{{$data->Name}}</td>
		            <td>{{$data->Roll}}</td>		      		 		      
		            <td>{{$data->Position}}</td>	
		            <input type="hidden" value="{{$data->Id}}" id="item" name="item">	      		            
		    		            
		        </tr>
			@endforeach

		@else

			<tr>
				No data available
			</tr>

		@endif

    </tbody>

</table>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    $('.faq_link').addClass('text-white').addClass('font-weight-bold');
  </script>

<script>
  var $sortable = $( "#tablelist > tbody" );
  $sortable.sortable({
      stop: function ( event, ui ) {
          var parameters = $sortable.sortable( "toArray" );
          console.log(parameters);
    		var url = '<?php echo $url ?>/faq-sorttable';
    		   $.post(url,{
    		   	 '_token': $('meta[name=csrf-token]').attr('content'),
    		   	value:parameters

    		   },
    		   	function(result){
              // alert(result);
          });
      }
  });
</script>
@endsection
