<?php

namespace App\Utilities;

use App\Jobs\ProcessMail;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendMail
{
    public static function welcomeMail(object $user)
    {
        // Send mail-----------------
        if ($user->email && getAdminSetting('mail_notification')) {
            $array['view'] = 'content.emails.welcome_mail';
            $array['subject'] = "Welcome to " . config('app.name');
            $array['name'] = $user->name ?? $user->username;
            $array['to'] = $user->email;

            $content =  "Welcome to " . config('app.name') . "!";
            $content .= " You have registered successfully on  <a href='" . route('home') . "'>" . config('app.name') . "</a> at " . date('h:ia d M Y') . " (" . config('app.timezone') . "). <br> <br>Thank you!";

            $array['content'] = $content;

            if (getAdminSetting('queue_work')) {
                ProcessMail::dispatch($array)
                    ->delay(now()->addSeconds(5));
            } else {
                Config::set('queue.default', 'sync');
                Mail::to($array['to'])->queue(new NotificationMail($array));
            }
        }
    }
}
