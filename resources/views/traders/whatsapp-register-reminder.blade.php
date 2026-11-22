 @extends('layouts.app')

@section('content')

@php
    $phone = preg_replace('/\D+/', '', (string) $trader->phone);

    if (str_starts_with($phone, '0')) {
        $phone = '213' . substr($phone, 1);
    } elseif (str_starts_with($phone, '213')) {
        // الرقم فيه مفتاح الجزائر مسبقًا
    } elseif (strlen($phone) === 9) {
        $phone = '213' . $phone;
    }

    $message = "السلام عليكم " . $trader->first_name . " " . ($trader->last_name ?? '') . "،\n\n"
        . "نعلمكم أن السجل التجاري الخاص بكم أصبح جاهزًا للاستلام.\n"
        . "يرجى التفضل بالحضور إلى المكتب لاستلامه.\n\n"
        . "شكرًا على ثقتكم بنا CHILLCOM Service.";
@endphp

<div class="container py-5" dir="rtl">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 650px; border-radius: 16px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="mb-3 text-success" style="font-size: 3rem;">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h4 class="fw-bold">تذكير باستلام السجل التجاري</h4>

                <p class="text-muted mb-0">
                    {{ $trader->first_name }} {{ $trader->last_name }}
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">رقم الهاتف</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $trader->phone ?? '' }}"
                    readonly
                >
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">الرسالة الجاهزة</label>
                <textarea
                    id="whatsappMessage"
                    class="form-control"
                    rows="7"
                    readonly
                >{{ $message }}</textarea>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button
                    type="button"
                    id="sendReminder"
                    class="btn btn-success flex-grow-1 py-2"
                    data-url="{{ route('traders.whatsapp-register-reminder.sent', $trader->id) }}"
                    data-phone="{{ $phone }}"
                >
                    <i class="fab fa-whatsapp me-1"></i>
                    فتح WhatsApp وتسجيل التذكير
                </button>

                <a href="{{ route('traders.index') }}" class="btn btn-outline-secondary py-2">
                    رجوع
                </a>
            </div>

            <div id="reminderError" class="alert alert-danger mt-3 d-none"></div>

            <p class="text-muted small mt-3 mb-0">
                ملاحظة: بعد فتح WhatsApp، راجع الرسالة واضغط إرسال بنفسك.
            </p>

        </div>
    </div>
</div>

<script>
document.getElementById('sendReminder').addEventListener('click', async function () {
    const button = this;
    const phone = button.dataset.phone;
    const url = button.dataset.url;
    const message = document.getElementById('whatsappMessage').value;
    const errorBox = document.getElementById('reminderError');

    errorBox.classList.add('d-none');
    errorBox.textContent = '';

    if (!phone || !phone.startsWith('213') || phone.length !== 12) {
        errorBox.textContent = 'رقم الهاتف غير صالح. صحّح رقم التاجر قبل المتابعة.';
        errorBox.classList.remove('d-none');
        return;
    }

    // نفتح نافذة مباشرة من نقرة المستخدم لتقليل احتمال منعها.
    const whatsappTab = window.open('about:blank', '_blank');

    if (!whatsappTab) {
        errorBox.textContent = 'المتصفح منع فتح نافذة جديدة. اسمح بالنوافذ المنبثقة ثم أعد المحاولة.';
        errorBox.classList.remove('d-none');
        return;
    }

    button.disabled = true;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'تعذّر تسجيل التذكير.');
        }

        const whatsappUrl =
            'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);

        whatsappTab.location.href = whatsappUrl;

        button.textContent = 'تم تسجيل التذكير';
        button.disabled = true;

    } catch (error) {
        whatsappTab.close();

        errorBox.textContent = error.message || 'حدث خطأ. حاول مرة أخرى.';
        errorBox.classList.remove('d-none');

        button.disabled = false;
    }
});
</script>

@endsection