<?php

use Illuminate\Support\Facades\Route;

Route::get('/boostech/cte', [Boostech\Cte\Controllers\HctexController::class, 'index'])->name('boostech_cte.index');
