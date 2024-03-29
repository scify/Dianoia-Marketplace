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

Route::middleware(['metadata'])->group(function () {
    Route::get('/content-languages', [ResourceController::class, 'getContentLanguages'])->name('content_languages.get');
    Route::get('/content-types', [ResourceController::class, 'getContentTypes'])->name('content_types.get');
    Route::get('/users', [ResourceController::class, 'getUsers'])->name('users.get');
    Route::get('/user-roles', [UserController::class, 'getRoles'])->name('user_roles.get');
    Route::get('/user-role-mapping', [UserController::class, 'getRolesMapping'])->name('user_role_mapping.get');
    Route::get('/content-difficulties', [ResourceController::class, 'getContentDifficulties'])->name('content_difficulties.get');
    Route::get('/resources', [ResourceController::class, 'getResources'])->name('resources.get');
    Route::get('/content-ratings', [ResourceRatingController::class, 'getContentRatings'])->name('content_ratings.get');
    Route::get('/resources/user-rating', [ResourceRatingController::class, 'getUserRatingForResource'])->name('resources.user-rating.get');
    Route::post('/resources/user-rating', [ResourceRatingController::class, 'storeOrUpdateRating'])->name('resources.user-rating.post');
    Route::post('/resources/update-resource-avg-rating', [ResourceRatingController::class, 'storeOrUpdateAverageResourceRating'])->name('resources.update_resource_rating.post');
    Route::get('/resources/user-reports', [ResourceController::class, 'getReports'])->name('resources.user-reports.get');
    Route::post('/resources/respond', [ResourceController::class, 'respond'])->name('resources.respond.post');
});
