<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FileController::class, 'index'])->name('files.index');
Route::post('files', [FileController::class, 'upload'])->name('files.upload');
Route::delete('files/{file}', [FileController::class, 'delete'])->name('files.delete');
