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

class NominationTierPromotionMail extends Mailable
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

    public $messagebody;
    public $locationdate;

    public $header1;
    public $header2;


    public $href1;
    public $href2;

    public $headercontent1;
    public $headercontent2;

    public $link;

    public $subjecttitle;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $sender, $message, $badge, $token, $date, $time, $isPreview = false , $tierold,$tiernew, $messagerewardstoken,$tiernext,$editpreview)
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
                // $this->image1 = url($EdmHeader->image1);
                $this->image2 = url($EdmHeader->image2);
                // $this->image6 = url($EdmHeader->image6);
                // $this->image7 = url($EdmHeader->image7);
                break; 

            default:
                // $this->image1 = secure_url($EdmHeader->image1);
                $this->image2 = secure_url($EdmHeader->image2);
                // $this->image6 = secure_url($EdmHeader->image6);
                // $this->image7 = secure_url($EdmHeader->image7);
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

        $EdmTemplateBody_id = 8;
        $EdmTemplateBody = EdmTemplateBody::find( $EdmTemplateBody_id);

        
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
            $this->messagebody = $message;

            $this->messagebody = str_replace("{{name}}", $this->name , $this->messagebody);
            $this->messagebody = str_replace("{{newbadge}}", $tiernew ,$this->messagebody);

            $this->messagebody = str_replace("{{rewardstoken}}", $messagerewardstoken ,$this->messagebody);

            if( $tiernext == ''){

                $this->messagebody = str_replace("<p>&nbsp;</p><p>Your great work and effort have been recognised and you are on your way to becoming a {{nextbadge}}!&nbsp;</p>", '' ,$this->messagebody);

                $this->messagebody = str_replace("Your great work and effort have been recognised and you are on your way to becoming a {{nextbadge}}!", '' ,$this->messagebody);
                
            }
            
            $this->messagebody = str_replace("{{nextbadge}}", $tiernext ,$this->messagebody);
            $this->messagebody = str_replace("{{here}}", "<a href='".config('ace.url')."/faq'>here</a>" ,$this->messagebody);

            $this->messagebody =  str_replace("<p>", "" ,$this->messagebody); 
            $this->messagebody =  str_replace("</p>", "<br>" ,$this->messagebody); 

        }else{


            $this->messagebody = str_replace("{{name}}", $this->name ,$EdmTemplateBody->content);
            $this->messagebody = str_replace("{{newbadge}}", $tiernew ,$this->messagebody);
           
            $this->messagebody = str_replace("{{rewardstoken}}", $messagerewardstoken ,$this->messagebody);

            if( $tiernext == ''){

                $this->messagebody = str_replace("<p>&nbsp;</p><p>Your great work and effort have been recognised and you are on your way to becoming a {{nextbadge}}!&nbsp;</p>", '' ,$this->messagebody);

                $this->messagebody = str_replace("Your great work and effort have been recognised and you are on your way to becoming a {{nextbadge}}!", '' ,$this->messagebody);
                
            }

            $this->messagebody = str_replace("{{nextbadge}}", $tiernext ,$this->messagebody);
            $this->messagebody = str_replace("{{here}}", "<a href='".config('ace.url')."/faq'>here</a>" ,$this->messagebody);


            $this->messagebody =  str_replace("<p>", "" ,$this->messagebody); 
            $this->messagebody =  str_replace("</p>", "<br>" ,$this->messagebody); 

        }


        $email_category = "Tier Promotion";
      
        if (! $isPreview) {

            event(new AdminLogEvent($user->id, AdminLog::TYPE_EDM_TIERPROMOTION_EMAIL , [
                        
                'receiver_id' => $user->id,     
                'receiver_name' => $user->name,    
                'sender_id' => $sender->id,         
                'sender_name' => $sender->name, 
                'email_category' => $email_category,
                'tier_old' => $tierold,
                'tier_new' => $tiernew ,
                'rewardstoken' => $messagerewardstoken

            ])); 

        }

        $this->tpl = 'edm.tierPromotion.default';
    
        if (! $isPreview) {
            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_TIER_PROMOTION,
                'data' => [
                    'user' => $user,
                    'sender' => $sender,
                    'message' => $message,
                    'badge' => $badge,
                    'token' => $token,
                    'date' => $date,
                    'time' => $time,
                    'subject' => __('edm.tierPromotion.title', [ 'name' => $this->senderName ])
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
        // return $this->subject(__('edm.received_message.title', [
        // return $this->subject(__('edm.tierPromotion.title', ['name' => $this->senderName]))
             return $this->subject($this->subjecttitle)
                ->view($this->tpl);
    }
}
