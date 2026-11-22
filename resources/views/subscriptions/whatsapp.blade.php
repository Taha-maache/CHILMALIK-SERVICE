
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WhatsApp - Subscription</title>

    <style>
        :root {
            --ink: #0b3d2e;
            --paper: #f4faf6;
            --accent: #128c5e;
            --accent-dark: #0b6b46;
            --line: #c9dfd2;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--paper);
            font-family: Arial, sans-serif;
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
        }

        .card {
            width: 100%;
            max-width: 500px;
            background: white;
            border: 1px solid var(--line);
            border-radius: 15px;
            padding: 28px;
            box-shadow: 0 5px 20px rgba(11, 61, 46, .08);
        }

        .eyebrow {
            font-size: 11px;
            letter-spacing: 1px;
            color: var(--accent-dark);
            margin-bottom: 8px;
        }

        h2 { margin: 0 0 10px; font-size: 22px; }

        .client {
            background: #f4faf6;
            border-radius: 9px;
            padding: 12px;
            margin: 18px 0;
            line-height: 1.9;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            margin-bottom: 16px;
        }

        textarea { min-height: 190px; resize: vertical; line-height: 1.8; }

        button, .back {
            display: block;
            width: 100%;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        button {
            background: var(--accent);
            color: white;
        }

        button:hover { background: var(--accent-dark); }

        .back {
            margin-top: 10px;
            background: #eef2f5;
            color: #344054;
        }

        .hint { color: #6b8479; font-size: 12px; margin-top: -10px; margin-bottom: 16px; }
        .error { color: #b3261e; font-size: 12px; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="card">
    <div class="eyebrow">CHILLCOM SERVICE · CLICK TO CHAT</div>

    <h2>
        {{ $type === 'balance' ? '💰 تذكير بتسوية المبلغ' : '🔄 تذكير بتجديد الاشتراك' }}
    </h2>

    <div class="client">
        <strong>الزبون:</strong> {{ $subscription->full_name }}<br>
        <strong>الهاتف:</strong> {{ $subscription->phone }}<br>

        @if($type === 'balance')
            <strong>المبلغ المتبقي:</strong>
            {{ number_format($remaining, 2, ',', ' ') }} DA
        @else
            <strong>نهاية الاشتراك:</strong> {{ $subscription->end_date }}
        @endif
    </div>

    <label for="phone">رقم الهاتف</label>
    <input
        id="phone"
        type="text"
        value="{{ $subscription->phone }}"
        inputmode="tel"
        placeholder="213XXXXXXXXX">

    <div class="hint">رقم جزائري مع رمز الدولة 213.</div>
    <div id="phoneErr" class="error"></div>

    <label for="msg">الرسالة</label>
    <textarea id="msg">{{ $message }}</textarea>

    <button type="button" id="sendBtn">فتح WhatsApp وإرسال الرسالة</button>

    <a href="{{ route('subscriptions.index') }}" class="back">
        ↩ الرجوع للاشتراكات
    </a>
</div>

<script>
const phoneInput = document.getElementById('phone');
const msgInput = document.getElementById('msg');
const btn = document.getElementById('sendBtn');
const err = document.getElementById('phoneErr');

btn.addEventListener('click', async function () {
    let phone = phoneInput.value.trim().replace(/\D/g, '');

    if (phone.startsWith('0')) {
        phone = '213' + phone.substring(1);
    }

    if (phone.startsWith('00213')) {
        phone = phone.substring(2);
    }

    if (!phone.startsWith('213') || phone.length !== 12) {
        err.textContent = 'رقم الهاتف الجزائري غير صحيح.';
        return;
    }

    err.textContent = '';

    const url = 'https://wa.me/' + phone
        + '?text=' + encodeURIComponent(msgInput.value.trim());

    // Open the WhatsApp tab directly from the click.
    const whatsappWindow = window.open(url, '_blank');

    if (!whatsappWindow) {
        err.textContent = 'المتصفح منع فتح النافذة. اسمح بالنوافذ المنبثقة ثم أعد المحاولة.';
        return;
    }

    btn.disabled = true;

    try {
        const response = await fetch(
            @json(route('subscriptions.whatsapp.sent', [
                'subscription' => $subscription->id,
                'type' => $type
            ])),
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            }
        );

        if (!response.ok) {
            throw new Error('Failed to save reminder');
        }

        const data = await response.json();

        if (!data.success) {
            throw new Error('Reminder not saved');
        }
    } catch (error) {
        console.error(error);
        alert('تم فتح WhatsApp، لكن تعذر تسجيل تاريخ التذكير في قاعدة البيانات.');
    } finally {
        btn.disabled = false;
    }
});
</script>

</body>
</html>
