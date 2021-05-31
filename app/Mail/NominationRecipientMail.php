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

class NominationRecipientMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $tpl;
    //public $tpl; 

    public $user;
    public $name;

    public $sender;
    public $senderName;

    public $badge;
    public $badgeType;

    public $messageContent;
    public $token;
    public $date;
    public $time;
    public $webPreviewLink = '#';
    public $imgFolderUrl;
    public $faqLink;

    public $linkingVerb;

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
    public function __construct($user, $sender, $message, $badge, $token, $date, $time, $isPreview = false, $editpreview = false, $content = '')
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

        $this->preheadertext2 = str_replace("{ NAME }", $user->name ,$EdmHeader->preheadertext2);

        $data_url["domain"] = $_SERVER['SERVER_NAME'];
          switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
               
                $this->image2 = url($EdmHeader->image2);
             
                break; 

            default:
             
                $this->image2 = secure_url($EdmHeader->image2);
               
        }
       

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
        $this->name = $user->name;

        $this->sender = $sender;
        $this->senderName = $sender->name;

        $this->badge = $badge;
        $this->badgeType = $badge->name == 'WorldClass Citizen' ? 'World<em>Class</em> Citizen' : $badge->name;

        $this->linkingVerb = in_array(strtolower($this->badgeType[0]), ['a', 'e', 'i', 'o', 'u']) ? 'an' : 'a';

        $this->messageContent = $message;
        $this->token = $token;
        $this->date = $date;
        $this->time = $time;

        $edmFileModel = new EdmFile;

        $edmType = $token ? Edm::TYPE_NOMINATION_RECIPIENT_TOKEN : Edm::TYPE_NOMINATION_RECIPIENT;


        if($token){

            $EdmTemplateBody_id = 4;
            $EdmTemplateBody = EdmTemplateBody::find( $EdmTemplateBody_id);

            $this->subjecttitle=  str_replace(":name", $this->senderName ,$EdmTemplateBody->subject);

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

            if($editpreview){

                $this->contentbody = $content;


                $this->contentbody = str_replace("{{name}}", $this->name ,$this->contentbody);
                $this->contentbody = str_replace("{{messageContent}}", $this->messageContent ,$this->contentbody);

                $this->contentbody = str_replace("{{senderName}}", $this->senderName ,$this->contentbody);
                $this->contentbody = str_replace("{{linkingVerb}}", $this->linkingVerb,$this->contentbody);
                $this->contentbody = str_replace("{{badgeType}}", $this->badgeType,$this->contentbody);
                $this->contentbody = str_replace("{{token}}", $this->token ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE}}", "<a href='".$this->aceurl."'>ACE</a>" ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE e-Store}}", "<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$this->contentbody);


                $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
                $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

            }else{

                $this->contentbody = str_replace("{{name}}", $this->name ,$EdmTemplateBody->content);
                $this->contentbody = str_replace("{{messageContent}}", $this->messageContent ,$this->contentbody);

                $this->contentbody = str_replace("{{senderName}}", $this->senderName ,$this->contentbody);
                $this->contentbody = str_replace("{{linkingVerb}}", $this->linkingVerb,$this->contentbody);
                $this->contentbody = str_replace("{{badgeType}}", $this->badgeType,$this->contentbody);
                $this->contentbody = str_replace("{{token}}", $this->token ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE}}", "<a href='".$this->aceurl."'>ACE</a>" ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE e-Store}}", "<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$this->contentbody);

                $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
                $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 
 
            }

       


            $this->locationdate =  str_replace("{{date}}", $date ,$EdmTemplateBody->locationdate); 
            $this->locationdate =  str_replace("<p>", "" ,$this->locationdate); 
            $this->locationdate =  str_replace("</p>", "<br>" ,$this->locationdate); 



            $email_category = "Message Receive with Token";

        }else{

            $EdmTemplateBody_id = 2;
            $EdmTemplateBody = EdmTemplateBody::find($EdmTemplateBody_id); 


       


            $this->subjecttitle =  str_replace(":name", $this->senderName ,$EdmTemplateBody->subject);
            


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

                $this->contentbody = $content;

                $this->contentbody = str_replace("{{name}}", $this->name ,$this->contentbody);
                $this->contentbody = str_replace("{{messageContent}}", $this->messageContent ,$this->contentbody);
                $this->contentbody = str_replace("{{senderName}}", $this->senderName ,$this->contentbody);
                $this->contentbody = str_replace("{{linkingVerb}}", $this->linkingVerb,$this->contentbody);
                $this->contentbody = str_replace("{{badgeType}}", $this->badgeType,$this->contentbody);
                $this->contentbody = str_replace("{{ACE}}", "<a href='".$this->aceurl."'>ACE</a>" ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE e-Store}}", "<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$this->contentbody);


                $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
                $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 
            }else{

                $this->contentbody = str_replace("{{name}}", $this->name ,$EdmTemplateBody->content);
                $this->contentbody = str_replace("{{messageContent}}", $this->messageContent ,$this->contentbody);
                $this->contentbody = str_replace("{{senderName}}", $this->senderName ,$this->contentbody);
                $this->contentbody = str_replace("{{linkingVerb}}", $this->linkingVerb,$this->contentbody);
                $this->contentbody = str_replace("{{badgeType}}", $this->badgeType,$this->contentbody);
                $this->contentbody = str_replace("{{ACE}}", "<a href='".$this->aceurl."'>ACE</a>" ,$this->contentbody);
                $this->contentbody = str_replace("{{ACE e-Store}}", "<a href='".$this->aceurl."/redeem'>ACE e-Store</a>" ,$this->contentbody);
                $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
                $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

            }
           

 

            $email_category = "Message Receive";

        }



        $edmFile = $edmFileModel->setAppends(['blade_path'])
            ->where([
                'edm_id' => $edmType,
                'is_active' => 1
            ])
            ->first();

        $this->tpl = $edmFile->blade_path;
        //edm.received.default
        if (! $isPreview) {
            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_NOMINATION_RECIPIENT,
                'data' => [
                    'user' => $user,
                    'sender' => $sender,
                    'message' => $message,
                    'badge' => $badge,
                    'token' => $token,
                    'date' => $date,
                    'time' => $time,
                    'subject' => __('edm.received_message.title', [ 'name' => $this->senderName ])
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
        return $this->subject($this->subjecttitle

            // __('edm.received_message.title', [
            //     'name' => $this->senderName
            // ])

        )->view($this->tpl);
    }
}
