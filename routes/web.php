<?php

use App\Http\Livewire\UserIndex;
use App\Http\Livewire\CreateUser;
use App\Http\Livewire\ServiceIndex;
use App\Http\Livewire\CreateService;
use App\Http\Livewire\ReportAnalisis;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UserCountReport;
use App\Http\Livewire\UserInteractionReport;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\DailyInteractionReport;
use App\Http\Livewire\EditUser;
use App\Http\Livewire\JoinUS;
use App\Http\Livewire\MonthlyInteractionReport;
use App\Http\Livewire\YearlyInteractionReport;
use App\Http\Livewire\Recommendation;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user-interaction-report', UserInteractionReport::class)->name('user-interaction-report');
    Route::get('/user-count-report', UserCountReport::class)->name('user-count-report');
    Route::get('/report-analisis', ReportAnalisis::class)->name('report-analisis');
    Route::get('/daily-interaction-report', DailyInteractionReport::class)->name('daily-interaction');
    Route::get('/monthly-interaction-report', MonthlyInteractionReport::class)->name('monthly-interaction');
    Route::get('/yearly-interaction-report', YearlyInteractionReport::class)->name('yearly-interaction');
});

Route::get('/services', ServiceIndex::class)->name('services.index');

Route::get('/users', UserIndex::class)->name('users.index');
Route::get('/users/create', CreateUser::class)->name('users.create');
Route::get('/users/{userId}/edit', EditUser::class)->name('users.edit');
Route::post('/users/store', [CreateUser::class, 'saveUser'])->name('users.store');

Route::get('/services/create', CreateService::class)->name('services.create');
Route::post('/services/store', [CreateService::class, 'createService'])->name('services.store');
Route::get('/service-detail/{serviceId}', [ServiceIndex::class, 'showServiceDetail'])->name('service-detail');
Route::get('/join-u-s', JoinUS::class)->name('join.u.s');

Route::post('/recommendation', Recommendation::class)->name('recommendation');
Route::get('/recommendation', Recommendation::class)->name('recommendation');