<?php

use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('approvers')->group(function () {
    Route::post('/', [ApproverController::class, 'store'])->name('approvers.store');
});


Route::prefix('approval-stages')->group(function () {
    Route::post('/', [ApprovalStageController::class, 'store'])->name('approval-stages.store');
    Route::put('/{id}', [ApprovalStageController::class, 'update'])->name('approval-stages.update');
});


Route::prefix('expense')->group(function () {
    Route::post('/', [ExpenseController::class, 'store'])->name('expense.store');
    Route::patch('/{id}/approve', [ExpenseController::class, 'approve'])->name('expense.approve');
    Route::get('/{id}', [ExpenseController::class, 'show'])->name('expense.show');
});
