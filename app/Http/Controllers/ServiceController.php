<?php

namespace App\Http\Controllers;

use App\Services\InfobipWhatsAppService;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Models\Credit;
use App\Models\CreditPayment;
use Carbon\Carbon;
use App\Models\Respecte;
use App\Models\Client;
use App\Models\ServicePrice;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $services = $query->latest()->paginate(1000);

        $clientsChart = Service::select(
            DB::raw('service_date as day'),
            DB::raw('COUNT(*) as total')
        )
            ->whereNotNull('service_date')
            ->groupBy('service_date')
            ->orderByDesc('service_date')
            ->limit(5)
            ->get()
            ->reverse()
            ->values();

        $revenusChart = Service::whereNotNull('service_date')
            ->orderByDesc('service_date')
            ->get()
            ->groupBy('service_date')
            ->take(5)
            ->map(function ($items, $day) {
                return [
                    'day' => $day,
                    'total' => $items->sum(fn ($service) => $service->total_price),
                ];
            })
            ->reverse()
            ->values();

        $totalServices = Service::count();

        $totalRevenue = Service::all()->sum(
            fn ($service) => $service->total_price
        );

        $totalSubscribers = Service::where('is_subscriber', 1)->count();
        $totalNonSubscribers = Service::where('is_subscriber', 0)->count();

        $todayServices = Service::whereDate('service_date', today())->count();

        $todayRevenue = Service::whereDate('service_date', today())
            ->get()
            ->sum(fn ($service) => $service->total_price);

        $traderController = app(TraderController::class);

// Notifications تاع Registre de Commerce (Personne Physique)
$sidebarNotifications = [
    'traders_casnos' => $traderController->getNotifications()->count(),
    'cnrc' => $traderController->getCnrcNotifications()->count(),
    'delivery' => $traderController->getDeliveryNotifications()->count(),
];

// Notifications تاع CASNOS وحدها
$allCasnos = \App\Models\Casnos::all();

$countCasnosCreditors = $allCasnos->filter(
    fn ($client) => $client->getAdjustedBalance() < 0
)->count();

$countCasnosDebtors = $allCasnos->filter(
    fn ($client) => $client->getAdjustedBalance() > 0
)->count();

