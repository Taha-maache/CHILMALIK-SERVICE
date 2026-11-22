<?php
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityFrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;
use App\Http\Controllers\TraderTaxController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CasnosController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CasnosPaymentController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\TmoralController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DamancomController;
use App\Http\Controllers\JibayaticController;
use App\Http\Controllers\CnasController;
use App\Http\Controllers\CnasBeneficiaryController;
use App\Http\Controllers\DamancomMoralController;
use App\Http\Controllers\JibayaticMoralController;
use App\Http\Controllers\CnasMoralController;
use App\Http\Controllers\CnasMoralBeneficiaryController;
use App\Http\Controllers\CreditPaymentController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CasnosPaymentTransactionController;
use App\Http\Controllers\CasnosPmController;
use App\Http\Controllers\TraderTaxPaymentController;
use App\Http\Controllers\TaxesPaymentController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\EfficaciteController;
use App\Http\Controllers\RespecteController;
use App\Models\Credit;
use App\Http\Controllers\SubscriptionPaymentController;

use App\Models\Activity;
use App\Models\ActivityFr;
use Illuminate\Http\Request;

use App\Http\Controllers\ServicePriceController;

use App\Http\Controllers\SubscriptionWhatsAppController;


/*
|-------------------------
| Home / Dashboard
|-------------------------
*/
Route::get('/casnos/{id}/whatsapp-reminder',
    [CasnosController::class, 'whatsappReminder']
)->name('casnos.whatsapp-reminder');

Route::post('/casnos/{id}/whatsapp-reminder/sent',
    [CasnosController::class, 'markWhatsappReminderSent']
)->name('casnos.whatsapp-reminder.sent');


// WhatsApp CASNOS Reminder
Route::get(
    '/casnos-payments/{id}/whatsapp-reminder',
    [CasnosPaymentController::class, 'whatsappReminder']
)->name('casnos-payments.whatsapp-reminder');

Route::post(
    '/casnos-payments/{id}/whatsapp-reminder/sent',
    [CasnosPaymentController::class, 'markWhatsappReminderSent']
)->name('casnos-payments.whatsapp-reminder.sent');



Route::get('/service-prices', [ServicePriceController::class, 'index'])
    ->name('service-prices.index');

Route::put('/service-prices', [ServicePriceController::class, 'update'])
    ->name('service-prices.update');

Route::get(
    '/traders/{trader}/whatsapp-register-reminder',
    [TraderController::class, 'whatsappRegisterReminder']
)->name('traders.whatsapp-register-reminder');

Route::post(
    '/traders/{trader}/whatsapp-register-reminder/sent',
    [TraderController::class, 'markWhatsappRegisterReminderSent']
)->name('traders.whatsapp-register-reminder.sent');


Route::get('/activities-by-codes', function (Request $request) {
    $codes = $request->input('codes', []);

    return response()->json([
        'ar' => Activity::whereIn('code', $codes)->get(),
        'fr' => ActivityFr::whereIn('code', $codes)->get(),
    ]);
});


Route::get(
    '/subscriptions/{subscription}/whatsapp/{type}',
    [SubscriptionWhatsAppController::class, 'show']
)->name('subscriptions.whatsapp');

Route::post(
    '/subscriptions/{subscription}/whatsapp/{type}/sent',
    [SubscriptionWhatsAppController::class, 'sent']
)->name('subscriptions.whatsapp.sent');

Route::get(
    '/subscriptions/{subscription}/payments',
    [SubscriptionPaymentController::class, 'index']
)->name('subscriptions.payments.index');

Route::post(
    '/subscriptions/{subscription}/payments',
    [SubscriptionPaymentController::class, 'store']
)->name('subscriptions.payments.store');




Route::get('/whatsapp/{id}', function ($id) {

    $credit = Credit::with('service')->find($id);

    if (!$credit) {
        return 'Credit not found. ID = ' . $id;
    }

    return view('whatsapp.send', compact('credit'));

})->name('whatsapp.send');


Route::post('/whatsapp/{id}/reminder-sent', function ($id) {

    $credit = Credit::findOrFail($id);

    // نسجل وقت إرسال التذكير
    $credit->last_whatsapp_reminder_at = now();
    $credit->save();

    return response()->json([
        'success' => true
    ]);

})->name('whatsapp.reminder.sent');

Route::put('/artisans/{artisan}/etat', [ArtisanController::class, 'updateEtat'])
    ->name('artisans.updateEtat');

Route::resource('artisans', ArtisanController::class);




Route::get('/subscriptions/{subscription}/invoice', 
    [SubscriptionController::class, 'invoice']
)->name('subscriptions.invoice');
Route::get('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'] )->name('subscriptions.renew'); Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'processRenew'] )->name('subscriptions.processRenew');


