<?php

namespace App\Mail;

use App\Models\Badge;
use App\Models\Edm;
use App\Models\EdmFile;
use App\Models\EdmLog;
use App\Models\GreenTokenLog;
use App\Models\MessageBadge;
use App\Models\MessageToken;
use App\Models\Redeem;

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

class MonthlySummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $tpl;

    public $date;
    public $name;
    public $month;
    public $badges;
    public $nextTier;
    public $currentTier;
    public $pointsToNextTier;
    public $myRewardsToken;
    public $myRewardsTokenUsed;
    public $myRewardsTokenExpirationAmount;
    public $myRewardsTokenExpiration;
    public $recognizeOthersToken;
    public $recognizeOthersTokenUsed;
    public $recognizeOthersTokenExpiration;
    public $aceStoreLink;
    public $historyLink;
    public $webPreviewLink = '#';
    public $imgFolderUrl;
    public $faqLink;
    public $badgesTotalSent;
    public $badgesTotalReceived;

    protected $output;

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

    public $personal_growth_achievement_table;
    public $balance_tokens_table;
    public $current_tier;
    public $point_to_next_tier;
    public $token_expiration_prompt;

    public $contentbody;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $isPreview = false,$content,$editpreview)
    {

        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();


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

        // $this->headerlabel3 =  str_replace("{{date}}", date('d F Y') ,$EdmHeader->label3); 
        $this->headerlabel4 = $EdmHeader->label4;
        $this->preheadertext6 = $EdmHeader->preheadertext6;

        $data_url["domain"] = $_SERVER['SERVER_NAME'];
        switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
                // $this->image1 = url($EdmHeader->image1);
                $this->image2 = url($EdmHeader->image2);
                // $this->image3 = url($EdmHeader->image3);        
        
                break; 

            default:
                // $this->image1 = secure_url($EdmHeader->image1);
                $this->image2 = secure_url($EdmHeader->image2);
                // $this->image3 = secure_url($EdmHeader->image3);        
        
        }
       


        // $this->image1 = secure_url($EdmHeader->image1);
        // $this->image2 = secure_url($EdmHeader->image2);
        // $this->image3 = secure_url($EdmHeader->image3);        
        
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


        $this->imgFolderUrl = secure_url("img/edm");

        $totalMessageBadgeCount = MessageBadge::where('recipient_user_id', $user->id)->count();

        $startDate = Carbon::now()->startOfMonth()->hour(0)->minute(0)->second(0);
        $endDate   = Carbon::now()->endOfMonth()->hour(23)->minute(59)->second(59);

        $receivedBadges = MessageBadge::where('recipient_user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $sentBadges = MessageBadge::where('sender_user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $badges = Badge::get();

        $badges = $badges->map(function ($badge) use ($user, $startDate, $endDate) {
            $badge['sent'] = MessageBadge::where('sender_user_id', $user->id)
                ->where('type', $badge->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            $badge['received'] = MessageBadge::where('recipient_user_id', $user->id)
                ->where('type', $badge->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            return $badge;
        });

        $this->badgesTotalSent = collect($badges)->sum('sent');
        $this->badgesTotalReceived = collect($badges)->sum('received');

        $this->date = Carbon::now()->format('d F Y');
        $this->name = $user->name;
        $this->month = Carbon::now()->format('F');
        $this->badges = $badges;
        $this->nextTier = $this->getNextTier($totalMessageBadgeCount);
        $this->currentTier = $this->getUserTier($totalMessageBadgeCount);
        $this->pointsToNextTier = $this->countToNextTier($totalMessageBadgeCount);
        $this->faqLink = config('edm.redeem.faq_link');

        $this->myRewardsToken = $user->green_token;
        $this->myRewardsTokenUsed = Redeem::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->sum('total_credits');

        //        $expiringTokenFrom = Carbon::now()->addMonths(1)->firstOfMonth()->toDateTimeString();
        //        $expiringTokenTo   = Carbon::now()->addMonths(1)->endOfMonth()->toDateTimeString();

        //        $nearestExpiringToken = GreenTokenLog::where('user_id', $user->id)
        //            ->where('action', GreenTokenLog::ACTION_CREDIT)
        //            ->whereBetween('expires_at', [$expiringTokenFrom, $expiringTokenTo])
        //            ->orderBy('expires_at', 'asc')
        //            ->get();

        $this->myRewardsTokenExpiration = Carbon::now()->addMonths(1)->endOfMonth()->format('d F Y');

        //        if (! count($nearestExpiringToken)) {
        //            $this->myRewardsTokenExpirationAmount = 0;
        //        } else {
        //            $this->myRewardsTokenExpirationAmount = $nearestExpiringToken->sum('amount');
        //        }

        $this->myRewardsTokenExpirationAmount = $this->getUserNextMonthExpiredTokenAmount($user);

        $this->recognizeOthersToken = $user->black_token;
        $this->recognizeOthersTokenUsed = MessageToken::where('sender_user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->sum('amount');

        $this->recognizeOthersTokenExpiration = Carbon::yesterday()->lastOfQuarter()->format('d F Y');

        $this->aceStoreLink = config('edm.monthly_summary.ace_store_link');
        $this->historyLink  = config('edm.monthly_summary.history_link');                     

        $this->current_tier = view('edm.monthlySummary.current_tier')
                                                        ->with('currentTier',$this->currentTier);

        $this->point_to_next_tier = view('edm.monthlySummary.point_to_next_tier')
                                                        ->with('pointsToNextTier',$this->pointsToNextTier)
                                                        ->with('nextTier',$this->nextTier);

        $this->personal_growth_achievement_table = view('edm.monthlySummary.personal_growth_achievement')
                                                        ->with('badgesTotalReceived', $this->badgesTotalReceived)
                                                        ->with('badges', $this->badges)
                                                        ->with('badgesTotalSent', $this->badgesTotalSent);

        $this->balance_tokens_table = view('edm.monthlySummary.balance_tokens')
                                                        ->with('recognizeOthersToken', $this->recognizeOthersToken)
                                                        ->with('myRewardsToken', $this->myRewardsToken);

        $this->token_expiration_prompt =  view('edm.monthlySummary.token_expiration_prompt')
                                                        ->with('myRewardsToken', $this->myRewardsToken)
                                                        ->with('myRewardsTokenExpirationAmount', $this->myRewardsTokenExpirationAmount)
                                                        ->with('myRewardsTokenExpiration', $this->myRewardsTokenExpiration);


        $edm_template_body_id = 6;
        $EdmTemplateBody = EdmTemplateBody::find($edm_template_body_id); 

        if($editpreview){

            $this->contentbody = $content;



            $this->contentbody = str_replace("{{name}}", $this->name ,$this->contentbody);
            $this->contentbody = str_replace("{{currentTier}}", $this->current_tier , $this->contentbody);
            $this->contentbody = str_replace("{{pointsToNextTier}}",  $this->point_to_next_tier  , $this->contentbody);
            $this->contentbody = str_replace("{{personal_growth_achievement_table}}",  $this->personal_growth_achievement_table , $this->contentbody);
            $this->contentbody = str_replace("{{balance_tokens_table}}",  $this->balance_tokens_table, $this->contentbody);
            $this->contentbody = str_replace("{{month}}",  $this->month, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersTokenUsed}}",  $this->recognizeOthersTokenUsed, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersToken}}",  $this->recognizeOthersToken, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersTokenExpiration}}",  $this->recognizeOthersTokenExpiration, $this->contentbody);
            $this->contentbody = str_replace("{{myRewardsToken}}",  $this->myRewardsToken, $this->contentbody);
            $this->contentbody = str_replace("{{myRewardsTokenUsed}}",  $this->myRewardsTokenUsed, $this->contentbody);

            $this->contentbody = str_replace("{{tokenexpirationprompt}}",  $this->token_expiration_prompt, $this->contentbody);
            $this->contentbody = str_replace("{{ACE e-Store}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceStoreLink."'>ACE e-Store</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{herehistorylink}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->historyLink."'>ACE</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{here_acelink}}", "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceurl."'>ACE</a>" , $this->contentbody);


            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

            
        }else{

            $this->contentbody = str_replace("{{name}}", $this->name ,$EdmTemplateBody->content);
            $this->contentbody = str_replace("{{currentTier}}", $this->current_tier , $this->contentbody);
            $this->contentbody = str_replace("{{pointsToNextTier}}",  $this->point_to_next_tier  , $this->contentbody);
            $this->contentbody = str_replace("{{personal_growth_achievement_table}}",  $this->personal_growth_achievement_table , $this->contentbody);
            $this->contentbody = str_replace("{{balance_tokens_table}}",  $this->balance_tokens_table, $this->contentbody);
            $this->contentbody = str_replace("{{month}}",  $this->month, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersTokenUsed}}",  $this->recognizeOthersTokenUsed, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersToken}}",  $this->recognizeOthersToken, $this->contentbody);
            $this->contentbody = str_replace("{{recognizeOthersTokenExpiration}}",  $this->recognizeOthersTokenExpiration, $this->contentbody);
            $this->contentbody = str_replace("{{myRewardsToken}}",  $this->myRewardsToken, $this->contentbody);
            $this->contentbody = str_replace("{{myRewardsTokenUsed}}",  $this->myRewardsTokenUsed, $this->contentbody);

            $this->contentbody = str_replace("{{tokenexpirationprompt}}",  $this->token_expiration_prompt, $this->contentbody);
            $this->contentbody = str_replace("{{ACE e-Store}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceStoreLink."'>ACE e-Store</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{herehistorylink}}",  "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->historyLink."'>ACE</a>" , $this->contentbody);
            $this->contentbody = str_replace("{{here_acelink}}", "<a style='color:#86BC25;text-decoration:none;' target='_blank' href='".$this->aceurl."'>ACE</a>" , $this->contentbody);


            $this->contentbody =  str_replace("<p>", "" ,$this->contentbody); 
            $this->contentbody =  str_replace("</p>", "<br>" ,$this->contentbody); 

        }

       


        $this->subjecttitle = str_replace(":month", $this->month ,$EdmTemplateBody->subject);


        switch ($data_url["domain"]){
            case 'deloitte-backend.local.nmgdev.com':
                $this->header1 = url($EdmTemplateBody->header1);
                $this->header2 = url($EdmTemplateBody->header2);
              
                break; 

            default:

                $this->header1 = secure_url($EdmTemplateBody->header1);
                $this->header2 = secure_url($EdmTemplateBody->header2);          
        }

        $this->headercontent1 = $EdmTemplateBody->header1;
        $this->headercontent2 = $EdmTemplateBody->header2;

        $this->locationdate =  str_replace("{{date}}", date('d F Y') ,$EdmTemplateBody->locationdate); 
        $this->locationdate =  str_replace("<p>", "" ,$this->locationdate); 
        $this->locationdate =  str_replace("</p>", "<br>" ,$this->locationdate); 

        $this->href1 = $EdmTemplateBody->href1;
        $this->href2 = $EdmTemplateBody->href2;    


        // if (! $isPreview) {

        //     event(new AdminLogEvent($user->id, AdminLog::TYPE_EDM_MONTHLYREPORT_EMAIL , [
                        
        //         'receiver_id' => $user->id,     
        //         'receiver_name' => $user->name,    
        //         'email_category' => 'Monthly Repoert'               
                
        //     ])); 

        // }



        $edmFileModel = new EdmFile;

        $edmFile = $edmFileModel->setAppends(['blade_path'])
            ->where([
                'edm_id' => Edm::TYPE_MONTHLY_SUMMARY,
                'is_active' => 1
            ])
            ->first();

        $this->tpl = $edmFile->blade_path;

        if (! $isPreview) {
            $edmLog = EdmLog::create([
                'type' => Edm::TYPE_MONTHLY_SUMMARY,
                'data' => [
                    'user' => $user,
                    'subject' => __('edm.monthly_summary.title', [ 'month' => $this->month ])
                ],
                
            ]);

            $this->webPreviewLink = str_replace('{uid}', $edmLog->uid, config('app.web_mail_preview'));
        }

    }

    protected function getUserNextMonthExpiredTokenAmount($user)
    {
        $amount =  0;
        try {

            $date = Carbon::now()->addMonths(1)->endOfMonth()->format('Y-m-d');

            $greentokenCredit =  GreenTokenLog::where('user_id','=', $user->id)
                ->where('action','=',1)
                ->where('expires_at', '<=',$date)->get()->sum('amount');

            $greentokenDebit =  GreenTokenLog::where('user_id','=', $user->id)
                ->where('action','=',0)
                ->get()->sum('amount');

            $this->output->writeln('date : ' .$date);
            $this->output->writeln('greentokenCredit : ' .$greentokenCredit);
            $this->output->writeln('greentokenDebit : ' .$greentokenDebit);
            if ($greentokenCredit +  $greentokenDebit > 0)
            {
                $amount = $greentokenCredit + $greentokenDebit;
            }

        } catch (\Exception $e) {


            $amount = 0;
        }

        return $amount;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        // return $this->subject(__('edm.monthly_summary.title', ['month' => $this->month]))
        return $this->subject($this->subjecttitle)
            ->view($this->tpl);
    }

    /**
     * Get current tier of user
     *
     * @param int $badgeCount
     * @return string
     */
    protected function getUserTier($badgeCount) {
        return ! $badgeCount ? "None"
            : ($badgeCount < 61 ? "Rising Star"
                : ($badgeCount < 241 ? "Shining Star"
                    : ($badgeCount < 481 ? "Shooting Star"
                        : ($badgeCount < 801 ? "Superstar"
                            : "Megastar"))));
    }

    /**
     * Get next tier of user
     *
     * @param int $badgeCount
     * @return string
     */
    protected function getNextTier($badgeCount) {
        return ! $badgeCount ? "Rising Star"
            : ($badgeCount < 61 ? "Shining Star"
                : ($badgeCount < 241 ? "Shooting Star"
                    : ($badgeCount < 481 ? "Superstar"
                        : "Megastar")));
    }

    protected function countToNextTier($badgeCount) {
        $nextTierMinimum = ! $badgeCount ? 1
            : ($badgeCount < 61 ? 61
                : ($badgeCount < 241 ? 241
                    : ($badgeCount < 481 ? 481
                        : 801)));

        return $nextTierMinimum - $badgeCount;
    }
}
