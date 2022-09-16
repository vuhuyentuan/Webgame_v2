<?php

namespace App\Jobs;

use App\Mail\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $data = $this->data;
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => 'smtp.googlemail.com',
                'mail.mailers.smtp.port' => 465,
                'mail.mailers.smtp.encryption' => 'ssl',
                'mail.mailers.smtp.username' => json_decode($data['setting']->email_configuration)->email,
                'mail.mailers.smtp.password' => json_decode($data['setting']->email_configuration)->password,
                'mail.from.address' => json_decode($data['setting']->email_configuration)->email,
                'mail.from.name' => json_decode($data['setting']->email_configuration)->app_name,
            ]);
            Mail::to($data['email'])->send(new ResetPassword($data['email'], $data['url']));
        } catch (\Throwable $e) {;
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        }
    }
}
