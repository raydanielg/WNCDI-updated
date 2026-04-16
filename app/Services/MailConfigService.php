<?php

namespace App\Services;

use App\Models\MailSetting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public static function configure(): void
    {
        $settings = MailSetting::query()->first();

        if (!$settings) {
            return;
        }

        Config::set('mail.mailers.smtp', [
            'transport' => 'smtp',
            'host' => $settings->host ?? env('MAIL_HOST'),
            'port' => $settings->port ?? env('MAIL_PORT'),
            'encryption' => $settings->encryption ?? env('MAIL_ENCRYPTION'),
            'username' => $settings->username ?? env('MAIL_USERNAME'),
            'password' => $settings->password ?? env('MAIL_PASSWORD'),
            'timeout' => null,
        ]);

        Config::set('mail.from', [
            'address' => $settings->from_address ?? env('MAIL_FROM_ADDRESS'),
            'name' => $settings->from_name ?? env('MAIL_FROM_NAME'),
        ]);

        if ($settings->mailer) {
            Config::set('mail.default', $settings->mailer);
        }
    }
}
