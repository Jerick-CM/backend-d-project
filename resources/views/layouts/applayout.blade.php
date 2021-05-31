<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta name="csrf-token" content="{{ Session::token() }}"> 
        <title>{{config('app.name','LS APP')}}</title>

        <?php 

            switch ($_SERVER['SERVER_NAME']) {

                    case 'deloitte-backend.local.nmgdev.com':
       ?>
                        <link rel="stylesheet" href="<?php echo url('/lib/bootstrap-4.4.1-dist/css/bootstrap.min.css'); ?>" >
       <?php 
                    break;
 
                    default: 

        ?>
                        <link rel="stylesheet" href="<?php echo url('/public/lib/bootstrap-4.4.1-dist/css/bootstrap.min.css'); ?>" >
        <?php     
                    break;
            }   

        ?>


      



        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>


    </head>
    <body>
        <!-- <?php echo $_SERVER['SERVER_NAME'];  ?> -->
         @include("inc.cmsnavbar")
        <div class='container'>
            @include('inc.messages')
            @yield('content')   
        </div>
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

        <?php 

       
            switch ($_SERVER['SERVER_NAME']) {

                    case 'deloitte-backend.local.nmgdev.com':
       ?>
                             <script src="<?php echo url('/lib/bootstrap-4.4.1-dist/js/bootstrap.min.js'); ?>" ></script>
                             <link rel="stylesheet"  href="<?php echo url('/lib/summernote-b4/summernote-bs4.css"'); ?>" >
                             <script src="<?php echo url('/lib/summernote-b4/summernote-bs4.js"'); ?>"></script>  
       <?php 
                    break;
 
                    default: 

        ?>
                             <script src="<?php echo url('/public/lib/bootstrap-4.4.1-dist/js/bootstrap.min.js'); ?>" ></script>
                             <link rel="stylesheet"  href="<?php echo url('/public/lib/summernote-b4/summernote-bs4.css"'); ?>" >
                             <script src="<?php echo url('/public/lib/summernote-b4/summernote-bs4.js"'); ?>"></script>  
        <?php     
                    break;
            }   

        ?>







        <script>       
                $('#article-ckeditor').summernote({
                    placeholder: 'Hello Bootstrap 4',
                    tabsize: 2,
                    height:400
              });
        </script>

    </body>
</html>
