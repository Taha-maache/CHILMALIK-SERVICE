@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="card shadow-sm border-0 mx-auto" style="max-width:650px;border-radius:16px;">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <i class="fab fa-whatsapp text-success" style="font-size:55px;"></i>
                <h4 class="fw-bold mt-2">إرسال تذكير CASNOS</h4>
                <p class="text-muted">
                    {{ $client->nom }} {{ $client->prenom }}
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">رقم الهاتف</label>
                <input type="text"
                       id="phone"
                       class="form-control"
                       value="{{ $phone }}"
                       dir="ltr">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">الرسالة</label>

                <textarea id="message"
                          class="form-control"
                          rows="9"
                          dir="rtl">السلام عليكم ورحمة الله وبركاته،

السيد(ة): {{ $client->nom }} {{ $client->prenom }}

نود تذكيركم بأن المبلغ المتبقي المستحق عليكم لدى CASNOS هو:

{{ number_format($remaining, 2, '.', '') }} دج

نرجو منكم تسوية المبلغ المتبقي في أقرب وقت ممكن، تفادياً للزيادات والغرامات.

شكراً على حسن تعاونكم.
CHILMALIK : SERVICE</textarea>
            </div>

            <button type="button"
                    id="sendWhatsapp"
                    class="btn btn-success w-100 py-2 fw-bold">
                <i class="fab fa-whatsapp"></i>
                فتح WhatsApp وإرسال التذكير
            </button>

            <a href="{{ route('casnos.index') }}"
               class="btn btn-light w-100 mt-2">
                رجوع
            </a>

        </div>
    </div>

</div>

<script>
document.getElementById('sendWhatsapp').addEventListener('click', async function () {

    let phone = document.getElementById('phone').value.trim();
    let message = document.getElementById('message').value.trim();

    // تنظيف رقم الهاتف
    phone = phone.replace(/\D/g, '');

    // تحويل 0 إلى 213
    if (phone.startsWith('0')) {
        phone = '213' + phone.substring(1);
    }

    if (!phone.startsWith('213') || phone.length !== 12) {
        alert('يرجى إدخال رقم هاتف جزائري صحيح.');
        return;
    }

    if (!message) {
        alert('الرسالة فارغة.');
        return;
    }

    // فتح نافذة WhatsApp
    const whatsappWindow = window.open('about:blank', '_blank');

    if (!whatsappWindow) {
        alert('يرجى السماح بفتح النوافذ المنبثقة في المتصفح.');
        return;
    }

    this.disabled = true;
    this.innerHTML = 'جاري التحضير...';

    try {

        const response = await fetch(
            "{{ route('casnos.whatsapp-reminder.sent', $client->id) }}",
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }
        );

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'حدث خطأ أثناء تسجيل التذكير.');
        }

        const url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);

        whatsappWindow.location.href = url;

        alert('تم تسجيل التذكير وفتح WhatsApp.');

        window.location.href = "{{ route('casnos.index') }}";

    } catch (error) {

        whatsappWindow.close();

        alert(error.message);

        this.disabled = false;
        this.innerHTML = '<i class="fab fa-whatsapp"></i> فتح WhatsApp وإرسال التذكير';
    }
});
</script>
@endsection