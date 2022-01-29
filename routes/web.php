<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyHistoryController;

Route::get('/', [CompanyHistoryController::class, 'create'])->name('company.create');
Route::post('/', [CompanyHistoryController::class, 'store'])->name('company.store');
