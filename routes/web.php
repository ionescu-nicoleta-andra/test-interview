<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ImportController::class, 'import'])->name('import');
