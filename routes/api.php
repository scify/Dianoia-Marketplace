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
    Route::get("/patient-resources-packages", [PatientResourceController::class, 'getPatientResourcePackages'])->name('patient_resources.get');
    Route::get("/resources-package/user-rating", [ResourcePackageRatingController::class, 'getUserRatingForResourcesPackage'])->name('resources-package.user-rating.get');
    Route::post("/resources-package/user-rating", [ResourcePackageRatingController::class, 'storeOrUpdateRating'])->name('resources-package.user-rating.post');
    Route::get("/carer-resources-packages/", [CarerResourceController::class, 'getCarerResourcePackages'])->name('carer_resources.get');


});
