<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Show student certificate.
     */
    public function show($certificateId)
    {
        $certificate = Certificate::with([
            'user',
            'course'
        ])
            ->where('id', $certificateId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view(
            'frontend.certificate.show',
            compact('certificate')
        );
    }


    /**
     * Show all certificates of logged-in student.
     */
    public function index()
    {
        $certificates = Certificate::with('course')
            ->where('user_id', Auth::id())
            ->latest('issued_at')
            ->get();

        return view(
            'frontend.certificate.index',
            compact('certificates')
        );
    }

    /**
     * Download certificate as PDF.
     */
    public function download($certificateId)
    {
        $certificate = Certificate::with([
            'user',
            'course'
        ])
            ->where('id', $certificateId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView(
            'frontend.certificate.pdf',
            compact('certificate')
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'Certificate-' .
                $certificate->certificate_number .
                '.pdf'
        );
    }

    /**
     * Show certificate verification form.
     */
    public function verifyForm()
    {
        return view('frontend.certificate.verify');
    }


    /**
     * Verify certificate number.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string',
        ]);

        $certificate = Certificate::with([
            'user',
            'course'
        ])
            ->where(
                'certificate_number',
                $request->certificate_number
            )
            ->first();

        return view(
            'frontend.certificate.verify',
            compact('certificate')
        );
    }
}
