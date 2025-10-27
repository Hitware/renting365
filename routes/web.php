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
    return view('welcome');
});

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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management Routes
    Route::resource('users', UserController::class)->middleware('can:users.view');

    // Motorcycle Management Routes
    Route::resource('motorcycles', MotorcycleController::class)->middleware('can:motorcycles.view');

    // Client Management Routes (Hoja de Vida de Persona)
    Route::resource('clients', ClientController::class)->middleware('can:clients.view');
    Route::get('client-documents/{document}/view', [\App\Http\Controllers\ClientDocumentController::class, 'view'])
        ->name('client.document.view')
        ->middleware('can:clients.view');

    // Leasing Contract Routes
    Route::resource('leasing-contracts', \App\Http\Controllers\LeasingContractController::class)->middleware('can:clients.view');
    Route::get('leasing-contracts/{leasingContract}/contract-pdf', [\App\Http\Controllers\LeasingContractController::class, 'viewContract'])
        ->name('leasing.contract.view')
        ->middleware('can:clients.view');
    Route::get('leasing-contracts/{leasingContract}/print-schedule', [\App\Http\Controllers\LeasingContractController::class, 'printPaymentSchedule'])
        ->name('leasing.print.schedule')
        ->middleware('can:clients.view');
    Route::get('leasing-contracts/{leasingContract}/print-contract', [\App\Http\Controllers\LeasingContractController::class, 'printContract'])
        ->name('leasing.print.contract')
        ->middleware('can:clients.view');
});
