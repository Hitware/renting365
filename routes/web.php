<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::post('/api/chatbot/message', [\App\Http\Controllers\ChatbotController::class, 'sendMessage'])->name('chatbot.message');

// Ruta para ejecutar migraciones (protegida con clave)
Route::get('/run-migrations/{key}', function($key) {
    if ($key !== config('app.migration_key', 'renting365-secret-key-2024')) {
        abort(403, 'Acceso no autorizado');
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return response()->json([
            'success' => true,
            'message' => 'Migraciones ejecutadas correctamente',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al ejecutar migraciones',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('run.migrations');

// Ruta para ejecutar seeders (protegida con clave)
Route::get('/run-seeders/{key}', function($key) {
    if ($key !== config('app.migration_key', 'renting365-secret-key-2024')) {
        abort(403, 'Acceso no autorizado');
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        
        return response()->json([
            'success' => true,
            'message' => 'Seeders ejecutados correctamente',
            'output' => $output,
            'info' => 'Se han creado usuarios, roles, permisos y datos de ejemplo'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al ejecutar seeders',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('run.seeders');

// Ruta de prueba para debug
Route::get('/test-contract/{hash}', function($hash) {
    $contract = (new \App\Models\LeasingContract)->resolveRouteBinding($hash);
    if (!$contract) {
        return 'Contract not found';
    }
    $contract->load(['client', 'motorcycle', 'payments']);
    return [
        'id' => $contract->id,
        'number' => $contract->contract_number,
        'client' => $contract->client ? $contract->client->full_name : null,
        'motorcycle' => $contract->motorcycle ? $contract->motorcycle->brand . ' ' . $contract->motorcycle->model : null,
        'payments' => $contract->payments->count()
    ];
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'throttle:120,1',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::resource('users', UserController::class)->middleware('can:users.view');

    // Motorcycle Management Routes
    Route::resource('motorcycles', MotorcycleController::class)->middleware('can:motorcycles.view');

    // Client Management Routes (Hoja de Vida de Persona)
    Route::resource('clients', ClientController::class)->middleware('can:clients.view');
    Route::get('clients/create-from-application/{application}', [ClientController::class, 'createFromApplication'])
        ->name('clients.create-from-application')
        ->middleware('can:clients.view');
    Route::get('client-documents/{document}/view', [\App\Http\Controllers\ClientDocumentController::class, 'view'])
        ->name('client.document.view')
        ->middleware('can:clients.view');

    // Credit Applications Routes
    Route::get('credit-applications', [\App\Http\Controllers\CreditApplicationController::class, 'index'])
        ->name('credit-applications.index')
        ->middleware('can:clients.view');

    // Leasing Contract Routes
    Route::resource('leasing-contracts', \App\Http\Controllers\LeasingContractController::class);
    Route::get('leasing-contracts/{leasingContract}/contract-pdf', [\App\Http\Controllers\LeasingContractController::class, 'viewContract'])
        ->name('leasing.contract.view');
    Route::get('leasing-contracts/{leasingContract}/print-schedule', [\App\Http\Controllers\LeasingContractController::class, 'printPaymentSchedule'])
        ->name('leasing.print.schedule');
    Route::get('leasing-contracts/{leasingContract}/print-contract', [\App\Http\Controllers\LeasingContractController::class, 'printContract'])
        ->name('leasing.print.contract');

    // Payment Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])
            ->name('index');
        Route::get('/create', [\App\Http\Controllers\PaymentController::class, 'create'])
            ->name('create')
            ->middleware('can:payments.create');
        Route::get('/today', [\App\Http\Controllers\PaymentController::class, 'today'])
            ->name('today');
        Route::get('/overdue', [\App\Http\Controllers\PaymentController::class, 'overdue'])
            ->name('overdue');
        Route::get('/upcoming', [\App\Http\Controllers\PaymentController::class, 'upcoming'])
            ->name('upcoming');
        Route::get('/history', [\App\Http\Controllers\PaymentController::class, 'history'])
            ->name('history');
        Route::get('/{payment}', [\App\Http\Controllers\PaymentController::class, 'show'])
            ->name('show');
    });

    // Client Account Statement Routes
    Route::get('/my-account', [\App\Http\Controllers\ClientAccountController::class, 'index'])
        ->name('client.account')
        ->middleware('can:account.view-own');
    Route::get('/client/{client}/account', [\App\Http\Controllers\ClientAccountController::class, 'show'])
        ->name('client.account.show')
        ->middleware('can:account.view');
});
