<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlacementController;

Route::get('/placements', [PlacementController::class, 'index']);
