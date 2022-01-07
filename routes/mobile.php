<?php

use App\Http\Controllers\Resource\ResourceController;
use App\Http\Controllers\Resource\ResourceRatingController;
use App\Http\Controllers\UserController;
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


Route::middleware(['throttle:mobile'])->group(function () {
    Route::get("/exercises-json", [ResourceController::class, 'getTransformAllExercisesForMobileApp'])->name('resources.get-exercises-json.get');
});
