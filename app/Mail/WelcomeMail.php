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

class WelcomeMail extends Mailable
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

    public $locationdate;

    public $header1;
    public $header2;

    public $href1;
    public $href2;

    public $headercontent1;
    public $headercontent2;


    public $link;
    public $subjecttitle;


    public $contentbody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $numberOfToken, $date, $isPreview = false,$editpreview,$message)
    {
  

        $this->siteurl = config('ace.url');
        $this->aceurl = config('ace.url');

        $EdmHeader_id = 1;
        $EdmHeader = EdmHeader::find($EdmHeader_id);
        
        $this->link = $EdmHeader->link;
        
        $this->header = str_replace("{{date}}", date('d F Y') ,$EdmHeader->content);
        $this->header = str_replace("{{link}}", config('ace.url') ,$this->header);
        
        $this->title = $EdmHeader->content;
        $this->headerlabel1 = $EdmHeader->label1;
        $this->headerlabel2 = $EdmHeader->label2;

        // $this->headerlabel3 =  str_replace("{{date}}", $date ,$EdmHeader->label3); 
        $this->headerlabel4 = $EdmHeader->label4;
        $this->preheadertext5 = $EdmHeader->preheadertext5;


        $data_url["domain"] = $_SERVER['SERVER_NAME'];
        switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
                // $this->image1 = url($EdmHeader->image1);
                $this->image2 = url($EdmHeader->image2);
                // $this->image4 = url($EdmHeader->image4);
                break; 

            default:
                // $this->image1 = secure_url($EdmHeader->image1);
                $this->image2 = secure_url($EdmHeader->image2);
                // $this->image4 = secure_url($EdmHeader->image4);
        }
       


        // $this->image1 = secure_url($EdmHeader->image1);
        // $this->image2 = secure_url($EdmHeader->image2);
        // $this->image4 = secure_url($EdmHeader->image4);

        $EdmFooter_id = 1;
        $EdmFooter = EdmFooter::find($EdmFooter_id);
        $this->footer = str_replace("{{here}}", "<a href='".config('ace.url')."/faq'>here</a>" ,$EdmFooter->content);
        $this->footer = str_replace("{{www.deloitte.com/about}}", "<a style='color:#86BC25;text-decoration:none;'  href='https://www.deloitte.com/about' target='_blank'>here</a>" ,$this->footer);
        
        $this->footer = str_replace("{{", "" ,$this->footer);
        $this->footer = str_replace("}}", "" ,$this->footer);

        $this->footerlabel1 =  $EdmFooter->footerlabel1;
        $this->footerlabel2 =  $EdmFooter->footerlabel2;
        $this->footerlabel3 =  $EdmFooter->footerlabel3;
        $this->footerlabel4 =  $EdmFooter->footerlabel4;
        $this->footerlabel5 =  $EdmFooter->footerlabel5;

        $this->footerlabel6 =  $EdmFooter->footerlabel6;
        $this->footerlabel7 =  $EdmFooter->footerlabel7;

        $this->faqLink = config('edm.redeem.faq_link');

        $this->imgFolderUrl = secure_url("img/edm");

        $this->user = $user;
        $this->date = $date;
        $this->aceLink = config('edm.welcome.ace_link');
        $this->numberOfToken = $numberOfToken;
        $this->numberOfBlackToken = $user->black_token;
        $this->navigationLink = config('edm.welcome.navigation_link');

        $EdmTemplateBody_id = 5;
        $EdmTemplateBody = EdmTemplateBody::find($EdmTemplateBody_id);

        $this->subjecttitle =  $EdmTemplateBody->subject;

        $this->href1 = $EdmTemplateBody->href1;
        $this->href2 = $EdmTemplateBody->href2;

        $this->headercontent1 = $EdmTemplateBody->header1;
        $this->headercontent2 = $EdmTemplateBody->header2;

        switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
                $this->header1 = url($EdmTemplateBody->header1);
                $this->header2 = url($EdmTemplateBody->header2);
              
                break; 

            default:

                $this->header1 = secure_url($EdmTemplateBody->header1);
                $this->header2 = secure_url($EdmTemplateBody->header2);          
        }

        $this->locationdate =  str_replace("{{date}}", $date ,$EdmTemplateBody->locationdate); 
        $this->locationdate =  str_replace("<p>", "" ,$this->locationdate); 
        $this->locationdate =  str_replace("</p>", "<br>" ,$this->locationdate); 

        if($editpreview){

            $this->contentbody = $message;


             $this->contentbody =  str_replace("{{ACE e-Store}}","<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$this->contentbody);
            
            $this->contentbody =  str_replace("{{ACE}}","<a href='".$this->aceurl."'>ACE</a>" , $this->contentbody);
            $this->contentbody =  str_replace("{{numberOfToken}}",$this->numberOfToken , $this->contentbody);
            $this->contentbody =  str_replace("{{numberOfBlackToken}}",$this->numberOfBlackToken, $this->contentbody);
            $this->contentbody =  str_replace("{{herefaq}}","<a href='".$this->aceurl."/faq'>here</a>", $this->contentbody);
            $this->contentbody =  str_replace("{{here}}","<a href='".$this->aceurl."'>here</a>", $this->contentbody);


            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

        }else{
            
            $this->contentbody =  str_replace("{{ACE e-Store}}","<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$EdmTemplateBody->content);
            
            $this->contentbody =  str_replace("{{ACE}}","<a href='".$this->aceurl."'>ACE</a>" , $this->contentbody);
            $this->contentbody =  str_replace("{{numberOfToken}}",$this->numberOfToken , $this->contentbody);
            $this->contentbody =  str_replace("{{numberOfBlackToken}}",$this->numberOfBlackToken, $this->contentbody);
            $this->contentbody =  str_replace("{{herefaq}}","<a href='".$this->aceurl."/faq'>here</a>", $this->contentbody);
            $this->contentbody =  str_replace("{{here}}","<a href='".$this->aceurl."'>here</a>", $this->contentbody);

            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

            // $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            // $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 


        }
     

        // if (! $isPreview) {

        //     event(new AdminLogEvent($user->id, AdminLog::TYPE_EDM_WELCOME_EMAIL , [                        
        //         'receiver_id' => $user->id,         
        //         'receiver_name' => $user->name, 
        //         'email_category' => 'Welcome Message'                               
        //     ])); 

        // }

        $edmFileModel = new EdmFile;
        
        $edmFile = $edmFileModel->setAppends(['blade_path'])
            ->where([
                'edm_id' => Edm::TYPE_WELCOME,
                'is_active' => 1
            ])
            ->first();
        
        $this->tpl = $edmFile->blade_path;


        if (! $isPreview) {
            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_WELCOME,
                'data' => [
                    'user' => $user,
                    'date' => $date,
                    'aceLink' => config('edm.welcome.ace_link'),
                    'numberOfToken' => $numberOfToken,
                    'numberOfBlackToken' => $user->black_token,
                    'navigationLink' => config('edm.welcome.navigation_link'),
                    'subject' => __('edm.welcome.title')
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
        // return $this->subject(__('edm.welcome.title'))
        return $this->subject($this->subjecttitle)
            ->view($this->tpl);
    }
}