$sidebarNotifications['casnos'] =
    $countCasnosCreditors + $countCasnosDebtors;
    
        $sidebarNotifications['taxes'] = \App\Models\Tax::where('pay_type', 'credit')
            ->whereDate('credit_date', '<', now())
            ->count();

        $tmoralController = app(TmoralController::class);

        $sidebarNotifications['tmorals'] =
            $tmoralController->getCnrcNotifications()->count()
            + $tmoralController->getDeliveryNotifications()->count()
            + $tmoralController->getImportResaleNotifications()->count();

        $sidebarNotifications['respectes'] = Respecte::whereNotNull('date_of_this')
            ->whereDate('date_of_this', '<=', now()->subMonths(23))
            ->count();

        $sidebarNotifications['clients'] = Client::whereNotNull('registration_date')
            ->whereDate('registration_date', '<=', now()->subMonths(6))
            ->count();

        $sidebarNotifications['subscriptions'] = Subscription::whereNotNull('end_date')
            ->whereDate('end_date', '<=', now()->toDateString())
            ->count();

        return view('services.index', compact(
            'services',
            'clientsChart',
            'revenusChart',
            'totalServices',
            'totalRevenue',
            'totalSubscribers',
            'totalNonSubscribers',
            'todayServices',
            'todayRevenue',
            'sidebarNotifications'
        ));
    }

    public function create()
    {
        return view('services.create', [
            'servicePrices' => $this->getServicePrices(),
        ]);
    }

    private function getServicePrices(): array
    {
        $defaults = [
            'sijil_moutanaiqil' => 11000,
            'sijil_ramz_unit' => 240,
            'naql_badaie' => 14000,
            'hanout' => 15000,
            'sina3a' => 16000,
            'eljemla' => 16000,
            'wakala' => 2000,
            'tamdid_salahya' => 18000,
            'istirad' => 45000,
            'mosada9a_one' => 1500,
            'mosada9a_multiple' => 1200,
            'ta3dil' => 13000,
            'creation_CA' => 11000,
            'creation_dplm_CA' => 11000,
            'annulation_CA' => 11000,
            'efficacite' => 30000,
            'khidma_ijer_mahal' => 3000,
            'ta3dil_CA_base' => 11000,
            'ta3dil_CA_before_2025' => 300,
            'ta3dil_CA_from_2025' => 100,
            'casnos' => 1500,
            'carte_chifa' => 500,
            'nif' => 800,
            'nif_plus_g08' => 1000,
            'g12_price' => 1200,
            'g12bis_price' => 1200,
            'nis' => 4800,
            'inapi' => 11000,
            'coderbar_base' => 11000,
            'coderbar_product' => 500,
            'moudirya_naql' => 5000,
            'tarjama_register_1' => 1800,
            'tarjama_register_2' => 2400,
            'tarjamat_sawabi9' => 1400,
            'talab_c20' => 4000,
            'kachf_hisseb' => 3000,
            'tasmya' => 1500,
            'tarjamat_boal' => 3000,
            'ichhar_boal' => 10000,
            'creation_entreprise' => 45000,
            'chahedat_ihtiram' => 10000,
            'nif_alces' => 10000,
            'nif_dowan' => 3000,
            'g50' => 1000,
            'irg_salaire' => 1000,
            'tva' => 1000,
            'khatm_11' => 1400,
            'khatm_12' => 1700,
            'khatm_13' => 2100,
            'khatm_14' => 2900,
            'khatm_15' => 3500,
            'khatm_42' => 3200,
            'cnas_abattement' => 15000,
            'cnas_sans_abattement' => 12000,
        ];

        $prices = [];

        foreach ($defaults as $key => $default) {
            $prices[$key] = ServicePrice::getPrice($key, $default);
        }

        return $prices;
    }

    public function store(Request $request)
    {
        $serviceData = $this->formatData($request);

        $subscription = Subscription::where('phone', $request->phone)
            ->whereDate('end_date', '>=', today())
            ->first();

        $serviceData['is_subscriber'] = $subscription ? 1 : 0;

        Service::create($serviceData);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service ajouté avec succès.');
    }

    private function formatData(Request $request): array
    {
        $data = $request->all();

        $checkboxes = [
            'sijil_moutanaiqil',
            'naql_badaie',
            'hanout',
            'sina3a',
            'eljemla',
            'wakala',
            'tamdid_salahya',
            'istirad',
            'ta3dil',
            'creation_CA',
            'creation_dplm_CA',
            'annulation_CA',
            'efficacite',
            'khidma_ijer_mahal',
            'ta3dil_CA',
            'casnos',
            'carte_chifa',
            'nif',
            'nif_plus_g08',
            'g12_price',
            'g12bis_price',
            'tarjamat_sawabi9',
            'talab_c20',
            'kachf_hisseb',
            'nis',
            'inapi',
            'coderbar',
            'moudirya_naql',
            'tasmya',
            'tarjamat_boal',
            'ichhar_boal',
            'creation_entreprise',
            'chahedat_ihtiram',
            'nif_alces',
            'nif_dowan',
            'g50',
            'irg_salaire',
            'tva',
        ];

        foreach ($checkboxes as $field) {
            $data[$field] = $request->boolean($field) ? 1 : 0;
        }

        $numbers = [
            'sijil_ramz_count',
            'mosada9a',
            'logo_price',
            'coderbar_products_count',
            'anne_de_modification',
        ];

        foreach ($numbers as $field) {
            $data[$field] = $request->input($field) ?? 0;
        }

        $data['tarjama_register'] = $request->input('tarjama_register', 0);
        $data['khatm_type'] = $request->input('khatm_type', 'بدون ختم');
        $data['number_of_galization'] = $request->input('number_of_galization', 1);
        $data['cnas_type'] = $request->input('cnas_type', 0);
        $data['anne_de_modification'] =
    $request->filled('anne_de_modification')
        ? $request->input('anne_de_modification')
        : null;

        return $data;
    }

    public function edit(Service $service)
    {
        return view('services.edit', [
            'service' => $service,
            'servicePrices' => $this->getServicePrices(),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $serviceData = $this->formatData($request);

        $subscription = Subscription::where('phone', $request->phone)
            ->whereDate('end_date', '>=', today())
            ->first();

        $serviceData['is_subscriber'] = $subscription ? 1 : 0;

        $service->update($serviceData);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service modifié avec succès.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->back()->with('success', 'تم الحذف');
    }

    public function printPdf(Service $service)
    {
        return view('services.pdf', compact('service'));
    }

    public function searchSubscriber(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        if (mb_strlen($search) < 2) {
            return response()->json([]);
        }

        return Subscription::query()
            ->select('id', 'full_name', 'phone', 'end_date')
            ->whereDate('end_date', '>=', today())
            ->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('full_name')
            ->limit(10)
            ->get()
            ->map(fn ($subscription) => [
                'id' => $subscription->id,
                'full_name' => $subscription->full_name,
                'phone' => $subscription->phone,
            ]);
    }

    public function statistics()
    {
        $services = Service::all();

        $totalServices = $services->count();

        $totalRevenue = $services->sum(
            fn ($service) => $service->total_price
        );

        $totalSubscribers = $services->where('is_subscriber', 1)->count();
        $totalNonSubscribers = $services->where('is_subscriber', 0)->count();

        $todayServices = $services->filter(
            fn ($service) => $service->service_date == today()->toDateString()
        )->count();

        $todayRevenue = $services->filter(
            fn ($service) => $service->service_date == today()->toDateString()
        )->sum(fn ($service) => $service->total_price);

        $todayPaid = CreditPayment::whereDate('payment_date', today())
            ->sum('amount');

        $todayRemaining = Credit::whereHas('service', function ($query) {
            $query->whereDate('service_date', today());
        })->get()->sum(fn ($credit) => max(0, $credit->remaining_amount));

        $totalPaid = CreditPayment::sum('amount');

        $totalRemaining = Credit::all()->sum(
            fn ($credit) => $credit->remaining_amount
        );

        $totalPayments = CreditPayment::count();

        $averageService = $totalServices > 0
            ? $totalRevenue / $totalServices
            : 0;

        $collectionRate = $totalRevenue > 0
            ? round(($totalPaid / $totalRevenue) * 100, 1)
            : 0;

        $clientsWithDebt = Credit::all()
            ->filter(fn ($credit) => $credit->remaining_amount > 0)
            ->count();

        $weekServices = $services->filter(function ($service) {
            return $service->service_date
                && Carbon::parse($service->service_date)->isCurrentWeek();
        })->count();

        $weekRevenue = $services->filter(function ($service) {
            return $service->service_date
                && Carbon::parse($service->service_date)->isCurrentWeek();
        })->sum(fn ($service) => $service->total_price);

        $monthServices = $services->filter(function ($service) {
            return $service->service_date
                && Carbon::parse($service->service_date)->isCurrentMonth();
        })->count();

        $monthRevenue = $services->filter(function ($service) {
            return $service->service_date
                && Carbon::parse($service->service_date)->isCurrentMonth();
        })->sum(fn ($service) => $service->total_price);

        $revenusParMois = $services
            ->filter(fn ($service) => $service->service_date)
            ->groupBy(fn ($service) => Carbon::parse($service->service_date)->format('Y-m'))
            ->map(fn ($items, $month) => [
                'month' => $month,
                'total' => $items->sum(fn ($service) => $service->total_price),
            ])
            ->values();

        $servicesParMois = $services
            ->filter(fn ($service) => $service->service_date)
            ->groupBy(fn ($service) => Carbon::parse($service->service_date)->format('Y-m'))
            ->map(fn ($items, $month) => [
                'month' => $month,
                'total' => $items->count(),
            ])
            ->values();

        $topClients = $services
            ->groupBy(fn ($service) => $service->full_name . '|' . $service->phone)
            ->map(function ($items) {
                $first = $items->first();

                return [
                    'name' => $first->full_name,
                    'phone' => $first->phone,
                    'count' => $items->count(),
                    'revenue' => $items->sum(fn ($service) => $service->total_price),
                ];
            })
            ->sortByDesc('revenue')
            ->take(10)
            ->values();

        return view('services.statistics', compact(
            'totalServices',
            'totalRevenue',
            'totalSubscribers',
            'totalNonSubscribers',
            'todayServices',
            'todayRevenue',
            'totalPaid',
            'totalRemaining',
            'averageService',
            'totalPayments',
            'collectionRate',
            'clientsWithDebt',
            'weekServices',
            'weekRevenue',
            'monthServices',
            'monthRevenue',
            'revenusParMois',
            'servicesParMois',
            'topClients',
            'todayPaid',
            'todayRemaining'
        ));
    }

    public function changeStatus(Request $request, Service $service)
    {
        $request->validate([
            'service_status' => 'required|in:pending,progress,finished',
        ]);

        $service->update([
            'service_status' => $request->service_status,
        ]);

        return back();
    }

    public function getCreditPaymentRetardNotifications()
    {
        return Service::whereHas('credit', function ($query) {
            $query->whereHas('payments');
        })
            ->with([
                'credit.payments' => fn ($query) => $query->orderByDesc('payment_date'),
            ])
            ->get()
            ->filter(function ($service) {
                $credit = $service->credit;

                if (!$credit || $credit->remaining_amount <= 0) {
                    return false;
                }

                $lastPayment = $credit->payments->first();

                if (!$lastPayment || !$lastPayment->payment_date) {
                    return false;
                }

                return Carbon::parse($lastPayment->payment_date)
                    ->lte(Carbon::now()->subDays(3));
            });
    }

    public function sendCreditRetardWhatsApp(
        Service $service,
        InfobipWhatsAppService $whatsapp
    ) {
        $credit = $service->credit;

        if (!$credit || $credit->remaining_amount <= 0) {
            return false;
        }

        $lastPayment = $credit->payments()
            ->orderByDesc('payment_date')
            ->first();

        if (!$lastPayment || !$lastPayment->payment_date) {
            return false;
        }

        if (Carbon::parse($lastPayment->payment_date)
            ->gt(Carbon::now()->subDays(3))) {
            return false;
        }

        $phone = $service->phone;

        if (!$phone) {
            return false;
        }

        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '213' . substr($phone, 1);
        }

        $response = $whatsapp->sendTemplate(
            $phone,
            config('services.infobip.template'),
            config('services.infobip.language'),
            [$service->full_name]
        );

        return $response->successful();
    }
}
