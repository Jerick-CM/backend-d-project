<?php

namespace App\Console\Commands;

use App\Mail\MonthlySummaryMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:monthly_summary {uid?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly summary to users';

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
        $uid = $this->argument('uid');

        if ($uid) {
            return $this->sendMonthlySummaryMail(User::find($uid));
        }

        $users = User::get();

        foreach ($users as $user) {
            if ($user->is_active != 0) {
                $this->sendMonthlySummaryMail($user);
            }
        }
    }

    /**
     * Send monthly summary mail
     *
     * @return void
     */
    protected function sendMonthlySummaryMail($user)
    {

        $this->output->writeln('email id: ' .$user->email);
        try {
            Mail::to($user->email)->send(new MonthlySummaryMail($user));
        }
        catch (\Exception $e)
        {
            $this->output->writeln($e);
        }
    }
}
