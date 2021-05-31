<?php

namespace App\Console\Commands;

use App\Events\GreenTokenLogEvent;
use App\Models\User;
use App\Models\GreenTokenLog;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ExpireGreenTokens extends Command
{

    const WELCOME_TOKEN_AMOUNT = 10;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set expired tokens';


    protected $output;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $users = User::where('is_active', 1)
            ->where('green_token','>', 0)
            ->get();

        $date   = Carbon::now()->format('d F Y');
        $this->output->writeln('date: ' .$date);
        foreach ($users as $user) {

             $amount = $this->getUserExpiredTokenAmount($user);

             if ($amount != 0)
                $this->updateUserTokenExpired($user,$amount);

//            if ($is_sent === true && config('cron.send_welcome_email')) {
//                Mail::to($user->email)->send(new WelcomeMail($user, $tokens, $date));
//            }
        }
    }


    protected function getUserExpiredTokenAmount($user)
    {
        $amount =  0;
        try {

            $date   = Carbon::now()->format('Y-m-d');

            $greentokenCredit =  GreenTokenLog::where('user_id','=', $user->id)
                ->where('action','=',1)
                ->where('expires_at', '<=',$date)->get()->sum('amount');

            $greentokenDebit =  GreenTokenLog::where('user_id','=', $user->id)
                ->where('action','=',0)
                ->get()->sum('amount');

            $this->output->writeln('user id: ' .$user->id);

            $this->output->writeln("greentokenCredit :" . $greentokenCredit);

            $this->output->writeln("greentokenDebit :" . $greentokenDebit);

            if ($greentokenCredit +  $greentokenDebit > 0)
            {
                $amount = $greentokenCredit + $greentokenDebit;
            }

        } catch (\Exception $e) {

            $this->output->writeln($e);
            $amount = 0;
        }

        return $amount;
    }

    /**
     * Send the welcome token to a single user
     */
    protected function updateUserTokenExpired($user, $amount)
    {
        try {
            DB::beginTransaction();

            event(new GreenTokenLogEvent(
                $user->id,
                GreenTokenLog::ACTION_DEBIT,
                GreenTokenLog::TYPE_EXPIRED,
                - $amount,
                "Expired",
                $user->id
            ));

//            User::where('id', $user->id)->update([
//                'has_received_welcome_tokens' => true,
//            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