Route::resource('transporters', TransporterController::class);

Route::put('/efficacites/{efficacite}/etat',
    [EfficaciteController::class, 'updateEtat']
)->name('efficacites.updateEtat');

Route::resource('efficacites', EfficaciteController::class);

Route::resource('respectes', RespecteController::class);

Route::get('/transporters/{transporter}/pdf', [TransporterController::class, 'pdf'])
    ->name('transporters.pdf');
    Route::get('/transporters/{transporter}/delete-file/{field}', 
    [TransporterController::class, 'deleteFile'])
    ->name('transporters.deleteFile');
    
Route::get('/', function () {
    return redirect()->route('services.index');
});

Route::get('/dashboard', [ServiceController::class, 'index'])
    ->name('dashboard');
/*
|-------------------------
| Traders CRUD
|-------------------------
*/
Route::resource('traders', TraderController::class);
Route::patch('/traders/{trader}/change-status', [TraderController::class, 'changeStatus'])
    ->name('traders.changeStatus');

/*
| PDF traders
*/
Route::get('/traders/{trader}/pdf/full', [TraderController::class, 'pdfFull'])
->name('traders.pdf.full');

Route::get('/traders/{trader}/pdf/g08', [TraderController::class, 'pdfG08'])
->name('traders.pdf.g08');
    
Route::get('/traders/{id}/declare-casnos', [TraderController::class, 'declareCasnos'])
->name('traders.declare_casnos');

/*
| Trader Taxes CRUD
*/
/*
| Trader Taxes CRUD (الترتيب مهم جداً هنا)
|--------------------------------------------------------------------------
*/

// 1. الديون (لازم تكون هي الأولى قاع)
Route::get('trader_taxes/debtors', [TraderTaxController::class, 'debtors'])
    ->name('trader_taxes.debtors');

// 2. الـ PDF (قبل الـ Resource)
// لازم يكون اسمه {trader_tax} ماشي {id}
Route::get('/trader_taxes/{trader_tax}/pdf/{type}', [TraderTaxController::class, 'pdf']);
// 3. الـ Resource (هو الأخير)
Route::resource('trader_taxes', TraderTaxController::class);/*
| Test page (optional)
*/
// بدل السطر القديم بهذا باش الـ Show ما يبقاش يديرلك مشاكل

Route::resource('clients', ClientController::class);
// Route إضافي للـ Notifications
Route::get('/notifications', [ClientController::class, 'notifications'])->name('clients.notifications');

Route::get('/casnos/debtors', [CasnosController::class, 'debtors'])->name('casnos.debtors');
Route::get('/casnos/creditors', [CasnosController::class, 'creditors'])->name('casnos.creditors');

Route::get('/casnos/{id}/print', [CasnosController::class, 'print'])
    ->name('casnos.print');


Route::resource('casnos', CasnosController::class);

Route::get('taxes/debtors', [App\Http\Controllers\TaxController::class, 'debtors'])
->name('taxes.debtors');
Route::resource('taxes', TaxController::class);
Route::get('taxes/{tax}/pdf/{type?}', [App\Http\Controllers\TaxController::class, 'pdf'])
->name('taxes.pdf');

Route::get('/services/{service}/pdf', [ServiceController::class, 'printPdf'])
    ->name('services.pdf');

Route::get('/services/statistics', [ServiceController::class, 'statistics'])
    ->name('services.statistics');


Route::get('/search-subscriber', [ServiceController::class, 'searchSubscriber'])
    ->name('services.searchSubscriber');

    Route::get('/services/{service}/credit/create', [CreditController::class, 'create'])
    ->name('credits.create');

Route::post('/services/{service}/credit', [CreditController::class, 'store'])
    ->name('credits.store');

    Route::get('/credits', [CreditController::class, 'index'])
    ->name('credits.index');

    Route::get('/credits/{credit}/edit', [CreditController::class, 'edit'])
    ->name('credits.edit');
    
    Route::put('/credits/{credit}', [CreditController::class, 'update'])
    ->name('credits.update');

    Route::delete('/credits/{credit}', [CreditController::class, 'destroy'])
    ->name('credits.destroy');

Route::resource('credits', CreditController::class);
Route::get('/credits/{credit}/payments', [CreditPaymentController::class,'index'])
    ->name('credits.payments');

Route::post('/credits/{credit}/payments', [CreditPaymentController::class,'store'])
    ->name('credits.payments.store');

Route::delete('/payments/{payment}', [CreditPaymentController::class,'destroy'])
    ->name('payments.destroy');
Route::patch('/services/{service}/status', [ServiceController::class, 'changeStatus'])
    ->name('services.changeStatus');

Route::resource('services', ServiceController::class)
    ->except(['show']);



