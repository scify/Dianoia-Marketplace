<?php

use App\Http\Controllers\Resource\PatientResourceController;
use App\Http\Controllers\Resource\CarerResourceController;
use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\Resource\ResourcePackageRatingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get("/content-languages", [ResourceController::class, 'getContentLanguages'])->name('content_languages.get');
    Route::get("/content-types", [ResourceController::class, 'getContentTypes'])->name('content_types.get');
    Route::get("/content-difficulties", [ResourceController::class, 'getContentDifficulties'])->name('content_difficulties.get');
    Route::get("/resources", [ResourceController::class, 'getResources'])->name('resources.get');
//    Route::get("/resource/user-rating", [ResourcesRatingController::class, 'getUserRatingForResource'])->name('resources.user-rating.get');

});
