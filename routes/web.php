<?php


use App\Http\Controllers\PlatformStatisticsController;
use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\UserController;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Notifications\AdminNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
Route::view('/content-guidelines', 'content-guidelines')->name('content-guidelines');
Route::view('/tutorial', 'tutorial')->name('tutorial');
//
Route::get('/cookie-policy/{locale}', function () {
    return view('cookie-policy');
});

Route::get('/lang/{lang}', [UserController::class, 'setLangLocaleCookie'])->name('set-lang-locale');

Route::get('resources/display_exercises', [ResourceController::class, 'display'])->name('resources.display');
Route::get('/coming-soon', [ResourceController::class, 'coming_soon'])->name('resources.coming-soon');

Route::middleware(['auth'])->group(function () {
    Route::prefix('administration')->middleware('can:manage-platform')->name('administration.')->group(function () {
        Route::resource('users', UserController::class)->except([
            'create', 'edit', 'show',
        ]);
        Route::get('/admin/exercise-management', [ResourceController::class, 'manage_exercises'])->name('exercises_management');

        Route::get('test-email/{email}', function (Request $request) {
            Notification::send([User::where(['email' => $request->email])->first()], new AdminNotice(Resource::first()));

            return 'Email sent to: ' . $request->email;
        });
        Route::get('/platform-statistics', [PlatformStatisticsController::class, 'show_platform_statistics'])->name('platform_statistics');
    });
    Route::put('/users/update/{user}', [UserController::class, 'updateProfile'])->name('users.update');

    Route::resource('resources', ResourceController::class)
        ->except([// ONLY
            'index', 'show', 'destroy',
        ])
        ->names([
            'create' => 'resources.create',
            'store' => 'resources.store',
            'edit' => 'resources.edit',
            'update' => 'resources.update',
        ]);

    Route::get('/my-profile', [ResourceController::class, 'my_profile'])->name('resources.my_profile');
    Route::delete('/resources/delete/exercise/{id}', [ResourceController::class, 'delete_exercise'])->name('resources.delete_exercise');
    Route::post('/resources/approve/{id}', [ResourceController::class, 'approve'])->middleware('can:manage-platform')->name('resources.approve');
    Route::post('/resources/reject/{id}', [ResourceController::class, 'reject'])->middleware('can:manage-platform')->name('resources.reject');
    Route::post('/resources/report/{id}', [ResourceController::class, 'report'])->name('resources.report');
});

Route::get('js/translations.js', function () {
    $lang = config('app.locale');
    $strings = [];

    foreach (['messages', 'validation'] as $name) {
        $strings[$name] = require app()->langPath() . '/' . $lang . '/' . $name . '.php';
    }

    return response('window.i18n = ' . json_encode($strings) . ';')
        ->header('Content-Type', 'text/javascript');
})->name('translations');