/*
|-------------------------
| Subscriptions Routes
|-------------------------
*/

Route::get('/subscriptions', [SubscriptionController::class, 'index'])
    ->name('subscriptions.index');

Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])
    ->name('subscriptions.create');

Route::post('/subscriptions', [SubscriptionController::class, 'store'])
    ->name('subscriptions.store');

Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])
    ->name('subscriptions.edit');

Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])
    ->name('subscriptions.update');

Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
    ->name('subscriptions.destroy');

Route::get('/casnos-payments/creditors', [CasnosPaymentController::class, 'creditors'])
    ->name('casnos-payments.creditors');

Route::get('/casnos-payments/overpaid', [CasnosPaymentController::class, 'overpaid'])
    ->name('casnos-payments.overpaid');
    
    Route::get('/casnos-payments/search-traders',
    [CasnosPaymentController::class, 'searchTraders']
)->name('casnos-payments.search-traders');

Route::resource('casnos-payments', CasnosPaymentController::class);


Route::get('/search-activities', [ActivityController::class, 'search']);
Route::get('/search-activities-fr', [ActivityFrController::class, 'search']);


Route::get('/names/{name}/pdf/naming', [NameController::class, 'pdfNaming'])
->name('names.pdf.naming');

Route::resource('names', NameController::class);


Route::resource('tmorals', TmoralController::class);

Route::get('/tmorals/{tmoral}/pdf', [TmoralController::class, 'pdf'])
    ->name('tmorals.pdf');
Route::get('/tmorals/{tmoral}/pdfg08', [TmoralController::class, 'pdfG08'])
    ->name('tmorals.pdfg08');
Route::patch('/tmorals/{tmoral}/change-status', [TmoralController::class, 'changeStatus'])
    ->name('tmorals.changeStatus');

Route::resource('beneficiaries', BeneficiaryController::class);

Route::get('/beneficiaries/{id}/pdf_ar', [BeneficiaryController::class, 'pdfAr'])
    ->name('beneficiaries.pdf_ar');

Route::get('/beneficiaries/{id}/pdf_fr', [BeneficiaryController::class, 'pdfFr'])
    ->name('beneficiaries.pdf_fr');

Route::delete('/damancoms/{damancom}/delete-pdf',[DamancomController::class,'deletePdf'])
    ->name('damancoms.deletePdf');

Route::resource('damancoms', DamancomController::class);

Route::delete('/jibayatics/{jibayatic}/delete-pdf',
    [JibayaticController::class,'deletePdf'])
    ->name('jibayatics.deletePdf');

Route::resource('jibayatics', JibayaticController::class);

Route::get('/cnases/{cnas}/delete-file/{file}',
    [CnasController::class,'deleteFile'])
    ->name('cnases.deleteFile');
  
    Route::get('/cnas-beneficiaries/{beneficiary}/delete-file/{file}',
    [CnasBeneficiaryController::class,'deleteFile'])
    ->name('cnas-beneficiaries.deleteFile');
    
Route::delete('/cnases/{cnas}', [CnasController::class, 'destroy'])
->name('cnases.destroy');
Route::resource('cnases', CnasController::class);

Route::get('/damancom-moral/{damancom_moral}/delete-file/{field}',[DamancomMoralController::class, 'deleteFile']
)->name('damancom-moral.deleteFile');

Route::resource('damancom-moral', DamancomMoralController::class);

Route::get('/jibayatic-moral/{jibayatic_moral}/delete-file/{field}',[JibayaticMoralController::class, 'deleteFile']
)->name('jibayatic-moral.deleteFile');

Route::resource('jibayatic-moral', JibayaticMoralController::class);

Route::resource('cnas-morals', CnasMoralController::class);

Route::get(
    '/cnas-morals/{cnas_moral}/delete-file/{field}',
    [CnasMoralController::class, 'deleteFile']
)->name('cnas-morals.deleteFile');

Route::get(
    '/cnas-moral-beneficiaries/{beneficiary}/delete-file/{field}',
    [CnasMoralBeneficiaryController::class, 'deleteFile']
)->name('cnas-moral-beneficiaries.deleteFile');

Route::delete(
    '/cnas-moral-beneficiaries/{beneficiary}',
    [CnasMoralBeneficiaryController::class, 'destroy']
)->name('cnas-moral-beneficiaries.destroy');
Route::get('/backups', [BackupController::class, 'index'])
    ->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])
    ->name('backups.create');
Route::post('/backups/{backup}/restore', [BackupController::class, 'restore'])
    ->name('backups.restore');
    Route::delete('/backups/{backup}', [BackupController::class,'destroy'])
    ->name('backups.destroy');
    Route::post(
    '/backups/{backup}/copy-external',
    [BackupController::class, 'copyToExternal']
)->name('backups.copyExternal');


