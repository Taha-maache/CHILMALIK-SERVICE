<?php

namespace App\Http\Controllers;

use App\Models\Trader;  
use App\Models\TraderTax;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use App\Models\CasnosPayment;
class TraderTaxController extends Controller
{
public function index(Request $request)
{
    // 1. نجيبو واش كتب المستخدم فقط
    $search = $request->input('search');

    // 2. نبدأ الاستعلام الأساسي
   $query = TraderTax::with('trader:id,first_name,last_name,NIN');
   
    // 3. إذا كاين بحث، نحصروه داخل قوسين (Closure)
    if (!empty($search)) {
        $query->whereHas('trader', function($q) use ($search) {
            $q->where(function($sub) use ($search) {
                // هنا حددنا فقط 3 حقول.. مستحيل يبحث في الهاتف أو غيره
                $sub->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('NIN', 'like', $search);

            });
        });
    }

    // 4. الترتيب والتقسيم
    $trader_taxes = $query->orderBy('tax_year', 'desc')->paginate(150);
    
    // هادي نخلوها كما راهي
    $late_payers = TraderTax::with('trader')->get()->filter->isLate();
    // عدد ملفات CASNOS التي عليها دين
$casnosPayments = CasnosPayment::all();

$casnosTotalCount = $casnosPayments->filter(function ($p) {
    // نفس حساب الدين والفائض الموجود في CasnosPaymentController
    $balance = (float) $p->montant_versse >= (float) $p->montant_enkissi
        ? (float) $p->montant_versse - (float) $p->montant_enkissi
        : -$p->getAdjustedBalance();

    return $balance != 0;
})->count();

return view('trader_taxes.index', compact('trader_taxes', 'late_payers', 'casnosTotalCount'));
}
// زيد هادي في TraderTaxController
public function show(TraderTax $trader_tax)
{
    // في بلاصة ما نفتحو صفحة show (لي ما عندكش)، نبعثوه مباشرة للتعديل
    return redirect()->route('trader_taxes.edit', $trader_tax->id);
}
    public function debtors()
    {
        $debtors = TraderTax::where('pay_type', 'credit')
                    ->where('credit_date', '<', now())
                    ->paginate(9);

        return view('trader_taxes.debtors', compact('debtors'));
    }

    public function create()
    {
        $traders = Trader::orderBy('last_name')->get();
        return view('trader_taxes.create', compact('traders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'tax_year' => 'required|integer',
            'tax_value' => 'required',
            
        ]);

        TraderTax::create($request->all());
        return redirect()->route('trader_taxes.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function edit(TraderTax $trader_tax)
    {
        $traders = Trader::orderBy('last_name')->get();
        return view('trader_taxes.edit', compact('trader_tax', 'traders'));
    }

 public function update(Request $request, TraderTax $trader_tax)
{
    $request->validate([
    'g12_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
    'g12bis_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
]); 


    $trader_tax->update($request->except([
        'g12_pdf',
        'g12bis_pdf',
    ]));

    $documents = [
        'g12_pdf',
        'g12bis_pdf'
    ];

    foreach ($documents as $doc) {

        if ($request->hasFile($doc)) {

            // حذف القديم إذا موجود
            if ($trader_tax->$doc) {
                Storage::disk('public')->delete($trader_tax->$doc);
            }

            $path = $request
                ->file($doc)
                ->store('tax_pdfs', 'public');

            $trader_tax->$doc = $path;
        }
    }

    $trader_tax->save();

    return redirect()
        ->route('trader_taxes.index')
        ->with('success', 'تم التحديث بنجاح.');
}


    public function destroy(TraderTax $trader_tax)
    {
        $trader_tax->delete();
        return redirect()->route('trader_taxes.index')->with('success', 'تم حذف السجل.');
    }

    public function pdf(TraderTax $trader_tax, $type='full')
    {
        $html = view('trader_taxes.pdf', compact('trader_tax', 'type'))->render();
        $mpdf = new Mpdf([
            'mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 0, 'margin_right' => 0,
            'margin_bottom' => 0, 'margin_left' => 0, 'default_font' => 'arabictypesetting',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
        ]);
        $mpdf->WriteHTML($html);
       
        $filename = ($type == 'receipt' ? 'receipt_' : 'trader_tax_') . $trader_tax->id . '.pdf';
       
        return response($mpdf->Output($filename, 'S'), 200)
        ->header('Content-Type', 'application/pdf');
    }
} 