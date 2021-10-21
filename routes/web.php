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

Route::view('/', 'homepage')->name('homepage');
Route::view('/about', 'about')->name('about');
Route::get('/lang/{lang}', [UserController::class, 'setLangLocaleCookie'])->name('set-lang-locale');
Route::get('/exercises', [ResourceController::class, 'index'])->name('resources.index');
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
            'download_package' => 'resources.download_package',
            'update' => 'resources.update',
            'destroy' => 'resources.destroy'
        ]);
    Route::get('resources/display_exercises', [ResourceController::class, 'display'])->name('resources.display');
    Route::get('resources/approve_pending_packages', [ResourceController::class, 'approve_pending_packages'])->name('resources_packages.approve_pending_packages');
    Route::get("resources/clone_package/{id}", [ResourceController::class, 'clone_package'])->name('resources_packages.clone_package');
    Route::get("/my-packages", [ResourceController::class, 'my_packages'])->name('resources_packages.my_packages');
    Route::get("/resources/delete/package/{id}", [ResourceController::class, 'delete_package'])->name('resources_packages.destroy_package');
    Route::post("/resources/approve/{id}", [ResourceController::class, 'approve'])->name('resources.approve');
    Route::post("/resources/reject/{id}", [ResourceController::class, 'reject'])->name('resources.reject');
    Route::put("/resources/submit/{id}", [ResourceController::class, 'submit'])->name('resources.submit');
    Route::put("/resources/update_resource/{id}/{type_id}", [ResourceController::class, 'update_resource'])->name('resources.update_resource');
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
