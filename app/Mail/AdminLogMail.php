<?php

namespace App\Mail;

use App\Models\Edm;
use App\Models\EdmFile;
use App\Models\EdmLog;

use App\Models\EdmHeader;
use App\Models\EdmFooter;
use App\Models\EdmTemplateBody;
use App\Events\AdminLogEvent;
use App\Models\AdminLog;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminLogMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $tpl;
    public $user;
    public $webPreviewLink = '#';

    public $date;
    public $numberOfToken;
    public $numberOfBlackToken;
    public $navigationLink;
    public $aceLink;
    public $imgFolderUrl;
    public $faqLink;

    public $header;
    public $footer;
    public $siteurl;
    public $emailbody;
    public $aceurl;


    public $title;
    public $headerlabel1;
    public $headerlabel2;
    public $headerlabel3;
    public $headerlabel4;

    public $preheadertext1;
    public $preheadertext2;
    public $preheadertext3;
    public $preheadertext4;
    public $preheadertext5;
    public $preheadertext6;
    public $preheadertext7;

    public $image1;
    public $image2;
    public $image3;
    public $image4;
    public $image5;
    public $image6;
    public $image7;
    public $image8;
    public $image9;

    public $footerlabel1;
    public $footerlabel2;
    public $footerlabel3;
    public $footerlabel4;
    public $footerlabel5;

    public $footerlabel6;
    public $footerlabel7;

    public $placeholder1;
    public $placeholder2;
    public $placeholder3;
    public $placeholder4;
    public $placeholder5;

    public $placeholder6;
    public $placeholder7;
    public $placeholder8;
    public $placeholder9;
    public $placeholder10;


    public $placeholder11;
    public $placeholder12;
    public $placeholder13;
    public $placeholder14;
    public $placeholder15;

    public $placeholder16;
    public $placeholder17;
    public $placeholder18;
    public $placeholder19;
    public $placeholder20;

    public $placeholder21;
    public $placeholder22;
    public $placeholder23;

    public $content;

    public $emailsubject;
    public $locationdate;

    public $link;

    public $header1;
    public $header2;

    public $href1;
    public $href2;

    public $headercontent1;
    public $headercontent2;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct($user,$sentmessage,$subject,$isPreview = false)
    {
 

        $this->aceurl = config('ace.url');

        $EdmHeader_id = 1;
        $EdmHeader = EdmHeader::find($EdmHeader_id);
        
        $this->link = $EdmHeader->link;
        
        $this->date =  date('d F Y');

        $this->title = $EdmHeader->content;
        $this->headerlabel1 = $EdmHeader->label1;
        $this->headerlabel2 = $EdmHeader->label2;
        $this->header1 = 'img/edm/main-banner.jpg';
        $this->header2 = 'img/edm/welcome-banner-default.jpg';

        $this->href2 = 'https://www.deloitte.com/';
        $this->href1 = 'https://www.deloitte.com/';

        $data_url["domain"] = $_SERVER['SERVER_NAME'];
        switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
                $this->image2 = url($EdmHeader->image2);
                $this->header1 = url($this->header1);
                $this->header2 = url($this->header2);
                break; 
            default:
                $this->image2 = secure_url($EdmHeader->image2);
                $this->header1 = secure_url($this->header1);
                $this->header2 = secure_url($this->header2); 
    
        }
        
        $this->emailsubject = $subject;
        $this->content = $sentmessage;

        $this->tpl = 'edm.adminlog.default';

        $EdmFooter_id = 1;
        $EdmFooter = EdmFooter::find($EdmFooter_id);

        $htmlsafe_url = htmlspecialchars($this->aceurl, ENT_QUOTES | ENT_HTML5);
        $htmlsafe_url = $htmlsafe_url."/faq";
        
        $this->footer = str_replace("{{here}}", "<a href='$htmlsafe_url'>here</a>" ,$EdmFooter->content);



        // $this->footer = str_replace("{{here}}", "<a href='".config('ace.url')."/faq'>here</a>" ,$EdmFooter->content);
        $this->footer = str_replace("{{www.deloitte.com/about}}", "<a style='color:#86BC25;text-decoration:none;'  href='https://www.deloitte.com/about' target='_blank'>here</a>" ,$this->footer);
        
        $this->footer = str_replace("{{", "" ,$this->footer);
        $this->footer = str_replace("}}", "" ,$this->footer);

        if (! $isPreview) {


            // event(new AdminLogEvent($user->id, AdminLog::TYPE_ADMINLOG_EMAIL , [

            //     'receiver_id' => $user->id,
            //     'receiver_name' => $user->name,
            //     'subject'  => $this->emailsubject, 
            //     'message'  => $this->content,
            //     'email_category' => "Admin Log Report Generation"

            // ]));


            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_ADMINLOG_EMAIL,
                'data' => [
                    'user' => $user,                   
                    'date' => $this->date,                 
                    'subject'  => $this->emailsubject, 
                    'message'  => $this->content
                ],
            ]);

            $this->webPreviewLink = str_replace('{uid}', $edmLog->uid, config('app.web_mail_preview'));

        }
    

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emailsubject)
            ->view($this->tpl);
    }
}
