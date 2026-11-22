<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Send via WhatsApp</title>

    <style>
        :root {
            --ink: #0b3d2e;
            --paper: #f4faf6;
            --accent: #128c5e;
            --accent-dark: #0b6b46;
            --line: #c9dfd2;
            --mono: 'JetBrains Mono', ui-monospace, Menlo, Consolas, monospace;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--paper);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--ink);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 32px 16px;
        }

        .card {
            width: 100%;
            max-width: 460px;

            background: #fff;

            border: 1px solid var(--line);
            border-radius: 14px;

            padding: 32px;

            box-shadow: 0 1px 3px rgba(11, 61, 46, 0.06);
        }

        .eyebrow {
            font-family: var(--mono);
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;

            color: var(--accent-dark);

            margin: 0 0 6px;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 24px;
        }

        label {
            display: block;

            font-size: 12px;
            font-weight: 600;

            color: #3c5c4f;

            margin: 0 0 6px;
        }

        .field {
            margin-bottom: 18px;
        }

        input,
        textarea {
            width: 100%;

            font-family: inherit;
            font-size: 15px;

            padding: 11px 12px;

            border: 1px solid var(--line);
            border-radius: 8px;

            background: #fafdfb;
            color: var(--ink);
        }

        input:focus,
        textarea:focus {
            outline: none;

            border-color: var(--accent);

            box-shadow: 0 0 0 3px rgba(18, 140, 94, 0.12);
        }

        textarea {
            resize: vertical;
            min-height: 90px;
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

            margin-top: 6px;
        }

        button:hover {
            background: var(--accent-dark);
        }

        .err {
            font-size: 12px;
            color: #b3261e;

            margin-top: 5px;

            min-height: 14px;
        }
    </style>
</head>

<body>

<div class="card">

    <p class="eyebrow">
        Click-to-chat
    </p>

    <h1>
        Send a WhatsApp message
    </h1>


    <!-- PHONE -->
<div class="field">

    <label for="phone">
        Contact's number
    </label>

    <input
        id="phone"
        type="text"
        value="{{ $credit->service->phone }}"
        placeholder="e.g. 213551234567"
        inputmode="tel"
    >

    <div class="hint">
        Include the country code. Example: 213551234567
    </div>

    <div
        class="err"
        id="phoneErr">
    </div>

</div>


<div class="field">

    <label for="msg">
        Message
    </label>

    <textarea
        id="msg"
        placeholder="Type what you want to say..."
    >السلام عليكم {{ $credit->service->full_name }}،

نود تذكيركم بأن المبلغ المتبقي المستحق عليكم هو:
{{ number_format($credit->remaining_amount, 2, '.', '') }} دج.

يرجى تسوية المبلغ المتبقي عند الإمكان.

شكرًا لتعاونكم.
(chilcom services)
</textarea>

</div>

    <!-- BUTTON -->

    <button
        type="button"
        id="sendBtn">

        Open in WhatsApp

    </button>

</div>
<script>

const phoneInput = document.getElementById('phone');
const msgInput = document.getElementById('msg');
const btn = document.getElementById('sendBtn');
const err = document.getElementById('phoneErr');

btn.addEventListener('click', function () {

    let phone = phoneInput.value.trim();

    // نحيو المسافات والرموز
    phone = phone.replace(/\D/g, '');

    // تحويل رقم الجزائر
    // 0674938966
    // إلى:
    // 213674938966
    if (phone.startsWith('0')) {
        phone = '213' + phone.substring(1);
    }

    // لازم يبدأ بـ 213
    if (!phone.startsWith('213')) {
        err.textContent = 'Invalid Algerian phone number.';
        return;
    }

    // رقم الجزائر = 12 digits
    if (phone.length !== 12) {
        err.textContent = 'Invalid phone number.';
        return;
    }

    err.textContent = '';

    const message = msgInput.value.trim();

    const url =
        'https://wa.me/' +
        phone +
        '?text=' +
        encodeURIComponent(message);

    console.log('WhatsApp number:', phone);
    console.log('WhatsApp URL:', url);

    /*
     * نفتح tab فارغ مباشرة
     * باش browser ما يمنعوش popup
     */
    const whatsappWindow = window.open('', '_blank');

    /*
     * نسجل أن WhatsApp reminder تبعث
     */
    fetch("{{ route('whatsapp.reminder.sent', ['id' => $credit->id]) }}", {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }

    })
    .then(response => {

        if (!response.ok) {
            throw new Error('Failed to save WhatsApp reminder.');
        }

        return response.json();

    })
    .then(data => {

        if (data.success) {

            /*
             * بعد ما نسجلو reminder
             * نوجه الـ tab إلى WhatsApp
             */
            whatsappWindow.location.href = url;

        } else {

            whatsappWindow.close();

            alert('Could not save WhatsApp reminder.');

        }

    })
    .catch(error => {

        console.error(error);

        whatsappWindow.close();

        alert('Error while sending WhatsApp.');

    });

});

</script>

</body>

</html>