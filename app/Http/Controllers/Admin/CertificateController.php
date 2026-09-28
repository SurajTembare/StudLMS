<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * Display all certificates.
     */
    public function index(Request $request)
    {
        $query = Certificate::with([
            'user',
            'course'
        ]);

        // Search certificate, student or course
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'certificate_number',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })

                ->orWhereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery
                        ->where('title', 'like', '%' . $search . '%');
                });
            });
        }

        $certificates = $query
            ->latest('issued_at')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.certificates.index',
            compact('certificates')
        );
    }


    /**
     * Show certificate details.
     */
    public function show($id)
    {
        $certificate = Certificate::with([
            'user',
            'course'
        ])->findOrFail($id);

        return view(
            'admin.certificates.show',
            compact('certificate')
        );
    }


    /**
     * Download certificate PDF.
     */
    public function download($id)
    {
        $certificate = Certificate::with([
            'user',
            'course'
        ])->findOrFail($id);

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
     * Delete certificate.
     */
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);

        $certificate->delete();

        return redirect()
            ->route('admin.certificates.index')
            ->with(
                'success',
                'Certificate deleted successfully.'
            );
    }
}