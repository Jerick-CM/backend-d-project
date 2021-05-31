<!DOCTYPE html>
<html>
<head>
<title>Deloitte Rewards App Responsive Email Template</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style type="text/css">
@media screen {
  @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');

}
    /* CLIENT-SPECIFIC STYLES */
    /* :400,400i,700,700i */
    /* body {
      background-color: #F5F5F5;
    }

    .wrapper {
      background-color: #ffffff;
    } */

    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    .fluid{
      max-width:100% !important;
      height:auto !important;
      margin-left:auto !important;
      margin-right:auto !important;
    }

    .banner-desktop{
      display:block !important;
    }
    .banner-mobile{
      display:none !important;
    }

    @media screen and (max-width: 565px) {

      .obm-remove-padding {
        padding-bottom: 0px !important;
      }

      .banner-desktop{
        display:none !important;
      }
      .banner-mobile{
        display:block !important;
      }

    }

    @media screen and (max-width: 551px) {

      .mff-mobile {
        margin: 8px 0px 0px 0px !important;
      }

    }

    @media screen and (max-width: 530px){

        .two-item{
          width:100% !important;
          float:left !important;
        }

        .two-item-v2 {
          width:50% !important;
          float: left !important;
          text-align: center !important;
        }

        .two-item-v2-inner {
          text-align: center !important;
        }

        .four-item-mp{
          float:left !important;
          width:48% !important;
          margin-bottom:0;
        }

        .two-item-inner-left {
          width: 18% !important;
        }

        .two-item-inner-right {
          width: 65% !important;
        }

        .two-item-holder {
          padding: 0px 20px 0px 20px;
        }

        .argentina-link {
           margin: 8px 0px 0px 0px !important;
        }

    }

    /* MOBILE STYLES */
    @media screen and (max-width: 525px) {



        /* ALLOWS FOR FLUID TABLES */
        .wrapper {
          width: 100% !important;
          max-width: 100% !important;
        }

        /* ADJUSTS LAYOUT OF LOGO IMAGE */
        .logo img {
          margin: 0 auto !important;
        }

        /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
        .mobile-hide {
          display: none !important;
        }

        .mobile-show {
          display: block !important;
        }

        .img-max {
          max-width: 100% !important;
          width: 100% !important;
          height: auto !important;
        }

        /* FULL-WIDTH TABLES */
        .responsive-table {
          width: 100% !important;
        }

        /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
        .padding {
          padding: 10px 5% 15px 5% !important;
        }

        .padding-meta {
          padding: 30px 5% 0px 5% !important;
          text-align: center;
        }

        .no-padding {
          padding: 0 !important;
        }

        .section-padding {
          padding: 50px 15px 50px 15px !important;
        }

        /* ADJUST BUTTONS ON MOBILE */
        .mobile-button-container {
            margin: 0 auto;
            width: 100% !important;
        }

        .mobile-button {
            padding: 15px !important;
            border: 0 !important;
            font-size: 16px !important;
            display: block !important;
        }

    }

    @media screen and (max-width: 500px) {

      .comfi-container {
        width: 100% !important;
        text-align: center !important;
        float: left !important;
        margin: 10px 0px 10px 0px !important;
      }

      .flc-title {
        margin: 0px 0px 10px 0px !important;
        font-size: 14px !important;
        line-height: 20px !important;
        color:#666666 !important;
        font-family:Calibri, Geneva, sans-serif !important;
      }

      .footer-logo-collection {
        padding-left: 0px !important;
        padding-right: 0px !important;
      }

      .center-on-mobile-footer {
        width: 100% !important;
        float: left !important;
        text-align: center !important;
      }

      .center-on-mobile-footer-img {
        text-align: center !important;
        float: none !important;
      }

      .flc-footer-para {
        text-align: center !important;
      }


    }

    @media screen and (max-width: 480px) {

      /* .two-item-v2 {
        width:100% !important;
        float:left !important;
        text-align: left !important;
      }

      .two-item-v2 p {
        text-align: left !important;
      } */


      .three-item {
        width:100% !important;
      }

      .footer-img {
        width: 120px !important;
      }

      .poweredby {
        margin-top: 20px !important;
      }
    }

    @media screen and (max-width: 400px) {

      .two-item-inner-left {
        width: 30% !important;
      }

      .two-item-inner-right {
        width: 60% !important;
      }


    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }
