<?php

use App\Http\Controllers\Resource\PatientResourceController;
use App\Http\Controllers\Resource\CarerResourceController;
use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');
//Route::view('/homepage', 'homepage')->name('homepage');
Route::view('/about', 'about')->name('about');
Route::get('/lang/{lang}', [UserController::class, 'setLangLocaleCookie'])->name('set-lang-locale');
Route::get('/exercises', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/carer-cards', [CarerResourceController::class, 'index'])->name('carer_resources.index');
//TODO new route for resources with only methods ->only([]) without aliases

#Auth::routes(['verify' => true]);
Route::middleware(['auth'])->group(function () {
    Route::prefix('administration')->middleware("can:manage-platform")->name('administration.')->group(function () {
        Route::resource('users', UserController::class)->except([
            'create', 'edit', 'show'
        ]);
    });

    Route::resource('resources', ResourceController::class)
        ->except([//ONLY
            'index', 'show'
        ])
        ->names([
            'create' => 'resources.create',
            'store' => 'resources.store',
            'edit' => 'resources.edit',
            'download_package' => 'resources.download_package'
        ]);



    Route::get('resources/approve_pending_packages', [ResourceController::class, 'approve_pending_packages'])->name('resources_packages.approve_pending_packages');



    Route::resource('patient-resources', PatientResourceController::class)
        ->except([//ONLY
             'show'
        ])
        ->names([
            'index' => 'patient_resources.index',
            'create' => 'patient_resources.create',
            'store' => 'patient_resources.store',
            'edit' => 'patient_resources.edit',
            'download_package' => 'patient_resources.download_package'
        ]);



    Route::get("resources/clone_package/{id}", [ResourceController::class, 'clone_package'])->name('resources_packages.clone_package');
    Route::get("/my-packages", [ResourceController::class, 'my_packages'])->name('resources_packages.my_packages');
    Route::get("/resources/delete/package/{id}", [ResourceController::class, 'delete_package'])->name('resources_packages.destroy_package');

    Route::get("/patient-cards/download/package/{id}", [PatientResourceController::class, 'download_package'])->name('patient_resources.download_package');


    Route::post("/resources/approve/{id}", [ResourceController::class, 'approve'])->name('resources.approve');
    Route::post("/resources/reject/{id}", [ResourceController::class, 'reject'])->name('resources.reject');
    Route::put("/resources/submit/{id}", [ResourceController::class, 'submit'])->name('resources.submit');
    Route::resource('resources', ResourceController::class)
        ->except([
            'index', 'show', 'create', 'edit'
        ])
        ->names([
            'store' => 'resources.store',
//            'update' => 'resources.update',
            'destroy' => 'resources.destroy'
        ]);
    Route::put("/resources/update_resource/{id}/{type_id}", [ResourceController::class, 'update_resource'])->name('resources.update_resource');


    Route::resource('carer-cards', CarerResourceController::class)
        ->except([
            'index', 'show'
        ])
        ->names([
            'create' => 'carer_resources.create',
            'store' => 'carer_resources.store',
            'edit' => 'carer_resources.edit',
            'update' => 'carer_resources.update',
//            'show_packages' => 'carer_resources.show_packages',
            'show_package' => 'carer_resources.show_package',
            'download_package' => 'carer_resources.download_package'
        ]);

//    Route::get("/carer-cards/show/packages/{type_id}", [CarerResourceController::class, 'show_packages'])->name('carer_resources.my_packages');

    Route::get("/carer-cards/show/package/{id}", [CarerResourceController::class, 'show_package'])->name('carer_resources.show_package');
    Route::get("/carer-cards/download/package/{id}", [CarerResourceController::class, 'download_package'])->name('carer_resources.download_package');


});

Route::get('js/translations.js', function () {
    $lang = config('app.locale');
    Cache::flush();
    $strings = Cache::rememberForever('lang_' . $lang . '.js', function () use ($lang) {
        $files = [
            resource_path('lang/' . $lang . '/messages.php'),
            resource_path('lang/' . $lang . '/validation.php'),
        ];
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });
    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('translations');
