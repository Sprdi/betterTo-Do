<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index'])->name('task.index');
Route::get('/task/finished', [TaskController::class, 'finished'])->name('task.finished');
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::put('/task/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::put('/task/{task}/update-full', [TaskController::class, 'updateFull'])->name('task.updateFull');
