<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientController extends Controller
{
    // عرض قائمة الزبائن
public function index(Request $request)
{
    $search = $request->input('search');

    $clients = Client::when($search, function ($query, $search) {

        return $query->where('first_name', 'like', "%{$search}%")
                     ->orWhere('last_name', 'like', "%{$search}%")
                     ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                     ->orWhere('number_of_registration', 'like', "%{$search}%");

    })->get();

    if ($request->ajax()) {

        return view('clients.index', compact('clients'))->render();
    }

    return view('clients.index', compact('clients'));
}
    // عرض التنبيهات (الناس اللي فات عليهم 6 أشهر)
    public function notifications()
    {
        // نجيبو قاع الناس اللي تاريخ التسجيل تاعهم فات عليه 6 أشهر من اليوم
        $readyClients = Client::where('registration_date', '<=', Carbon::now()->subMonths(6))
                             ->get();

        return view('clients.notifications', compact('readyClients'));
    }

    // دالة لإنشاء زبون جديد (Create)
 public function store(Request $request)
{
    // 1. التحقق من البيانات (Validation)
    $data = $request->validate([
        'first_name'             => 'required|string|max:255',
        'last_name'              => 'required|string|max:255',
        'email'                  => 'required|email|unique:clients,email',
        'phone'                  => 'nullable|string',
        'password'               => 'required|string|min:6', // تأكد أن الباسوورد هنا
        'number_of_registration' => 'required|string',
        'registration_date'      => 'required|date',
        'number_of_demande'      => 'nullable|integer',
        'client_class'          => 'nullable|string',
    ]);

    // 2. تشفير كلمة المرور (ضروري للأمن)

    // 3. حفظ البيانات في القاعدة
    Client::create($data);

    // 4. الرجوع للجدول مع رسالة نجاح
    return redirect()->route('clients.index')->with('success', 'تم تسجيل الزبون بنجاح');
}
public function edit(Client $client)
{
    // نبعثو البيانات لصفحة Edit
    return view('clients.edit', compact('client'));
}

public function update(Request $request, Client $client)
{
    $data = $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'nullable',
        'email' => 'required|email|unique:clients,email,'.$client->id,
        'number_of_registration' => 'required',
        'client_class' => 'nullable|string',
        'registration_date' => 'required|date',
        'number_of_demande' => 'required|integer',
    ]);

    $client->update($data);
    return redirect()->route('clients.index')->with('success', 'تم تحديث البيانات بنجاح');
}
// دالة عرض صفحة إضافة زبون جديد
public function create()
{
    return view('clients.create');
}
public function destroy(Client $client)
{
    $client->delete();

    return redirect()->route('clients.index')
        ->with('success', 'Client deleted successfully.');
}

    }