:root {
      --ck-color-mention-background: hsla(341, 100%, 30%, 0.1);
      --ck-color-mention-text: hsl(341, 100%, 30%);
      --ck-highlight-marker-blue: hsl(201, 97%, 72%);
      --ck-highlight-marker-green: hsl(120, 93%, 68%);
      --ck-highlight-marker-pink: hsl(345, 96%, 73%);
      --ck-highlight-marker-yellow: hsl(60, 97%, 73%);
      --ck-highlight-pen-green: hsl(112, 100%, 27%);
      --ck-highlight-pen-red: hsl(0, 85%, 49%);
      --ck-image-style-spacing: 1.5em;
      --ck-todo-list-checkmark-size: 16px;
    }

    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .marker-yellow {
      background-color: var(--ck-highlight-marker-yellow);
    }
    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .marker-green {
      background-color: var(--ck-highlight-marker-green);
    }
    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .marker-pink {
      background-color: var(--ck-highlight-marker-pink);
    }
    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .marker-blue {
      background-color: var(--ck-highlight-marker-blue);
    }
    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .pen-red {
      color: var(--ck-highlight-pen-red);
      background-color: transparent;
    }
    /* ckeditor5-highlight/theme/highlight.css */
    .ck-content .pen-green {
      color: var(--ck-highlight-pen-green);
      background-color: transparent;
    }
    /* ckeditor5-image/theme/imagestyle.css */
    .ck-content .image-style-side {
      float: right;
      margin-left: var(--ck-image-style-spacing);
      max-width: 50%;
    }
    /* ckeditor5-image/theme/imagestyle.css */
    .ck-content .image-style-align-left {
      float: left;
      margin-right: var(--ck-image-style-spacing);
    }
    /* ckeditor5-image/theme/imagestyle.css */
    .ck-content .image-style-align-center {
      margin-left: auto;
      margin-right: auto;
    }
    /* ckeditor5-image/theme/imagestyle.css */
    .ck-content .image-style-align-right {
      float: right;
      margin-left: var(--ck-image-style-spacing);
    }
    /* ckeditor5-image/theme/image.css */
    .ck-content .image {
      display: table;
      clear: both;
      text-align: center;
      margin: 1em auto;
    }
    /* ckeditor5-image/theme/image.css */
    .ck-content .image img {
      display: block;
      margin: 0 auto;
      max-width: 100%;
      min-width: 50px;
    }
    /* ckeditor5-image/theme/imageresize.css */
    .ck-content .image.image_resized {
      max-width: 100%;
      display: block;
      box-sizing: border-box;
    }
    /* ckeditor5-image/theme/imageresize.css */
    .ck-content .image.image_resized img {
      width: 100%;
    }
    /* ckeditor5-image/theme/imageresize.css */
    .ck-content .image.image_resized > figcaption {
      display: block;
    }
    /* ckeditor5-image/theme/imagecaption.css */
    .ck-content .image > figcaption {
      display: table-caption;
      caption-side: bottom;
      word-break: break-word;
      color: hsl(0, 0%, 20%);
      background-color: hsl(0, 0%, 97%);
      padding: 0.6em;
      font-size: 0.75em;
      outline-offset: -1px;
    }
    /* ckeditor5-basic-styles/theme/code.css */
    .ck-content code {
      background-color: hsla(0, 0%, 78%, 0.3);
      padding: 0.15em;
      border-radius: 2px;
    }
    /* ckeditor5-font/theme/fontsize.css */
    .ck-content .text-tiny {
      font-size: 0.7em;
    }
    /* ckeditor5-font/theme/fontsize.css */
    .ck-content .text-small {
      font-size: 0.85em;
    }
    /* ckeditor5-font/theme/fontsize.css */
    .ck-content .text-big {
      font-size: 1.4em;
    }
    /* ckeditor5-font/theme/fontsize.css */
    .ck-content .text-huge {
      font-size: 1.8em;
    }
    /* ckeditor5-block-quote/theme/blockquote.css */
    .ck-content blockquote {
      overflow: hidden;
      padding-right: 1.5em;
      padding-left: 1.5em;
      margin-left: 0;
      margin-right: 0;
      font-style: italic;
      border-left: solid 5px hsl(0, 0%, 80%);
    }
    /* ckeditor5-block-quote/theme/blockquote.css */
    .ck-content[dir="rtl"] blockquote {
      border-left: 0;
      border-right: solid 5px hsl(0, 0%, 80%);
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content .table {
      margin: 1em auto;
      display: table;
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content .table table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      height: 100%;
      border: 1px double hsl(0, 0%, 70%);
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content .table table td,
    .ck-content .table table th {
      min-width: 2em;
      padding: 0.4em;
      border: 1px solid hsl(0, 0%, 75%);
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content .table table th {
      font-weight: bold;
      background: hsla(0, 0%, 0%, 5%);
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content[dir="rtl"] .table th {
      text-align: right;
    }
    /* ckeditor5-table/theme/table.css */
    .ck-content[dir="ltr"] .table th {
      text-align: left;
    }
    /* ckeditor5-page-break/theme/pagebreak.css */
    .ck-content .page-break {
      position: relative;
      clear: both;
      padding: 5px 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    /* ckeditor5-page-break/theme/pagebreak.css */
    .ck-content .page-break::after {
      content: "";
      position: absolute;
      border-bottom: 2px dashed hsl(0, 0%, 77%);
      width: 100%;
    }
    /* ckeditor5-page-break/theme/pagebreak.css */
    .ck-content .page-break__label {
      position: relative;
      z-index: 1;
      padding: 0.3em 0.6em;
      display: block;
      text-transform: uppercase;
      border: 1px solid hsl(0, 0%, 77%);
      border-radius: 2px;
      font-family: Helvetica, Arial, Tahoma, Verdana, Sans-Serif;
      font-size: 0.75em;
      font-weight: bold;
      color: hsl(0, 0%, 20%);
      background: hsl(0, 0%, 100%);
      box-shadow: 2px 2px 1px hsla(0, 0%, 0%, 0.15);
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    /* ckeditor5-media-embed/theme/mediaembed.css */
    .ck-content .media {
      clear: both;
      margin: 1em 0;
      display: block;
      min-width: 15em;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list {
      list-style: none;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list li {
      margin-bottom: 5px;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list li .todo-list {
      margin-top: 5px;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label > input {
      -webkit-appearance: none;
      display: inline-block;
      position: relative;
      width: var(--ck-todo-list-checkmark-size);
      height: var(--ck-todo-list-checkmark-size);
      vertical-align: middle;
      border: 0;
      left: -25px;
      margin-right: -15px;
      right: 0;
      margin-left: 0;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label > input::before {
      display: block;
      position: absolute;
      box-sizing: border-box;
      content: "";
      width: 100%;
      height: 100%;
      border: 1px solid hsl(0, 0%, 20%);
      border-radius: 2px;
      transition: 250ms ease-in-out box-shadow, 250ms ease-in-out background,
        250ms ease-in-out border;
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label > input::after {
      display: block;
      position: absolute;
      box-sizing: content-box;
      pointer-events: none;
      content: "";
      left: calc(var(--ck-todo-list-checkmark-size) / 3);
      top: calc(var(--ck-todo-list-checkmark-size) / 5.3);
      width: calc(var(--ck-todo-list-checkmark-size) / 5.3);
      height: calc(var(--ck-todo-list-checkmark-size) / 2.6);
      border-style: solid;
      border-color: transparent;
      border-width: 0 calc(var(--ck-todo-list-checkmark-size) / 8)
        calc(var(--ck-todo-list-checkmark-size) / 8) 0;
      transform: rotate(45deg);
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label > input[checked]::before {
      background: hsl(126, 64%, 41%);
      border-color: hsl(126, 64%, 41%);
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label > input[checked]::after {
      border-color: hsl(0, 0%, 100%);
    }
    /* ckeditor5-list/theme/todolist.css */
    .ck-content .todo-list .todo-list__label .todo-list__label__description {
      vertical-align: middle;
    }
    /* ckeditor5-horizontal-line/theme/horizontalline.css */
    .ck-content hr {
      margin: 15px 0;
      height: 4px;
      background: hsl(0, 0%, 87%);
      border: 0;
    }
    /* ckeditor5-code-block/theme/codeblock.css */
    .ck-content pre {
      padding: 1em;
      color: hsl(0, 0%, 20.8%);
      background: hsla(0, 0%, 78%, 0.3);
      border: 1px solid hsl(0, 0%, 77%);
      border-radius: 2px;
      text-align: left;
      direction: ltr;
      tab-size: 4;
      white-space: pre-wrap;
      font-style: normal;
      min-width: 200px;
    }
    /* ckeditor5-code-block/theme/codeblock.css */
    .ck-content pre code {
      background: unset;
      padding: 0;
      border-radius: 0;
    }
    /* ckeditor5-mention/theme/mention.css */
    .ck-content .mention {
      background: var(--ck-color-mention-background);
      color: var(--ck-color-mention-text);
    }
    @media print {
      /* ckeditor5-page-break/theme/pagebreak.css */
      .ck-content .page-break {
        padding: 0;
      }
      /* ckeditor5-page-break/theme/pagebreak.css */
      .ck-content .page-break::after {
        display: none;
      }
    }



</style>



<!--[if gte mso 9]>
<style type="text/css">
  .outlook-style-gray-border {
  border-bottom:solid 1px #cacacb !important;
  padding:0px 0px 8px 0px !important;
  width:100% !important;
  font-size:0px !important;
  }

  .outlook-style-top-links {
  font-size:11px !important;
  line-height:20px !important;
  }

  .argentina-link {
  margin:48px 0px 10px 0px !important;
  }

  .mff-mobile {
  margin: 8px 0px 0px 0px !important;
  }

  .signature-outlook {
    margin: 12px 0px 0px 0px !important;
  }

  </style>
  <![endif]-->

    <!--[if gte mso 15]>
  <style type="text/css">
  .outlook-style-gray-border {
  border-bottom:solid 1px #cacacb !important;
  padding:0px 0px 8px 0px !important;
  width:100% !important;
  font-size:0px !important;
  }

  .outlook-style-top-links {
  font-size:11px !important;
  line-height:20px !important;
  }

  .argentina-link {
  margin:32px 0px 0px 0px !important;
  }

  .mff-mobile {
  margin: 8px 0px 0px 0px !important;
  }
</style>
<![endif]-->


</head>
<body bgcolor="#F5F5F5" style="margin: 0 !important; padding: 0 !important;">

<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
 <!--  Let's appreciate our colleagues on their excellent work consistently and celebrate the people who have gone the extra mile to help us! -->
    {{ $preheadertext5 }}
</div>

<!-- HEADER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
       
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                <tr>
                  <td bgcolor="#e6e6e6" style="padding: 14px 20px 14px 20px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td width="30%" style="margin:0;text-align:left;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif; font-size:13px; font-weight: 700;">
                          <p></p>
                        </td>

                        <td width="70%" style="margin:0;text-align:right;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif; font-size:13px; font-weight: 400;">
                          <!-- Having trouble viewing this e-mail?  -->
                            {{ $headerlabel1 }} <a style="color:#808080;text-decoration:none !important;" href="{{$webPreviewLink}}" target="_blank"><!-- Click here -->{{ $headerlabel2 }}</a>.
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
            </table>
            
      
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
       
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                <tr>
                  <td valign="middle" align="left" style="text-align:left;padding:0;margin:0;width:100%;" class="fluid">
                    <span>

                      <?php if($link != ""){ ?>
                        <a href="{{ $link }}">
                      <?php } ?>


                      <img src="{{$image2}}" width="640" style="float: left; width: 100%; border: 0 !important; outline: 0 !important; border-style: none !important;" alt="Deloitte" class="fluid">

                      <?php if($link != ""){ ?>
                        </a>
                      <?php } ?>


                    </span>
                  </td>
                </tr>
            </table>
            
       
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
           
            
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                <tr>
                  <td bgcolor="#ffffff">
                    <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td style="padding:16px 40px 18px 40px;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif;font-size:15px; line-height: 25px;text-align:left; font-weight: 400;">                          
                           <!-- {{ $headerlabel3 }} -->
                           {!! $locationdate !!}
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
            </table>
            
         
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
             
            <?php if($headercontent1 != ""){ ?>

              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                  <tr>
                    <td valign="middle" align="left" style="text-align:left;padding:0;margin:0;width:100%;" class="fluid">
                      <span>
                        <!-- <a href="{{ config('ace.url') }}"> -->
                        <a href="{{ $href1 }}">
                          <img src="{{$header1}}" width="640" style="float: left; width: 100%; border: 0 !important; outline: 0 !important; border-style: none !important;" alt="ACE Deloitte" class="fluid">
                        </a>
                      </span>
                    </td>
                  </tr>
              </table>
            
            <?php }else{ ?>  

            <?php } ?> 
            
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
            
            <?php if($headercontent2 != ""){ ?>
            
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                    <tr>
                      <td valign="middle" align="left" style="text-align:left;padding:2px 0px 0px 0px;margin:0;width:100%;" class="fluid">
                        <span>
                          <a href="{{ $href2 }}">
                            <img src="{{$header2}}" width="640" style="float: left; width: 100%; border: 0 !important; outline: 0 !important; border-style: none !important;" alt="A.C.E. Welcome to the Deloitte family!" class="fluid">
                          </a>
                        </span>
                      </td>
                    </tr>
                </table>
            
            <?php }else{ ?>  

            <?php } ?>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->

            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                <tr>
                  <td bgcolor="#ffffff" style="padding:0px 0px 0px 0px;color:#e6e6e6;font-family:'Open Sans', 'Roboto', Helvetica, Arial, sans-serif;">
                    <p class="outlook-style-gray-border" style="margin:0;font-size:0px !important;line-height:0px !important;text-align:left; border-bottom: solid 4px #86BC25;padding: 0px 0px 0px 0px;">
                     .
                   </p>
                   <br>
                  </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>

    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
          
            
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                  <tr>
                    <td bgcolor="#ffffff">
                      <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td style="padding:2px 40px 25px 40px;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif;font-size:15px; line-height: 22px;text-align:left; font-weight: 400;">

                            <div class="ck-content">
                            {!! $contentbody !!}
                            </div>


                            <!-- Welcome to Deloitte! -->
                            <!-- {{$placeholder1}} -->
                            <!-- <br><br> -->
                            <!-- {{$placeholder2}} -->
                            <!-- We are delighted to share with you more information about ACE (Appreciate. Celebrate. Elevate.) – our online platform designed especially for us to appreciate our colleagues for their good work and to celebrate the people who have gone the extra mile to help us. -->
                            <!-- <br><br> -->
                             <!-- {{$placeholder3}} -->
                            <!-- On ACE, you can write personalised thank-you messages to colleagues across levels and businesses, and award them achievement badges and tokens. Your colleagues can also do the same for you. -->
                            <!-- <br><br> -->
                             <!-- {!! $placeholder4 !!} -->
                           <!--  These tokens can be used to redeem special treats and gifts at the <a href="{{ config('ace.url') }}/redeem">ACE e-Store</a>. -->
                            <!-- <br><br> -->
                              <!-- {!! $placeholder5 !!} -->
                            <!--   As a welcome gift, you will receive {{ $numberOfToken }} “My Rewards” tokens in your account. Live our Deloitte values and start accumulating “My Rewards” tokens to redeem the item of your choice today! -->
                            <!-- <br><br> -->
                            <!-- {{ $placeholder6 }} -->
                            <!-- You will find that you also have {{ $numberOfBlackToken }} “Recognise Others” tokens in your account that you can give out in appreciation of your colleagues. -->
                            <!-- <br><br> -->
                            <!-- {!! $placeholder7 !!} -->
                           <!--  To find out how you can navigate ACE, please refer to the FAQ <a style="color:#86BC25;text-decoration:none;" href="{{ config('ace.url') }}/faq">here</a>. -->
                            <!-- <br><br> -->
                            <!-- {!! $placeholder8 !!} -->
                           <!--  Click <a style="color:#86BC25;text-decoration:none;" href="{{$aceLink}}">here</a> to access ACE now! -->
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
              </table>
            
       
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
            <tr>
            <td align="center" valign="top" width="640">
            <![endif]-->
         
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px;" class="wrapper">
                  <tr>
                    <td bgcolor="#e6e6e6">
                      <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td style="padding:20px 40px 22px 40px;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif;font-size:10px;line-height:16px;text-align:left; font-weight: 400;">
                            <div class="footer-para" style="margin:0;">
                                
                              <div class="ck-content">
                                  {!! $footer !!}
                              </div>
                            
                            </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                  </tr>
              </table> 
              
              
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>

</table>
</body>
</html>
