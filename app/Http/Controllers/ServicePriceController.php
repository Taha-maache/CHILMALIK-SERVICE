<?php

namespace App\Http\Controllers;

use App\Models\ServicePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicePriceController extends Controller
{
    private function catalog(): array
    {
        return [
            'sijil_moutanaiqil' => ['سجل متنقل', 11000],
            'naql_badaie' => ['نقل البضائع', 14000],
            'hanout' => ['محل تجاري', 15000],
            'sina3a' => ['الصناعة', 16000],
            'eljemla' => ['الجملة', 16000],
            'wakala' => ['وكالة', 2000],
            'nis' => ['NIS', 4800],
            'inapi' => ['INAPI', 11000],
            'logo_price' => ['الشعار Logo', 0],
            'coderbar_base' => ['Code-bar الأساسي', 11000],
            'coderbar_product' => ['Code-bar لكل منتج', 500],
            'moudirya_naql' => ['مديرية النقل', 5000],
            'tamdid_salahya' => ['تمديد الصلاحية', 18000],
            'istirad' => ['الاستيراد', 45000],
            'mosada9a_one' => ['المصادقة - وثيقة واحدة', 1500],
            'mosada9a_multiple' => ['المصادقة - أكثر من وثيقة (لكل وثيقة)', 1200],
            'ta3dil' => ['التعديل', 13000],
            'tarjama_register_1' => ['ترجمة السجل - النوع 1', 1800],
            'tarjama_register_2' => ['ترجمة السجل - النوع 2', 2400],
            'tarjamat_sawabi9' => ['ترجمة السوابق', 1400],
            'talab_c20' => ['طلب C20', 4000],
            'kachf_hisseb' => ['كشف الحساب', 3000],

            'creation_CA' => ['إنشاء CA', 11000],
            'creation_dplm_CA' => ['إنشاء DPLM CA', 11000],
            'annulation_CA' => ['إلغاء CA', 11000],
            'efficacite' => ['الفعالية', 30000],
            'tasmya' => ['التسمية', 1500],
            'tarjamat_boal' => ['ترجمة الوثائق', 3000],
            'ichhar_boal' => ['إشهار الوثائق', 10000],
            'creation_entreprise' => ['إنشاء مؤسسة', 45000],
            'chahedat_ihtiram' => ['شهادة احترام', 10000],
            'nif_alces' => ['NIF ALCS', 10000],
            'nif_dowan' => ['NIF Douane', 3000],
            'g50' => ['G50', 1000],
            'irg_salaire' => ['IRG salaire', 1000],
            'tva' => ['TVA', 1000],
            'khidma_ijer_mahal' => ['خدمة إيجار محل', 3000],
            'ta3dil_CA_base' => ['التعديل CA - السعر الأساسي', 11000],
            'ta3dil_CA_before_2025' => ['زيادة التعديل CA حتى 2024 لكل سنة', 300],
            'ta3dil_CA_from_2025' => ['زيادة التعديل CA من 2025 لكل سنة', 1000],

            'cnas_abattement' => ['CNAS Abattement', 15000],
            'cnas_sans_abattement' => ['CNAS Sans Abattement', 12000],
            'casnos' => ['CASNOS', 1500],
            'carte_chifa' => ['Carte Chifa', 500],
            'g12_price' => ['G12', 1200],
            'g12bis_price' => ['G12 Bis', 1200],
            'nif' => ['NIF', 800],
            'nif_plus_g08' => ['NIF + G08', 1000],
            'sijil_ramz_unit' => ['رمز السجل لكل وحدة', 240],

            'khatm_11' => ['الختم 11', 1400],
            'khatm_12' => ['الختم 12', 1700],
            'khatm_13' => ['الختم 13', 2100],
            'khatm_14' => ['الختم 14', 2900],
            'khatm_15' => ['الختم 15', 3500],
            'khatm_42' => ['الختم 42', 3200],
        ];
    }

    public function index()
    {
        $catalog = $this->catalog();

        foreach ($catalog as $key => [$label, $default]) {
            ServicePrice::firstOrCreate(
                ['key' => $key],
                ['label' => $label, 'price' => $default]
            );
        }

        $prices = ServicePrice::whereIn('key', array_keys($catalog))
            ->orderBy('id')
            ->get();

        return view('service-prices.index', compact('prices'));
    }

    public function update(Request $request)
    {
        $catalog = $this->catalog();

        $validated = $request->validate([
            'selected' => ['nullable', 'array'],
            'selected.*' => ['string', 'in:' . implode(',', array_keys($catalog))],
            'prices' => ['nullable', 'array'],
            'prices.*' => ['nullable', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        $selected = array_unique($validated['selected'] ?? []);
        $prices = $validated['prices'] ?? [];

        DB::transaction(function () use ($selected, $prices, $catalog) {
            foreach ($selected as $key) {
                if (!array_key_exists($key, $catalog)) {
                    continue;
                }

                if (!array_key_exists($key, $prices) || $prices[$key] === null || $prices[$key] === '') {
                    continue;
                }

                ServicePrice::where('key', $key)->update([
                    'price' => $prices[$key],
                ]);
            }
        });

        return redirect()
            ->route('service-prices.index')
            ->with('success', 'تم حفظ الأسعار المختارة بنجاح');
    }
}
