<?php

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

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get("/content-languages", [ResourceController::class, 'getContentLanguages'])->name('content_languages.get');
    Route::get("/content-types", [ResourceController::class, 'getContentTypes'])->name('content_types.get');
    Route::get("/users", [ResourceController::class, 'getUsers'])->name('users.get');
    Route::get("/content-difficulties", [ResourceController::class, 'getContentDifficulties'])->name('content_difficulties.get');
    Route::get("/resources", [ResourceController::class, 'getResources'])->name('resources.get');
    Route::get("/resources/user-rating", [ResourceRatingController::class, 'getUserRatingForResource'])->name('resources.user-rating.get');
    Route::post("/resources/user-rating", [ResourceRatingController::class, 'storeOrUpdateRating'])->name('resources.user-rating.post');

});
