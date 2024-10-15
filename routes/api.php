<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlacementController;

Route::any('/placements', [PlacementController::class, 'index']);
