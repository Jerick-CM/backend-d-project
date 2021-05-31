<?php

namespace App\Http\Controllers;

use App\Mail\NominationRecipientMail;
use App\Mail\NominationSenderMail;

use App\Mail\RedeemMail;

use App\Mail\WelcomeMail;
use App\Mail\NominationTierPromotionMail; 
use App\Mail\UniversalMail; 
use App\Mail\MonthlySummaryMail;
use App\Mail\MassTokenUpdateMail;

use App\Models\EdmTemplateBody;
use App\Models\Badge;
use App\Models\Inventory;
use App\Models\User;
use Faker\Generator as Faker;

class BaseEdmController extends Controller
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    protected function generateSendPreview(
        $user_id,
        $message = null,
        $badge_id = null,
        $recipient_id = null,
        $token = null,
        $isPreview = false,
        $hastoken = false,
        $editpreview ,
        $content

    ) {
        $user = User::find($user_id);
        
        if (! is_null($message)) {
            $message = $message;
        } else {
            $message = $this->faker->text(250);
        }

        if (! is_null($badge_id)) {
            $badge = Badge::find($badge_id);
        } else {
            $badge = Badge::inRandomOrder()->first();
        }

        if (! is_null($recipient_id)) {
            $recipient = User::find($recipient_id);
        } else {
            $recipient = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        }

        if($hastoken){

            if (! is_null($token)) {
                $token = $token;

            } else {
               
                $token = rand(1, 5) * 5;
   
            }
        }else{
             $token = NULL; 
         }

        $date = date('d F Y');
        $time = date('h:i A');

        return new NominationSenderMail($user, $recipient, $message, $badge, $token, $date, $time, $isPreview, $editpreview,$content);
    }

    protected function generateReceivePreview(
        $user_id,
        $message = null,
        $badge_id = null,
        $sender_id = null,
        $token = null,
        $isPreview = false,
        $hastoken = false,
        $editpreview ,
        $content
    ) {
        $user = User::find($user_id);
        
        if (! is_null($message)) {
            $message = $message;
        } else {
            $message = $this->faker->text(250);
        }

        if (! is_null($badge_id)) {
            $badge = Badge::find($badge_id);
        } else {
            $badge = Badge::inRandomOrder()->first();
        }

        if (! is_null($sender_id)) {
            $sender = User::find($sender_id);
        } else {
            $sender = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        }

        if($hastoken){

            if (! is_null($token)) {
                $token = $token;

            } else {
               
                $token = rand(1, 5) * 5;
   
            }
        }else{
             $token = NULL; 
         }

        $date = date('d F Y');
        $time = date('h:i A');

        return new NominationRecipientMail($user, $sender, $message, $badge, $token, $date, $time, $isPreview,  $editpreview ,
        $content);
    }

    protected function generateRedeemPreview($user_id, $orderItems = null, $isPreview = false,$editpreview,$message)
    {
        $user = User::find($user_id);

        if (! is_null($orderItems)) {
            $orderItems = $this->mapOrderItems($orderItems);
        } else {
            $orderItems = $this->generateRedeemPreviewOrderItems();
        }

        $totalTokens = $this->calcOrderItemsTotal($orderItems);

        $orderNumber = str_pad(rand(0, 9999999999), 10, STR_PAD_LEFT);

        $date = date('d F Y');
        $orderDate = date('d F Y h:i A');
        $collectionDate = date('d F Y');

        return new RedeemMail(
            $user,
            $orderItems,
            $totalTokens,
            $orderNumber,
            $date,
            $orderDate,
            $collectionDate,
            $isPreview,
            $editpreview,
            $message
        );
    }


    protected function generateWelcomePreview(
        $user_id,
        $message = null,
        $badge_id = null,
        $sender_id = null,
        $token = null,
        $isPreview = false,
        $hastoken = false,
        $editpreview
    ) {

        $user = User::find($user_id);
        

        if (! is_null($badge_id)) {
            $badge = Badge::find($badge_id);
        } else {
            $badge = Badge::inRandomOrder()->first();
        }

        if (! is_null($sender_id)) {
            $sender = User::find($sender_id);
        } else {
            $sender = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        }

        if($hastoken){

            if (! is_null($token)) {
                $token = $token;

            } else {
               
                $token = rand(1, 5) * 5;
   
            }
        }else{
             $token = NULL; 
         }

        $date = date('d F Y');
        $time = date('h:i A');


        return new WelcomeMail($user, $token, $date,$isPreview = false,$editpreview,$message);
    }


    protected function generateTierPromotionPreview(
        $user_id,
        $message = null,
        $badge_id = null,
        $recipient_id = null,
        $token = null,
        $isPreview = false,
        $hastoken = false,
        $editpreview
    ) {
        $user = User::find($user_id);
        
        if (! is_null($message)) {
            $message = $message;
        } else {
            $message = $this->faker->text(250);
        }

        if (! is_null($badge_id)) {
            $badge = Badge::find($badge_id);
        } else {
            $badge = Badge::inRandomOrder()->first();
        }

        if (! is_null($recipient_id)) {
            $recipient = User::find($recipient_id);
        } else {
            $recipient = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        }

        if($hastoken){

            if (! is_null($token)) {
                $token = $token;

            } else {
               
                $token = rand(1, 5) * 5;
   
            }
        }else{
             $token = NULL; 
         }

        $date = date('d F Y');
        $time = date('h:i A');

        /*
            tiers:
            Rising Star
            Shining Star
            Shooting Star
            Super Star
            Megastar
        */

        switch(rand(1, 4)){

            case 1:
                $tierold = 'Rising Star';
                $tiernew = 'Shining Star';
                $tiernext = 'Shooting Star';
                $messagerewardstoken = 10;
            break;
            case 2:
                $tierold = 'Shining Star';
                $tiernew = 'Shooting Star';
                $tiernext = 'Super Star';
                $messagerewardstoken = 20;
            break;
            case 3:
                $tierold = 'Shooting Star';
                $tiernew = 'Super Star';
                $tiernext = 'Megastar';
                $messagerewardstoken = 30;
            break;
            case 4:
                $tierold = 'Super Star';
                $tiernew = 'Megastar';
                $tiernext = '';
                $messagerewardstoken = 40;
            break;       
        }
       
        // $tiernext = '';
        

        return new NominationTierPromotionMail($user, $sender = $user, $message, $badge, $token, $date, $time, $isPreview , $tierold,$tiernew, $messagerewardstoken,$tiernext,$editpreview);
        
    }

    protected function generateUniversalPreview(

        $user_id,
        $email,
        $isPreview = false,    
        $edm_templatebody_id,
        $admin,
        $editpreview,
        $message

    ) {

        $EdmTemplateBody = EdmTemplateBody::find($edm_templatebody_id);

        $user = User::find($user_id);

        $date = date('d F Y');
        return new   UniversalMail($user,$email,$date,$isPreview, $edm_templatebody_id, $admin, $editpreview,
        $message);
        
    }

    protected function generatemasstokenupdatePreview(

        $user_id,
        $email,
        $isPreview = false,    
        $edm_templatebody_id,
        $admin,
        $message,
        $RO_deduct,
        $RO_add,
        $MR_deduct,
        $MR_add,
        $editpreview,
        $content

    ) {

        $EdmTemplateBody = EdmTemplateBody::find($edm_templatebody_id);

        $user = User::find($user_id);

        $date = date('d F Y');

        if (! is_null($message)) {
            $message = $message;
        } else {
          
            $message = $this->faker->text(250);             
            
        }

        if (! is_null($RO_deduct)) {

            $RO_deduct = $RO_deduct;

        } else {
           
            $RO_deduct = rand(1, 5) * 5;

        }


        if (! is_null($RO_add)) {
            
            $RO_add = $RO_add;

        } else {
           
            $RO_add = rand(1, 5) * 5;

        }


         if (! is_null($MR_deduct)) {
            
            $MR_deduct = $MR_deduct;

        } else {
           
            $MR_deduct = rand(1, 5) * 5;

        }


        if (! is_null($MR_add)) {
            
            $MR_add = $MR_add;

        } else {
           
            $MR_add = rand(1, 5) * 5;

        }
        return new  MassTokenUpdateMail($user,$email,$date,$isPreview, $edm_templatebody_id, $admin,$message,$RO_deduct,$RO_add,$MR_deduct,$MR_add,$editpreview,$content);
        
    }

    protected function generateMonthlySummaryPreview(
        $user_id,
        $message = null,
        $badge_id = null,
        $recipient_id = null,
        $token = null,
        $isPreview = false,
        $hastoken = false,
        $content,
        $editpreview
    ) {
        $user = User::find($user_id);
        
        if (! is_null($message)) {
            $message = $message;
        } else {
            $message = $this->faker->text(250);
        }

        if (! is_null($badge_id)) {
            $badge = Badge::find($badge_id);
        } else {
            $badge = Badge::inRandomOrder()->first();
        }

        if (! is_null($recipient_id)) {
            $recipient = User::find($recipient_id);
        } else {
            $recipient = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        }

        if($hastoken){

            if (! is_null($token)) {
                $token = $token;

            } else {
               
                $token = rand(1, 5) * 5;
   
            }
        }else{
             $token = NULL; 
         }

        $date = date('d F Y');
        $time = date('h:i A');
        return new MonthlySummaryMail($user, $isPreview,$content,$editpreview);
        // return new NominationSenderMail($user, $recipient, $message, $badge, $token, $date, $time, $isPreview);
    }

    protected function mapOrderItems($orderItems)
    {
        $result = [];

        foreach ($orderItems as $oi) {
            $inventory = Inventory::find($oi['inventory_id']);

            $qty = $oi['quantity'];

            $result[] = [
                'inventory' => $inventory,
                'quantity' => $qty,
                'tokens' => $inventory->unit_price * $qty,
            ];
        }

        return $result;
    }

    protected function calcOrderItemsTotal($orderItems)
    {
        $totalTokens = 0;

        foreach ($orderItems as $oi) {
            $totalTokens += $oi['tokens'];
        }

        return $totalTokens;
    }

    protected function generateRedeemPreviewOrderItems()
    {
        $noOfItems = rand(1, 3);

        $itemIDs = [];

        $orderItems = [];

        $totalTokens = 0;

        for ($i = 0; $i < $noOfItems; $i++) {
            $inventory = Inventory::whereNotIn('id', $itemIDs)->inRandomOrder()->first();

            $itemIDs[] = $inventory->id;

            $qty = rand(1, 2);

            $orderItems[] = [
                'inventory' => $inventory,
                'quantity' => $qty,
                'tokens' => $inventory->unit_price * $qty,
            ];

            $totalTokens += $inventory->unit_price * $qty;
        }

        return $orderItems;
    }
}
