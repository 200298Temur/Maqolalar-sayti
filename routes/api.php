<?php

use App\Http\Controllers\TelegrambotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', [TelegrambotController::class, 'index']);
