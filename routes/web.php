<?php

use App\Http\Controllers\PDFGeneratorController;

// List all documents
Route::get('/documents', [PDFGeneratorController::class, 'index'])->name('documents.index');

// Show the form to upload a new template
Route::get('/documents/create', [PDFGeneratorController::class, 'create'])->name('documents.create');

// Handle the form submission for template upload
Route::post('/documents', [PDFGeneratorController::class, 'store'])->name('documents.store');

// Show a document and form for filling fields
Route::get('documents/{document}/fill', [PDFGeneratorController::class, 'edit'])->name('documents.fill');

// Generate a PDF from the template with user input
Route::post('documents/{document}/generate', [PDFGeneratorController::class, 'generate'])->name('documents.generate');

Route::get('/', [PDFGeneratorController::class, 'index']);