Route::prefix('casnos-payments/{casnosPayment}/transactions')
    ->name('casnos-payments.transactions.')
    ->group(function () {

        Route::get('/', [CasnosPaymentTransactionController::class, 'index'])
            ->name('index');

        Route::get('/create', [CasnosPaymentTransactionController::class, 'create'])
            ->name('create');

        Route::post('/', [CasnosPaymentTransactionController::class, 'store'])
            ->name('store');
    });

Route::get(
    'casnos-payment-transactions/{id}/edit',
    [CasnosPaymentTransactionController::class, 'edit']
)->name('casnos-payment-transactions.edit');

Route::put(
    'casnos-payment-transactions/{id}',
    [CasnosPaymentTransactionController::class, 'update']
)->name('casnos-payment-transactions.update');

Route::delete(
    'casnos-payment-transactions/{id}',
    [CasnosPaymentTransactionController::class, 'destroy']
)->name('casnos-payment-transactions.destroy');
Route::get(
    'casnos-payment-transactions/{id}/facture',
    [CasnosPaymentTransactionController::class, 'facture']
)->name('casnos-payment-transactions.facture');


Route::prefix('casnos/{casnos}/pm')
    ->name('casnos.pm.')
    ->group(function () {

        Route::get('/', [CasnosPmController::class, 'index'])
            ->name('index');

        Route::get('/create', [CasnosPmController::class, 'create'])
            ->name('create');

        Route::post('/', [CasnosPmController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [CasnosPmController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [CasnosPmController::class, 'update'])
            ->name('update');
    });
    Route::get('/casnos-pm/{id}/facture', [CasnosPmController::class, 'facture'])
    ->name('casnos.pm.facture');

Route::delete('/casnos-pm/{id}', [CasnosPmController::class, 'destroy'])
    ->name('casnos.pm.destroy');
    
   Route::prefix('trader-tax-payments')->group(function () {



    });
    Route::get('/{traderTaxId}', 
        [TraderTaxPaymentController::class, 'index']
    )->name('trader-tax-payments.index');

    Route::get('/{traderTaxId}/create', 
        [TraderTaxPaymentController::class, 'create']
    )->name('trader-tax-payments.create');

    Route::post('/{traderTaxId}', 
        [TraderTaxPaymentController::class, 'store']
    )->name('trader-tax-payments.store');

    Route::get('/payment/{id}/edit', 
        [TraderTaxPaymentController::class, 'edit']
    )->name('trader-tax-payments.edit');

    Route::put('/payment/{id}', 
        [TraderTaxPaymentController::class, 'update']
    )->name('trader-tax-payments.update');

    Route::get('/trader-taxes/{traderTax}/payments',
    [TraderTaxPaymentController::class, 'index']
)->name('trader-tax-payments.index');

Route::get('/trader-taxes/{traderTax}/payments/create',
    [TraderTaxPaymentController::class, 'create']
)->name('trader-tax-payments.create');

Route::post('/trader-taxes/{traderTax}/payments',
    [TraderTaxPaymentController::class, 'store']
)->name('trader-tax-payments.store');

Route::get('/trader-tax-payments/{id}/edit',
    [TraderTaxPaymentController::class, 'edit']
)->name('trader-tax-payments.edit');

Route::put('/trader-tax-payments/{id}',
    [TraderTaxPaymentController::class, 'update']
)->name('trader-tax-payments.update');

Route::delete('/payment/{id}',
    [TraderTaxPaymentController::class, 'destroy']
)->name('trader-tax-payments.destroy');

Route::get('/trader-tax-payments/{id}/facture',
    [TraderTaxPaymentController::class, 'facture']
)->name('trader-tax-payments.facture');

Route::get('/taxes/{tax}/payments',
    [TaxesPaymentController::class, 'index']
)->name('tax-payments.index');

Route::get('/taxes/{tax}/payments/create',
    [TaxesPaymentController::class, 'create']
)->name('tax-payments.create');

Route::post('/taxes/{tax}/payments',
    [TaxesPaymentController::class, 'store']
)->name('tax-payments.store');

Route::get('/taxes-payments/{id}/edit',
    [TaxesPaymentController::class, 'edit']
)->name('tax-payments.edit');

Route::put('/taxes-payments/{id}',
    [TaxesPaymentController::class, 'update']
)->name('tax-payments.update');

Route::delete('/taxes-payments/{id}',
    [TaxesPaymentController::class, 'destroy']
)->name('tax-payments.destroy');
Route::get('/taxes-payments/{id}/facture',
    [TaxesPaymentController::class, 'facture']
)->name('taxes-payments.facture');


    Route::get('/test', function () {
    return view('test');
   
    });