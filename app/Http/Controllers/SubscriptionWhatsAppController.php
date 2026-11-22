<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionWhatsAppController extends Controller
{
    public function show(Subscription $subscription, string $type)
    {
        abort_unless(in_array($type, ['balance', 'renewal'], true), 404);

        $subscription->load('payments');

        $totalAmount = (float) $subscription->total_amount;
        $totalPaid = (float) $subscription->payments->sum('amount');
        $remaining = max(0, $totalAmount - $totalPaid);

        if ($type === 'balance') {
            abort_if($remaining <= 0, 404);

            $message = "السلام عليكم {$subscription->full_name}،\n\n"
                . "نود تذكيركم بأن المبلغ المتبقي من اشتراككم هو:\n"
                . number_format($remaining, 2, '.', '') . " دج.\n\n"
                . "يرجى تسوية المبلغ المتبقي عند الإمكان.\n\n"
                . "شكراً لتعاونكم.\n"
                . "(CHILLCOM SERVICE)";
        } else {
            $message = "السلام عليكم {$subscription->full_name}،\n\n"
                . "نود تذكيركم بقرب انتهاء اشتراككم بتاريخ "
                . $subscription->end_date . ".\n\n"
                . "يرجى التواصل معنا لتجديد الاشتراك ومواصلة الاستفادة من خدماتنا.\n\n"
                . "شكراً لثقتكم.\n"
                . "(CHILLCOM SERVICE)";
        }

        return view('subscriptions.whatsapp', compact(
            'subscription',
            'type',
            'message',
            'remaining'
        ));
    }

    public function sent(Request $request, Subscription $subscription, string $type)
    {
        abort_unless(in_array($type, ['balance', 'renewal'], true), 404);

        $column = $type === 'balance'
            ? 'last_whatsapp_balance_reminder_at'
            : 'last_whatsapp_renewal_reminder_at';

        $subscription->forceFill([
            $column => now(),
        ])->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
