<!DOCTYPE html>
<html>
<head>
  <!-- Deloitte Rewards App Responsive Email Template -->
<title>{{ $title }}</title>

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
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-family: Calibri, Geneva, Tahoma, sans-serif; } /* Remove spacing between tables in Outlook 2007 and up */
    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

    /* RESET STYLES */
    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important; fon}
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


    @media screen and (max-width: 570px) {

      .one-col-mobile {
        width: 100% !important;
        float: left !important;
        margin-bottom: 20px !important;
      }

      .one-col-mobile-l {
        width: 35% !important;
      }

      .one-col-mobile-r {
        width: 55% !important;
      }

      .one-col-mobile-l-img {
        width: 90% !important;
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

      .one-col-mobile-l {
        width: 100% !important;
        text-align: center !important;
        padding: 12px 0px 0px 0px !important;
      }

      .one-col-mobile-r {
        width: 100% !important;
        text-align: center !important;
        padding: 0px 0px 12px 0px !important;
      }

      .one-col-mobile-l-img {
        width: 50% !important;
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
  <!-- Personal growth achievement, new badges, and ACE portal reminders! Review your ACE portal activity now! -->
    {{ $preheadertext6 }}
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
                        <td width="10%" style="margin:0;text-align:left;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif; font-size:13px; font-weight: 700;">
                          <p></p>
                        </td>

                        <td width="90%" style="margin:0;text-align:right;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif; font-size:13px; font-weight: 400;">
                          <!-- Having trouble viewing this e-mail? -->
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
                        <a href="{{ $link }}" target="_blank">
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
                        <td style="padding:16px 6% 18px 6%;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif;font-size:15px; line-height: 25px;text-align:left; font-weight: 400;">

                          {!! $locationdate !!}
                          <!-- {{ $headerlabel3 }} -->
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
                    


                      <?php if($href1 != ""){ ?>
                        <a href="{{ $href1 }}" target="_blank">
                      <?php } ?>

                        <img src="{{$header1}}" width="640" style="float: left; width: 100%; border: 0 !important; outline: 0 !important; border-style: none !important;" alt="ACE Deloitte" class="fluid">

                      <?php if($href1 != ""){ ?>
                        </a>
                      <?php } ?>

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
                          
                            <?php if($href2 != ""){ ?>
                              <a href="{{ $href2 }}" target="_blank">
                            <?php } ?>
                      
                            <img src="{{$header2}}" width="640" style="float: left; width: 100%; border: 0 !important; outline: 0 !important; border-style: none !important;" alt="A.C.E. Monthly summary report" class="fluid">
                            
                            <?php if($href1 != ""){ ?>
                              </a>
                            <?php } ?>
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
                        <td style="padding:2px 6% 25px 6%;color:#808080;font-family: Calibri, 'Roboto', Helvetica, Arial, sans-serif;font-size:15px; line-height: 22px;text-align:left; font-weight: 400;">

                          {!! $contentbody !!}


                          <!-- Hi {{ $name }}, -->
                          <!-- {{ $placeholder1 }} -->
                          <!-- <br><br> -->
                          <!-- This is the latest summary of your ACE account. -->
                          <!-- {{ $placeholder2 }} -->
                          <!-- <br><br> -->
                          <!-- <b>{{ $placeholder3 }} -->
                            <!-- Personal growth achievements -->
                            
                          <!-- </b> -->
                          <!-- <br><br> -->

                          <!-- {!! $current_tier !!} -->

                          <!-- @if ('none' != strtolower($currentTier))

                             You are currently a {{ $currentTier }}!
                            {{ $placeholder4 }}
                          <br><br>
                          @endif -->

                          <!-- {!! $point_to_next_tier  !!} -->

                            <!-- @if (1 < $pointsToNextTier) -->
                              <!-- {{ $placeholder5 }} -->
                              <!--   Continue to keep up the good work as you are just {{ $pointsToNextTier }} points away from becoming a {{ $nextTier }}! -->
                            <!-- @else -->
                               <!-- {{ $placeholder5 }} -->
                                <!-- Continue to keep up the good work as you are just {{ $pointsToNextTier }} point away from becoming a {{ $nextTier }}! -->

                            <!-- @endif -->

                          <!-- <br><br> -->

                          <!-- {!! $personal_growth_achievement_table !!} -->

                          <!--   
                          <p>
                            <table align="left" cellspacing="0" cellpadding="5" border="0" width="100%" style="padding: 0px 20px 0px 20px;">
                              <tr>
                                <td class="one-col-mobile" style="width: 45%; float: left; border: 1px solid #999999; padding: 0px;">
                                  <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                      <td style="padding: 10px 10px 10px 10px;">
                                        <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">Received badges this month </b>
                                      </td>
                                    </tr>

                                    <tr style="border-top: 1px solid #999999;">
                                      <td>
                                        <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                          
                                          @if ($badgesTotalReceived)
                                            @foreach ($badges as $badge)
                                              @if ($badge->received)
                                                <tr style="border-bottom: 1px solid #999999;">
                                                  <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">
                                                    <img class="one-col-mobile-l-img" src="{{$badge->image_url}}" width="75" style="width: 75px;" />
                                                  </td>
                                                  <td class="one-col-mobile-r" width="55%" style="float: right;padding: 20px 10px 0px 10px;">

                                                    @if (strtolower($badge->name) == 'worldclass citizen')
                                                      World<em>Class</em> Citizen
                                                    @else
                                                    {{ $badge->name }}
                                                    @endif
                                                    <br>
                                                    Count: {{ $badge->received ? $badge->received : 0 }}
                                                  </td>
                                                </tr>
                                              @endif
                                            @endforeach
                                          @else
                                            <tr style="border-bottom: 1px solid #999999;">
                                              <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">0</td>
                                            </tr>
                                          @endif
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>

                                <td class="one-col-mobile" style="width: 45%; float: right; border: 1px solid #999999; padding: 0px;">
                                  <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                      <td style="padding: 10px 10px 10px 10px;">
                                        <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">Shared badges this month</b>
                                      </td>
                                    </tr>

                                    <tr style="border-top: 1px solid #999999;">
                                      <td>
                                        <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                          @if ($badgesTotalSent)
                                            @foreach ($badges as $badge)
                                              @if ($badge->sent)
                                                <tr style="border-bottom: 1px solid #999999;">
                                                  <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">
                                                    <img class="one-col-mobile-l-img" src="{{$badge->image_url}}" width="75" style="width: 75px;" />
                                                  </td>
                                                  <td class="one-col-mobile-r" width="55%" style="float: right;padding: 20px 10px 0px 10px;">
                                                    @if (strtolower($badge->name) == 'worldclass citizen')
                                                     {!! $placeholder6 !!}
                                                    World<em>Class</em> Citizen
                                                    @else
                                                    {{ $badge->name }}
                                                    @endif
                                                    <br>
                                                    Count: {{ $badge->sent ? $badge->sent : 0 }}
                                                  </td>
                                                </tr>
                                              @endif
                                            @endforeach
                                          @else
                                            <tr style="border-bottom: 1px solid #999999;">
                                              <td class="one-col-mobile-l" width="25%" style="float: left;padding: 10px;">0</td>
                                            </tr>
                                          @endif
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>

                          </p> 
                          -->
                          <!-- <p>&nbsp;</p> -->
                          <!-- <b>{{ $placeholder10 }}  -->
                            <!-- Balance tokens: -->
                            
                          <!-- </b> -->
                          <!-- <br> -->

                          <!-- {!! $balance_tokens_table !!} -->

                         <!--  <p>
                            <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="5" border="0" width="100%" style="padding: 0px 20px 0px 20px;">
                              <tr>
                                <td class="one-col-mobile" style="width: 45%; float: left; border: 1px solid #999999; padding: 0px;">
                                  <table align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                      <td style="padding: 10px 10px 10px 10px;">
                                        <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">"Recognise Others" tokens</b>
                                      </td>
                                    </tr>

                                    <tr style="border-top: 1px solid #999999;">
                                      <td style="padding: 10px 10px 10px 10px;">
                                        {{ $recognizeOthersToken }}
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td class="one-col-mobile" style="width: 45%; float: right; border: 1px solid #999999; padding: 0px;">
                                  <table style="font-family: Calibri, Geneva, Tahoma, sans-serif" align="left" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                      <td style="padding: 10px 10px 10px 10px;">
                                        <b style="font-family: Calibri, Geneva, Tahoma, sans-serif">"My Rewards" tokens</b>
                                      </td>
                                    </tr>

                                    <tr style="border-top: 1px solid #999999;">
                                      <td style="padding: 10px 10px 10px 10px;">
                                        {{ $myRewardsToken }}
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </p> -->

                          
                          <!-- <p>&nbsp;</p> -->
                          <!-- <b>{{ $placeholder13 }}  -->
                            <!-- Your "Recognise Others" tokens -->
                            
                          <!-- </b> -->
                          <!-- <br><br> -->
                          <!-- {{ $placeholder14 }} -->
                          <!-- For the month of {{ $month }}, You gave out a total of {{ $recognizeOthersTokenUsed }} "Recognise Others" tokens. -->
                          <!-- <br><br> -->
                           <!-- {{ $placeholder15 }} -->
                          <!-- You have {{ $recognizeOthersToken }} "Recognise Others" tokens remaining, which will expire on {{ $recognizeOthersTokenExpiration }}. -->
                          <!-- <br><br> -->
                          <!-- {{ $placeholder16 }} -->
                          <!-- Remember, you can use ACE to show your appreciation to your colleagues. A small gesture goes a long way! -->
                          <!-- <br><br> -->
                          <!-- <b>{{ $placeholder17 }} -->
                            <!-- Your "My Rewards" tokens -->
                              
                            <!-- </b> -->
                          <!-- <br><br> -->
                          <!-- {{ $placeholder18 }} -->
                          <!-- For the month of {{ $month }}, you received {{ $myRewardsToken }} “My Rewards” tokens from your colleagues and you redeemed a total of {{ $myRewardsTokenUsed }} tokens from the ACE Redemption Store. -->
                          <!-- <br><br> -->
                          <!-- {{ $placeholder19 }} -->

                          <!-- You have a total of {{ $myRewardsToken }} "My Rewards" tokens. -->
                          <!-- @if ($myRewardsToken) -->

                          <!-- {!! $token_expiration_prompt !!} -->

                           <!-- {{ $placeholder20 }} -->
                          <!-- {{ $myRewardsTokenExpirationAmount }} tokens will expire on {{ $myRewardsTokenExpiration }}. -->
                          <!-- @endif -->
                          <!-- <br><br> -->
                            <!-- {!! $placeholder21 !!} -->
                         <!--  Be sure to exchange these tokens for exciting gifts available on the <a style="color:#86BC25;text-decoration:none;" target="_blank" href="{{$aceStoreLink}}">ACE e-Store</a>! -->
                          <!-- <br><br> -->
                          <!-- {!! $placeholder22 !!} -->
                          <!-- To view a full summary of your ACE account, click <a style="color:#86BC25;text-decoration:none;" target="_blank" href="{{$historyLink}}">here</a>. -->
                          <!-- <br><br> -->
                           <!-- {!! $placeholder23 !!} -->
                          <!-- Click <a href="{{ config('ace.url') }}">here</a> to access ACE now! -->
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
