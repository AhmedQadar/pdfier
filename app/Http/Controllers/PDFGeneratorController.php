<?php

namespace App\Http\Controllers;

use App\Models\Document;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PDFGeneratorController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    /**
     * Show form for uploading a new template.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a new document template.
     */
    public function store(Request $request)
    {
        $request->validate([
            'template' => 'required|file|mimes:docx',
            'name' => 'required|string|max:255',
        ]);

        // Store uploaded template in storage/app/templates
        $templatePath = $request->file('template')->store('templates', 'local');

        // Save document details to the database
        Document::create([
            'name' => $request->name,
            'template_path' => $templatePath,
            'status' => 'ready'
        ]);

        return redirect()->route('documents.index')->with('success', 'Template uploaded successfully');
    }

    /**
     * Show form for generating a document.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        // Assuming templates are stored in 'storage/app/templates'
        $templates = Document::all(); // Fetch all templates (modify if needed)

        return view('documents.fill', compact('document', 'templates'));
    }
    public function generate(Request $request, Document $document)
    {
        try {
            // Validate form inputs
            $request->validate([
                'orderNo' => 'required|string',
                'LPOno' => 'required|string',
                'date' => 'required|date',
                'LoadLoc' => 'required|string',
                'quantity' => 'required|string',
                'product' => 'required|string',
                'customername' => 'required|string',
                'paymentterms' => 'required|string',
                'adress' => 'required|string',
                'destination' => 'required|string',
                'registration' => 'required|string',
                'transporter' => 'required|string',
                'comp1' => 'nullable|string',
                'comp2' => 'nullable|string',
                'comp3' => 'nullable|string',
                'comp4' => 'nullable|string',
                'comp5' => 'nullable|string',
                'comp6' => 'nullable|string',
                'kraentryno' => 'required|string',
                'bookingno' => 'required|string',
            ]);

            // Load template
            $templatePath = storage_path('app/' . $document->template_path);
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

            // Replace placeholders with user inputs
            $templateProcessor->setValue('orderNo', $request->orderNo);
            $templateProcessor->setValue('LPOno', $request->LPOno);
            $templateProcessor->setValue('date', $request->date);
            $templateProcessor->setValue('LoadLoc', $request->LoadLoc);
            $templateProcessor->setValue('quantity', $request->quantity);
            $templateProcessor->setValue('product', $request->product);
            $templateProcessor->setValue('customername', $request->customername);
            $templateProcessor->setValue('paymentterms', $request->paymentterms);
            $templateProcessor->setValue('adress', $request->adress);
            $templateProcessor->setValue('destination', $request->destination);
            $templateProcessor->setValue('registration', $request->registration);
            $templateProcessor->setValue('transporter', $request->transporter);
            $templateProcessor->setValue('comp1', $request->comp1);
            $templateProcessor->setValue('comp2', $request->comp2);
            $templateProcessor->setValue('comp3', $request->comp3);
            $templateProcessor->setValue('comp4', $request->comp4);
            $templateProcessor->setValue('comp5', $request->comp5);
            $templateProcessor->setValue('comp6', $request->comp6);
            $templateProcessor->setValue('kraentryno', $request->kraentryno);
            $templateProcessor->setValue('bookingno', $request->bookingno);

            // Save the updated document
            $outputPath = storage_path('app/temp/' . uniqid() . '.docx');
            $templateProcessor->saveAs($outputPath);

            // Convert to PDF (Optional)
            $pdfPath = storage_path('app/temp/' . uniqid() . '.pdf');
            $htmlContent = "<h1>Loading Order</h1><p>Order Number: " . $request->orderNo . "</p>";
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($htmlContent);
            $pdf->save($pdfPath);

            // Return file for download
            return response()->download($outputPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate document: ' . $e->getMessage());
        }
    }

}
