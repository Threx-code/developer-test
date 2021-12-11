<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/', [AchievementsController::class, 'index']);
Route::post('/subscribe', [AchievementsController::class, 'store']);

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);
