<?php
namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Mpdf\Mpdf; // لازم تكون مسطبي المكتبة
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;
class TaxController extends Controller
{
    // عرض القائمة مع البحث
    public function index(Request $request)
    {
        $search = $request->get('search');
        $taxes = Tax::where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                    ->orWhere('Nin', 'like', "%$search%")
                    ->paginate(150);

     $overdueTaxes = Tax::where('pay_type', 'credit')
                       ->whereDate('credit_date', '<', now())
                       ->get();

    return view('taxes.index', compact('taxes', 'overdueTaxes'));
}

    // فورم إضافة جديد
    public function create()
    {
        return view('taxes.create');
    }

    // حفظ في القاعدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'tax_value' => 'required|numeric',
            'activity_id' => 'nullable|exists:activities,id',
            'activity_fr_id' => 'nullable|exists:activities_fr,id',

            // زيد باقي الحقول هنا
        ]);

        Tax::create($request->all());
        return redirect()->route('taxes.index')->with('success', 'تمت الإضافة بنجاح');
    }

    // فورم التعديل (يجيب القيم القديمة)
    public function edit($id)
{
    $tax = Tax::findOrFail($id);
    return view('taxes.edit', compact('tax'));
}

    // تحديث البيانات

public function update(Request $request, $id)
{
    $tax = Tax::findOrFail($id);

    $tax->update($request->except([
        'nif_pdf',
        'nis_pdf',
        'g12_pdf',
        'g12bis_pdf',
    ]));

    $documents = [
        'nif_pdf',
        'nis_pdf',
        'g8_pdf',
        'g12bis_pdf',
    ];

    foreach ($documents as $doc) {

        if ($request->hasFile($doc)) {

            if ($tax->$doc) {
                Storage::disk('public')->delete($tax->$doc);
            }

            $path = $request
                ->file($doc)
                ->store('tax_documents', 'public');

            $tax->$doc = $path;
        }
    }

    $tax->save();

    return redirect()
        ->route('taxes.index')
        ->with('success', 'تم التعديل بنجاح');
}
    // حذف
    public function destroy($id)
    {
        Tax::findOrFail($id)->delete();
        return redirect()->route('taxes.index');
    }
 
public function pdf(Tax $tax, $type = 'full')
{
    // نبعثو البيانات للـ View (تأكد بلي اسم الفيشي taxes/pdf.blade.php)
    $html = view('taxes.pdf', compact('tax', 'type'))->render();

    $mpdf = new Mpdf([
        'mode' => 'utf-8', 
        'format' => 'A4', 
        'margin_top' => 0, 
        'margin_right' => 0,
        'margin_bottom' => 0, 
        'margin_left' => 0, 
        'default_font' => 'arabictypesetting', // مهم بزاف باش تخرج العربية قريشة
    ]);

    $mpdf->WriteHTML($html);
    
    // تسمية الملف حسب النوع
    $filename = ($type == 'receipt' ? 'receipt_' : 'tax_doc_') . $tax->id . '.pdf';
    
    return response($mpdf->Output($filename, 'S'), 200)
        ->header('Content-Type', 'application/pdf');
}
public function debtors()
{
    // جلب الديون المتأخرة فقط (تاريخ اليوم أكبر من تاريخ استحقاق الدين)
    $debtors = Tax::where('pay_type', 'credit')
                  ->whereDate('credit_date', '<', now())
                  ->orderBy('credit_date', 'asc')
                  ->paginate(10);

    return view('taxes.debtors', compact('debtors'));
}

}