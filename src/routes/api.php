<?php
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

Route::post('/enqueue', [QueueController::class, 'enqueue']);
Route::get('/status/{id}', [QueueController::class, 'status']);
