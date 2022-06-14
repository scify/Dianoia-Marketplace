<?php

use App\Http\Controllers\Analytics\AnalyticsEventController;
use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\Resource\ResourceRatingController;
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


Route::middleware(['mobile'])->group(function () {
    Route::get("/exercises", [ResourceController::class, 'getTransformAllExercisesForMobileApp']);
    Route::post("/analytics/store", [AnalyticsEventController::class, 'store']);
    Route::post("/resources/user-rating", [ResourceRatingController::class, 'storeOrUpdateMobileRating']);
    Route::post("/resources/update-resource-avg-rating", [ResourceRatingController::class, 'storeOrUpdateAverageResourceRating']);
});
