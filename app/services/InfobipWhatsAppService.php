<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InfobipWhatsAppService
{
    public function sendTemplate(
        string $to,
        string $templateName,
        string $language,
        array $placeholders = []
    ) {
        $url = rtrim(config('services.infobip.base_url'), '/')
            . '/whatsapp/1/message/template';

        return Http::withHeaders([
            'Authorization' => 'App ' . config('services.infobip.api_key'),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post($url, [
            'messages' => [
                [
                    'from' => config('services.infobip.whatsapp_from'),

                    'to' => $to,

                    'messageId' => (string) Str::uuid(),

                    'content' => [
                        'templateName' => $templateName,

                        'templateData' => [
                            'body' => [
                                'placeholders' => $placeholders,
                            ],
                        ],

                        'language' => $language,
                    ],
                ],
            ],
        ]);
    }
}