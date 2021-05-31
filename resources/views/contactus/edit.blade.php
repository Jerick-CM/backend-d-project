@extends('layouts.appcontactus')


@section('content')
	
	<h1>Edit Contact Us</h1>

	{!! Form::open(['action' => ['ContactUsController@update', $datum->id ],'method'=>'POST']) !!}

		<div class="form-group">

			{{Form::label('title', 'Full Name Placeholder')}}
			{{Form::text('fullname', $datum->fullname,['class' => 'form-control','placeholder' => 'Full name '])}}

		</div>



		<div class="form-group">
			{{Form::label('Email', 'Email')}}
			{{Form::text('email', $datum->email,['class' => 'form-control','placeholder' => ''])}}
		</div>


		<div class="form-group">
			{{Form::label('Role', 'Role')}}
			<div class="input_fields_wrap">
			   

			    <?php

			    $role = json_decode($datum->role,true);

			    ?>

			    <?php 
			    if($role){
			    	foreach ($role as $key => $value) {
				?>

					<div class="form-group">
						<input class="form-control" type="text" name="role[]" value="<?php echo $value; ?>" />
						<a href="#" class="remove_field">Remove</a>
					</div>
			  
			    <?php

			    	}

			    }else{
				?>

					<div class="form-group">
						<input class="form-control" type="text" name="role[]" value="" />
						<a href="#" class="remove_field">Remove</a>
					</div>
			  

				<?php

			    }

			    ?>

 				<button class="add_field_button btn btn-info">Add More Fields</button>

			</div>
		</div>

		<div class="form-group">
			{{Form::label('Type', 'Type')}}
			<div class="input_fields_wrap_type">
				<?php

			    $type = json_decode($datum->type,true);

			    ?>

			    <?php 
			    if($type){
			    	foreach ($type as $key => $value) {
				?>

					<div class="form-group">
						<input class="form-control" type="text" name="type[]" value="<?php echo $value; ?>" />
						<a href="#" class="remove_field">Remove</a>
					</div>
			  
			    <?php

			    	}

			   	}else{
				?>
					<div class="form-group">
						<input class="form-control" type="text" name="type[]" value="" />
						<a href="#" class="remove_field">Remove</a>
					</div>
 				<?php
			   	}
  				?>
				<button class="add_field_button_type btn btn-info">Add More Fields</button>
			</div>

		</div>

		<div class="form-group">

			{{Form::label('Option', 'Option')}}
			
			<div class="input_fields_wrap_option">
				<?php

			    $option = json_decode($datum->option,true);
			    ?>

			    <?php 
			    if($option){
			    	foreach ($option as $key => $value) {
				?>

					<div class="form-group">
						<input class="form-control" type="text" name="option[]" value="<?php echo $value; ?>" />
						<a href="#" class="remove_field">Remove</a>
					</div>
			  
			    <?php

			    	}

			   	}else{
				?>

			   		<div class="form-group">
						<input class="form-control" type="text" name="option[]" value="" />
						<a href="#" class="remove_field">Remove</a>
					</div>
			  

			   	<?php 	
			   	}
  				?>
				<button class="add_field_button_option btn btn-info">Add More Fields</button>
			</div>

		</div>

		<div class="form-group">
			{{Form::label('Attachment Label', 'Attachment Label')}}
			{{Form::text('attachmentlabel', $datum->attachmentlabel,['class' => 'form-control','placeholder' => ''])}}
		</div>


		{{Form::hidden('_method','PUT')}}
		{{Form::submit('Submit',['class'=>'btn btn-primary'])}}

	{!! Form::close() !!}

	<script type="text/javascript">

		$(document).ready(function() {

		    var wrapper         = $(".input_fields_wrap"); 
		    var add_button      = $(".add_field_button"); 
		    

		    $(add_button).on("click",function(e){ 
		        e.preventDefault();
		     
		        $(wrapper).append('<div class="form-group"><input class="form-control" type="text" name="role[]"/><a href="#" class="remove_field">Remove</a></div>'); 
		
		    });
		    
		    $(wrapper).on("click",".remove_field", function(e){ 
		        e.preventDefault(); $(this).parent('div').remove(); ;
		    })


    		var wrapper_type     = $(".input_fields_wrap_type"); 
   			var add_button_type      = $(".add_field_button_type"); 
   			 $(add_button_type).on("click",function(e){ 
		        e.preventDefault();
		 
		        $(wrapper_type).append('<div class="form-group"><input class="form-control" type="text" name="type[]"/><a href="#" class="remove_field">Remove</a></div>'); 
		 
		    });

   			$(wrapper_type).on("click",".remove_field", function(e){ 

		        e.preventDefault(); $(this).parent('div').remove(); 
		    })



    		var wrapper_option    = $(".input_fields_wrap_option"); 
   			var add_button_option      = $(".add_field_button_option"); 

   			$(add_button_option).on("click",function(e){ 
		        e.preventDefault();
		 
		        $(wrapper_option).append('<div class="form-group"><input class="form-control" type="text" name="option[]"/><a href="#" class="remove_field">Remove</a></div>'); 
		 
		    });

   			$(wrapper_option).on("click",".remove_field", function(e){ 

		        e.preventDefault(); $(this).parent('div').remove(); 
		    })



		});

	</script>
@endsection

