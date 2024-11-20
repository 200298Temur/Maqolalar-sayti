<?php

use App\Http\Controllers\TelegrammController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', [TelegrammController::class, 'handle']);
