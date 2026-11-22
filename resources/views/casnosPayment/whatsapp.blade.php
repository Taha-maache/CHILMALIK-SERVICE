<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CASNOS WhatsApp Reminder</title>

    <style>
        :root {
            --ink: #0b3d2e;
            --paper: #f4faf6;
            --accent: #128c5e;
            --accent-dark: #0b6b46;
            --line: #c9dfd2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--paper);
            font-family: 'Segoe UI', Tahoma, sans-serif;
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
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(11, 61, 46, .06);
        }

        .eyebrow {
            font-size: 11px;
            letter-spacing: 2px;
            color: var(--accent-dark);
            direction: ltr;
            text-align: left;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 25px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .field {
            margin-bottom: 18px;
        }

        input, textarea {
            width: 100%;
            font-family: inherit;
            font-size: 15px;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fafdfb;
            color: var(--ink);
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        textarea {
            resize: vertical;
            min-height: 230px;
            line-height: 1.9;
        }

        .hint {
            font-size: 12px;
            color: #6b8479;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: var(--accent);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 7px;
        }

        button:hover {
            background: var(--accent-dark);
        }

        .error {
            color: #b3261e;
            font-size: 12px;
            margin-top: 5px;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: var(--accent-dark);
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="card">

    <p class="eyebrow">CASNOS · CLICK TO CHAT</p>

    <h1>إرسال تذكير عبر WhatsApp</h1>

    <div class="field">
        <label>رقم الهاتف</label>

        <input
            id="phone"
            type="text"
            value="{{ $phone }}"
            placeholder="213XXXXXXXXX"
            inputmode="tel"
        >

        <div class="hint">
            أدخل الرقم مع رمز الدولة 213.
        </div>

        <div class="error" id="phoneErr"></div>
    </div>

    <div class="field">
        <label>الرسالة</label>

        <textarea id="msg">السلام عليكم ورحمة الله وبركاته،

السيد(ة): {{ $payment->trader->first_name ?? '' }} {{ $payment->trader->last_name ?? '' }}

نود تذكيركم بأن لديكم مستحقات متبقية لدى صندوق الضمان الاجتماعي لغير الأجراء (CASNOS).

المبلغ المتبقي المستحق عليكم هو:
{{ number_format($remaining, 2, '.', '') }} دج.

نرجو منكم تسوية وضعيتكم قبل نهاية الشهر الجاري، تفادياً لتطبيق الزيادات المالية (Majoration) المترتبة عن التأخر في الدفع.

شكراً لتفهمكم وتعاونكم.

CHILCOM SERVICES</textarea>
    </div>

    <button type="button" id="sendBtn">
        فتح WhatsApp وإرسال التذكير
    </button>

    <a href="{{ route('casnos-payments.index') }}" class="back">
        العودة إلى قائمة CASNOS
    </a>

</div>

<script>
const phoneInput = document.getElementById('phone');
const msgInput = document.getElementById('msg');
const btn = document.getElementById('sendBtn');
const err = document.getElementById('phoneErr');

btn.addEventListener('click', function () {

    let phone = phoneInput.value.trim().replace(/\D/g, '');

    if (phone.startsWith('0')) {
        phone = '213' + phone.substring(1);
    }

    if (!phone.startsWith('213') || phone.length !== 12) {
        err.textContent = 'رقم الهاتف غير صحيح.';
        return;
    }

    err.textContent = '';

    const message = msgInput.value.trim();

    const url = 'https://wa.me/' + phone +
        '?text=' + encodeURIComponent(message);

    const whatsappWindow = window.open('', '_blank');

    if (!whatsappWindow) {
        alert('يرجى السماح بفتح النوافذ المنبثقة.');
        return;
    }

    btn.disabled = true;
    btn.textContent = 'جاري تسجيل التذكير...';

    fetch("{{ route('casnos-payments.whatsapp-reminder.sent', $payment->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save reminder');
        }

        return response.json();
    })
    .then(data => {
        if (data.success) {
            whatsappWindow.location.href = url;
            btn.textContent = 'تم تسجيل التذكير';
        } else {
            whatsappWindow.close();
            btn.disabled = false;
            btn.textContent = 'فتح WhatsApp وإرسال التذكير';
            alert(data.message || 'تعذر تسجيل التذكير.');
        }
    })
    .catch(error => {
        console.error(error);

        whatsappWindow.close();
        btn.disabled = false;
        btn.textContent = 'فتح WhatsApp وإرسال التذكير';

        alert('حدث خطأ أثناء تسجيل التذكير.');
    });
});
</script>

</body>
</html>