<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'full_name', 'phone', 'address', 'is_subscriber',
        'sijil_moutanaiqil', 'sijil_ramz_count', 'naql_badaie', 'hanout', 'sina3a', 'eljemla', 'wakala',
        'casnos', 'carte_chifa', 'g12_price', 'g12bis_price', 'nif', 'nif_plus_g08', 'cnas_type',
        'nis', 'inapi', 'logo_price', 'coderbar', 'coderbar_products_count', 'moudirya_naql', 'khatm_type', 'service_date',
        'tamdid_salahya', 'istirad', 'mosada9a', 'ta3dil', 'tarjama_register',
        'tarjamat_sawabi9', 'talab_c20', 'kachf_hisseb', 'service_status',
        'creation_CA', 'creation_dplm_CA', 'annulation_CA', 'efficacite',
        'tasmya', 'tarjamat_boal', 'ichhar_boal', 'creation_entreprise',
        'chahedat_ihtiram', 'nif_alces', 'nif_dowan', 'g50', 'irg_salaire',
        'tva', 'khidma_ijer_mahal', 'ta3dil_CA', 'anne_de_modification',
        'number_of_galization',
    ];

    /**
     * حساب السعر الإجمالي للخدمة حسب الأسعار المحفوظة في قاعدة البيانات.
     */
    public function getTotalPriceAttribute()
    {
        $total = 0;

        // جلب السعر من service_prices، مع الاحتفاظ بالسعر القديم كقيمة افتراضية.
        $price = fn (string $key, float $default): float =>
            ServicePrice::getPrice($key, $default);

        // 1. الخدمات التي يدفع ثمنها الجميع
        if ($this->cnas_type == 1) {
            $total += $price('cnas_abattement', 15000);
        }

        if ($this->cnas_type == 2) {
            $total += $price('cnas_sans_abattement', 12000);
        }

        if ($this->sijil_moutanaiqil) {
            $total += $price('sijil_moutanaiqil', 11000);
        }

        if ($this->naql_badaie) {
            $total += $price('naql_badaie', 14000);
        }

        if ($this->hanout) {
            $total += $price('hanout', 15000);
        }

        if ($this->sina3a) {
            $total += $price('sina3a', 16000);
        }

        if ($this->eljemla) {
            $total += $price('eljemla', 16000);
        }

        if ($this->wakala) {
            $total += $price('wakala', 2000);
        }

        if ($this->nis) {
            $total += $price('nis', 4800);
        }

        if ($this->inapi) {
            $total += $price('inapi', 11000);
        }

        // يبقى logo_price كما هو لأنه سعر مخزّن في سجل الخدمة نفسه.
        $total += (float) $this->logo_price;

        if ($this->coderbar) {
            $total += $price('coderbar_base', 11000)
                + ((int) $this->coderbar_products_count * $price('coderbar_product', 500));
        }

        if ($this->moudirya_naql) {
            $total += $price('moudirya_naql', 5000);
        }

        if ($this->tamdid_salahya) {
            $total += $price('tamdid_salahya', 18000);
        }

        if ($this->istirad) {
            $total += $price('istirad', 45000);
        }

        if ($this->mosada9a == 1) {
            $total += $price('mosada9a_one', 1500);
        }

        if ($this->mosada9a > 1) {
            $total += $price('mosada9a_multiple', 1200) * $this->mosada9a;
        }

        if ($this->ta3dil) {
            $total += $price('ta3dil', 13000);
        }

        if ($this->tarjama_register == 1) {
            $total += $price('tarjama_register_1', 1800);
        }

        if ($this->tarjama_register == 2) {
            $total += $price('tarjama_register_2', 2400);
        }

        if ($this->tarjamat_sawabi9) {
            $total += $price('tarjamat_sawabi9', 1400);
        }

        if ($this->talab_c20) {
            $total += $price('talab_c20', 4000);
        }

        if ($this->kachf_hisseb) {
            $total += $price('kachf_hisseb', 3000);
        }

        // خدمات CA
        if ($this->creation_CA) {
            $total += $price('creation_CA', 11000);
        }

        if ($this->creation_dplm_CA) {
            $total += $price('creation_dplm_CA', 11000);
        }

        if ($this->annulation_CA) {
            $total += $price('annulation_CA', 11000);
        }

        if ($this->efficacite) {
            $total += $price('efficacite', 30000);
        }

        if ($this->tasmya) {
            $total += $price('tasmya', 1500);
        }

        if ($this->tarjamat_boal) {
            $total += $price('tarjamat_boal', 3000);
        }

        if ($this->ichhar_boal) {
            $total += $price('ichhar_boal', 10000);
        }

        if ($this->creation_entreprise) {
            $total += $price('creation_entreprise', 45000);
        }

        if ($this->chahedat_ihtiram) {
            $total += $price('chahedat_ihtiram', 10000);
        }

        if ($this->nif_alces) {
            $total += $price('nif_alces', 10000);
        }

        if ($this->nif_dowan) {
            $total += $price('nif_dowan', 3000);
        }

        if ($this->g50) {
            $total += $price('g50', 1000);
        }

        if ($this->irg_salaire) {
            $total += $price('irg_salaire', 1000);
        }

        if ($this->tva) {
            $total += $price('tva', 1000);
        }

        if ($this->khidma_ijer_mahal) {
            $total += $price('khidma_ijer_mahal', 3000);
        }

        // Ta3dil CA: السعر الأساسي والزيادة حسب السنوات
        if ($this->ta3dil_CA) {
            $total += $price('ta3dil_CA_base', 11000);

            if ($this->anne_de_modification) {
                $anneeDebut = (int) $this->anne_de_modification;
                $anneeActuelle = now()->year;

                for ($annee = $anneeDebut; $annee <= $anneeActuelle; $annee++) {
                    if ($annee <= 2024) {
                        $total += $price('ta3dil_CA_before_2025', 300);
                    } else {
                        $total += $price('ta3dil_CA_from_2025', 1000);
                    }
                }
            }
        }

        // Khatm / Galization
        $khatmPrices = [
            'بدون ختم' => 0,
            '11' => $price('khatm_11', 1400),
            '12' => $price('khatm_12', 1700),
            '13' => $price('khatm_13', 2100),
            '14' => $price('khatm_14', 2900),
            '15' => $price('khatm_15', 3500),
            '42' => $price('khatm_42', 3200),
        ];

        $khatmPrice = $khatmPrices[(string) $this->khatm_type] ?? 0;
        $numberOfGalization = $this->number_of_galization ?? 1;

        $total += $khatmPrice * $numberOfGalization;

        // 2. الضرائب: المشترك معفى منها
        if (!$this->is_subscriber) {
            if ($this->casnos) {
                $total += $price('casnos', 1500);
            }

            if ($this->carte_chifa) {
                $total += $price('carte_chifa', 500);
            }

            if ($this->g12_price) {
                $total += $price('g12_price', 1200);
            }

            if ($this->g12bis_price) {
                $total += $price('g12bis_price', 1200);
            }

            if ($this->nif) {
                $total += $price('nif', 800);
            }

            if ($this->nif_plus_g08) {
                $total += $price('nif_plus_g08', 1000);
            }
        }

        // سعر كل وحدة من sijil_ramz
        $total += ((int) $this->sijil_ramz_count * $price('sijil_ramz_unit', 240));

        return $total;
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function getSubscriptionStatusAttribute()
    {
        if (!$this->abonnement_end) {
            return 'not_subscribed';
        }

        if ($this->abonnement_end < now()) {
            return 'expired';
        }

        return 'active';
    }

    public function credit()
    {
        return $this->hasOne(Credit::class);
    }
}
