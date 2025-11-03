<?php

use App\Http\Controllers\PDFGeneratorController;


// Home Page - Show templates
Route::get('/', [PDFGeneratorController::class, 'index'])->name('documents.index');

// Fill a template
Route::get('/documents/{id}/fill', [PDFGeneratorController::class, 'edit'])->name('documents.fill');

// Generate PDF
Route::post('/documents/{id}/generate', [PDFGeneratorController::class, 'generate'])->name('documents.generate');