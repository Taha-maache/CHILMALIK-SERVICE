<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Services\InfobipWhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendCreditRetardWhatsApp extends Command
{
    protected $signature = 'whatsapp:credit-retard';

    protected $description = 'Send WhatsApp reminders for overdue credits';

    public function handle(InfobipWhatsAppService $whatsapp)
    {
        $services = Service::whereHas('credit', function ($query) {
            $query->whereHas('payments');
        })
        ->with([
            'credit.payments' => function ($query) {
                $query->orderByDesc('payment_date');
            }
        ])
        ->get();

        $sent = 0;
        $skipped = 0;

        foreach ($services as $service) {

            $credit = $service->credit;

            /*
            |--------------------------------------------------------------------------
            | 1. Credit موجود
            |--------------------------------------------------------------------------
            */

            if (!$credit) {
                $skipped++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 2. لازم يبقى عليه مبلغ
            |--------------------------------------------------------------------------
            */

            if ($credit->remaining_amount <= 0) {
                $skipped++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 3. نجيبو آخر paiement
            |--------------------------------------------------------------------------
            */

            $lastPayment = $credit->payments->first();

            if (!$lastPayment || !$lastPayment->payment_date) {
                $skipped++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 4. لازم يكون فات 3 أيام على آخر paiement
            |--------------------------------------------------------------------------
            */

            $lastPaymentDate = Carbon::parse($lastPayment->payment_date);

            if ($lastPaymentDate->gt(
                Carbon::now()->subDays(3)
            )) {
                $skipped++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 5. إذا بعثنا reminder من قبل
            |--------------------------------------------------------------------------
            */

            if ($credit->last_whatsapp_reminder_at) {

                $lastReminder = Carbon::parse(
                    $credit->last_whatsapp_reminder_at
                );

                /*
                | إذا مازال ما دارش paiement جديد،
                | ما نعاودوش نبعثولو.
                */

                if ($lastReminder->gte($lastPaymentDate)) {
                    $skipped++;
                    continue;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 6. رقم الهاتف
            |--------------------------------------------------------------------------
            */

            $phone = $service->phone;

            if (!$phone) {

                $this->warn(
                    "Service #{$service->id}: no phone number"
                );

                $skipped++;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 7. تنظيف رقم الهاتف
            |--------------------------------------------------------------------------
            */

            $phone = preg_replace('/\D/', '', $phone);

            if (str_starts_with($phone, '0')) {
                $phone = '213' . substr($phone, 1);
            }

            /*
            |--------------------------------------------------------------------------
            | 8. إرسال WhatsApp
            |--------------------------------------------------------------------------
            */

            try {

                $response = $whatsapp->sendTemplate(
                    $phone,
                    config('services.infobip.template'),
                    config('services.infobip.language'),
                    [
                        $service->full_name,
                        Carbon::parse($lastPayment->payment_date)
                            ->format('d/m/Y'),
                        Carbon::now()->format('H:i'),
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | 9. إذا Infobip قبلت الإرسال
                |--------------------------------------------------------------------------
                */

                if ($response->successful()) {

                    $credit->update([
                        'last_whatsapp_reminder_at' => now(),
                    ]);

                    $this->info(
                        "WhatsApp sent → Service #{$service->id}"
                    );

                    $sent++;

                } else {

                    $this->error(
                        "WhatsApp failed → Service #{$service->id}"
                    );

                    $this->error(
                        $response->body()
                    );

                    $skipped++;
                }

            } catch (\Throwable $e) {

                $this->error(
                    "Error Service #{$service->id}: "
                    . $e->getMessage()
                );

                $skipped++;
            }
        }

        $this->newLine();

        $this->info("Sent: {$sent}");
        $this->info("Skipped: {$skipped}");

        return Command::SUCCESS;
    }
}