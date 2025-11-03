<?php

namespace App\Http\Controllers;

use App\Models\File;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class PDFGeneratorController extends Controller
{
    /**
     * Show the home page with available templates.
     */
    public function index()
    {
        $templatePath = storage_path('app/templates/');
        $templates = glob($templatePath . '*.docx'); // Get all .docx files

        return view('documents.index', compact('templates'));
    }

    /**
     * Show the form for filling a selected template.
     */
    public function edit($id)
    {
        $templatePath = storage_path('app/templates/');
        $templates = glob($templatePath . '*.docx');

        if (!isset($templates[$id])) {
            abort(404, "Template not found.");
        }

        $filename = basename($templates[$id]);

        if (str_contains($filename, 'payment_instruction')) {
            return view('documents.payment_instruction', compact('filename', 'id'));
        } elseif (str_contains($filename, 'loading_order')) {
            return view('documents.loading_order', compact('filename', 'id'));
        } elseif (str_contains($filename, 'local_invoice')) { 
            return view('documents.local_invoice', compact('filename', 'id'));
        } else {
            return view('documents.fill', compact('filename', 'id'));
        }
    }

    /**
     * Generate PDF from the filled template.
     */
    public function generate(Request $request, $id)
    {
        $templatePath = storage_path('app/templates/');
        $templates = glob($templatePath . '*.docx');

        if (!isset($templates[$id])) {
            return back()->with('error', 'Template not found.');
        }

        $templateFile = $templates[$id];

        try {
            $templateProcessor = new TemplateProcessor($templateFile);
            $variables = $templateProcessor->getVariables();

            $total = 0;
            $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);

            for ($i = 1; $i <= 2; $i++) {
                $vol = (float) $request->input('vol' . $i, 0);
                $rate = 0;
                if ($request->input('item' . $i) == 'AGO') {
                    $rate = 154;
                } elseif ($request->input('item' . $i) == 'PMS') {
                    $rate = 164;
                }

                $amount = $vol * $rate;
                $request->merge([
                    'rate' . $i => number_format($rate, 2, '.', ','),
                    'amount' . $i => number_format($amount, 2, '.', ',')
                ]);

                $total += $amount;
            }

            // Get the formatted number in words
            $wordsRaw = $formatter->format($total);
            
            // Function to properly format large numbers with "and" in the correct places
            $formattedWords = $this->formatNumberWords($total);
            
            $request->merge([
                'total' => number_format($total, 2, '.', ','),
                'total_in_words' => $formattedWords
            ]);

            foreach ($variables as $variable) {
                $templateProcessor->setValue($variable, $request->input($variable, ''));
            }

            $docxFile = storage_path('app/temp/' . uniqid() . '.docx');
            $templateProcessor->saveAs($docxFile);

            $pdfFile = str_replace('.docx', '.pdf', $docxFile);
            $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
            $command = "$libreOfficePath --headless --convert-to pdf " . escapeshellarg($docxFile) . " --outdir " . escapeshellarg(dirname($pdfFile));
            shell_exec($command);

            if (!file_exists($pdfFile)) {
                return back()->with('error', 'PDF generation failed.');
            }

            unlink($docxFile);

            return response()->download($pdfFile)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
    
    /**
     * Format a number into words with proper capitalization and "and" placement
     */
    private function formatNumberWords($number)
    {
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        
        // Get the basic word format
        $words = $formatter->format($number);
        
        // Replace hyphens and commas with spaces for consistent formatting
        $words = str_replace(['-', ','], ' ', $words);
        
        // Handle decimal part if present
        $parts = explode('point', $words);
        $wholeNumber = trim($parts[0]);
        
        // Insert "and" at appropriate places for whole numbers
        // For numbers > 100, insert "and" after the hundreds/thousands/millions place
        $patterns = [
            '/\b(hundred|thousand|million|billion|trillion)\b(?!\s+and\b)(?=\s+\w+)/' => '$1 And',
        ];
        
        $wholeNumber = preg_replace(array_keys($patterns), array_values($patterns), $wholeNumber);
        
        // Capitalize each word
        $words = ucwords($wholeNumber);
        
        // Handle the decimal part if exists
        if (isset($parts[1])) {
            $decimal = ucwords(trim($parts[1]));
            $words .= ' Point ' . $decimal;
        }
        
        return $words;
    }
}