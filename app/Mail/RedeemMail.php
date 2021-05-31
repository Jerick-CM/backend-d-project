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

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RedeemMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $tpl;

    public $user;
    public $name;

    public $orderItems;
    public $totalTokens;
    public $orderNumber;
    public $date;
    public $orderDate;
    public $collectionDate;
    public $remainingToken;
    public $historyLink;
    public $faqLink;
    public $webPreviewLink = '#';
    public $imgFolderUrl;

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

    public $aceurltest;
    public $link;

    public $subjecttitle;
    public $checkoutdata;

    public $contentbody;

    public $aceStoreLink;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(
        $user,
        $orderItems,
        $totalTokens,
        $orderNumber,
        $date,
        $orderDate,
        $collectionDate,
        $isPreview = false,
        $editpreview,
        $message
    ) {
        $user = $user->refresh();



        $this->siteurl = config('ace.url');
        $this->aceurl = config('ace.url');

        $this->aceurltest = config('ace.urltest');
        // $this->aceurl = 'test';

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

        $this->preheadertext7 = $EdmHeader->preheadertext7;


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


        $collectionTime = config('edm.collection.time');

        $collectionDate = Carbon::createFromFormat('d F Y', "{$collectionDate}")
            ->format('d F Y')  .', ' . $collectionTime;

        $this->imgFolderUrl = secure_url("img/edm");

        $this->user = $user;
        $this->name = $user->name;

        $this->orderNumber = $orderNumber;
        $this->orderDate = $orderDate;

        $this->orderItems = $orderItems;
        $this->totalTokens = $totalTokens;

        $this->remainingToken = $user->green_token;
        $this->historyLink = config('edm.redeem.history_link');
        $this->faqLink = config('edm.redeem.faq_link');

        $this->collectionDate = $collectionDate;

        $this->date = $date;


        $this->checkoutdata = view('edm.checkout.orderitems')->with('orderItems', $this->orderItems);
        $this->aceStoreLink = config('edm.monthly_summary.ace_store_link');

        $EdmTemplateBody_id = 7;
        $EdmTemplateBody = EdmTemplateBody::find($EdmTemplateBody_id);

        if($editpreview){
             
            
            // $this->contentbody = str_replace("{{orderItems_table}}", $this->checkoutdata ,$message);



            $this->contentbody = str_replace("{{name}}", $this->name ,$message);
            $this->contentbody = str_replace("{{orderNumber}}", $this->orderNumber ,$this->contentbody);
            $this->contentbody = str_replace("{{orderItems_table}}", $this->checkoutdata ,$this->contentbody);
            $this->contentbody = str_replace("{{orderDate}}", $this->orderDate ,$this->contentbody);
            $this->contentbody = str_replace("{{remainingToken}}", $this->remainingToken ,$this->contentbody);
            $this->contentbody = str_replace("{{collectionDate}}", $this->collectionDate ,$this->contentbody);
            $this->contentbody = str_replace("{{here}}", "<a href='".$this->historyLink."'>here</a>" ,$this->contentbody);


            $this->contentbody = str_replace("{{ACE e-Store}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceStoreLink."'>ACE e-Store</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{herehistorylink}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->historyLink."'>ACE</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{here_acelink}}", "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceurl."'>ACE</a>" , $this->contentbody);




            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

        }else{

            $this->contentbody = str_replace("{{name}}", $this->name ,$EdmTemplateBody->content);
            $this->contentbody = str_replace("{{orderNumber}}", $this->orderNumber ,$this->contentbody);
            $this->contentbody = str_replace("{{orderItems_table}}", $this->checkoutdata ,$this->contentbody);
            $this->contentbody = str_replace("{{orderDate}}", $this->orderDate ,$this->contentbody);
            $this->contentbody = str_replace("{{remainingToken}}", $this->remainingToken ,$this->contentbody);
            $this->contentbody = str_replace("{{collectionDate}}", $this->collectionDate ,$this->contentbody);
            $this->contentbody = str_replace("{{here}}", "<a href='".$this->historyLink."'>here</a>" ,$this->contentbody);


            $this->contentbody = str_replace("{{ACE e-Store}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceStoreLink."'>ACE e-Store</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{herehistorylink}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->historyLink."'>ACE</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{here_acelink}}", "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceurl."'>ACE</a>" , $this->contentbody);


            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

        }
      

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
        


        // if (! $isPreview) {

        //     event(new AdminLogEvent($user->id, AdminLog::TYPE_EDM_REDEMPTION_EMAIL , [

        //         'receiver_id' => $user->id,
        //         'receiver_name' => $user->name,
        //         'email_category' => "Redemption"

        //     ]));

        // }


       

        $edmFileModel = new EdmFile;

        $edmFile = $edmFileModel->setAppends(['blade_path'])
            ->where([
                'edm_id' => Edm::TYPE_REDEEM,
                'is_active' => 1
            ])
            ->first();

        $this->tpl = $edmFile->blade_path;


        if (! $isPreview) {
            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_REDEEM,
                'data' => [
                    'user' => $user,
                    'name' => $user->name,
                    'orderNumber' => $orderNumber,
                    'orderDate' => $orderDate,
                    'orderItems' => $orderItems,
                    'totalTokens' => $totalTokens,
                    'remainingToken' => $user->green_token,
                    'historyLink' => config('edm.redeem.history_link'),
                    'faqLink' => config('edm.redeem.faq_link'),
                    'collectionDate' => $collectionDate,
                    'date' => $date,
                    'subject'=> __('edm.redeem.title')
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
        // return $this->subject(__('edm.redeem.title'))
        return $this->subject($this->subjecttitle)
            ->view($this->tpl);
    }
}
