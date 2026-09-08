
@extends('frontend.master')

@section('title', 'Certificate of Completion')

@section('content')

<div class="container py-5">

    {{-- Top Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <a href="{{ route('student.certificates.index') }}"
            class="btn btn-outline-dark">

            <i class="fa-solid fa-arrow-left me-2"></i>
            My Certificates

        </a>


        <div class="d-flex gap-2">

            <a href="{{ route('student.certificate.download', $certificate->id) }}"
                class="btn btn-success">

                <i class="fa-solid fa-file-pdf me-2"></i>
                Download PDF

            </a>

            <button onclick="window.print()"
                class="btn btn-primary">

                <i class="fa-solid fa-print me-2"></i>
                Print

            </button>

        </div>

    </div>


    {{-- Certificate --}}
    <div class="certificate-wrapper">

        <div class="certificate">

            {{-- Decorative Top --}}
            <div class="certificate-top-design"></div>


            {{-- Certificate Header --}}
            <div class="certificate-header">

                <div class="academy-logo">

                    <i class="fa-solid fa-graduation-cap"></i>

                </div>


                <div class="academy-name">

                    <h4>StudentLMS</h4>

                    <p>Professional Learning & Development</p>

                </div>

            </div>


            {{-- Certificate Body --}}
            <div class="certificate-body">

                <div class="certificate-icon">

                    <i class="fa-solid fa-award"></i>

                </div>


                <h1 class="certificate-title">

                    Certificate of Completion

                </h1>


                <div class="certificate-subtitle">

                    THIS CERTIFICATE IS PROUDLY PRESENTED TO

                </div>


                {{-- Student Name --}}
                <h2 class="student-name">

                    {{ $certificate->user->name }}

                </h2>


                <div class="certificate-text">

                    For successfully completing the course

                </div>


                {{-- Course Name --}}
                <h3 class="course-name">

                    {{ $certificate->course->title }}

                </h3>


                <p class="certificate-description">

                    This certificate recognizes the successful completion
                    of all required course lectures and assessments.

                </p>


                {{-- Certificate Information --}}
                <div class="certificate-details">

                    <div class="detail-item">

                        <span class="detail-label">
                            Certificate Number
                        </span>

                        <strong>
                            {{ $certificate->certificate_number }}
                        </strong>

                    </div>


                    <div class="detail-divider"></div>


                    <div class="detail-item">

                        <span class="detail-label">
                            Date Issued
                        </span>

                        <strong>
                            {{ $certificate->issued_at->format('d F Y') }}
                        </strong>

                    </div>

                </div>


                {{-- Signatures --}}
                <div class="certificate-footer">

                    <div class="signature">

                        <div class="signature-line"></div>

                        <strong>
                            Course Instructor
                        </strong>

                        <span>
                            Authorized Instructor
                        </span>

                    </div>


                    {{-- Official Seal --}}
                    <div class="certificate-seal">

                        <div class="seal-inner">

                            <i class="fa-solid fa-certificate"></i>

                            <span>VERIFIED</span>

                        </div>

                    </div>


                    <div class="signature">

                        <div class="signature-line"></div>

                        <strong>
                            Authorized Signature
                        </strong>

                        <span>
                            Learning Academy
                        </span>

                    </div>

                </div>

            </div>


            {{-- Decorative Bottom --}}
            <div class="certificate-bottom-design"></div>

        </div>

    </div>


    {{-- Verification Information --}}
    <div class="verification-box mt-4">

        <div>

            <i class="fa-solid fa-shield-halved"></i>

            <div>

                <strong>
                    Certificate Verification
                </strong>

                <p class="mb-0">

                    Verify this certificate using certificate number:
                    <strong>{{ $certificate->certificate_number }}</strong>

                </p>

            </div>

        </div>


        <a href="{{ route('certificate.verify.form') }}"
            class="btn btn-outline-primary">

            Verify Certificate

        </a>

    </div>

</div>


<style>

/* =====================================================
   Certificate Container
===================================================== */

.certificate-wrapper {

    background: #f1f4f8;

    padding: 40px;

    border-radius: 12px;

    overflow-x: auto;

}


.certificate {

    position: relative;

    max-width: 1100px;

    min-height: 720px;

    margin: auto;

    background: #ffffff;

    border: 12px solid #173f5f;

    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);

    overflow: hidden;

}


/* =====================================================
   Decorative Designs
===================================================== */

.certificate-top-design {

    height: 12px;

    background: #173f5f;

}


.certificate-bottom-design {

    position: absolute;

    bottom: 0;

    width: 100%;

    height: 14px;

    background: #173f5f;

}


/* =====================================================
   Certificate Header
===================================================== */

.certificate-header {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 15px;

    padding: 30px 20px;

    border-bottom: 1px solid #e5e7eb;

}


.academy-logo {

    width: 60px;

    height: 60px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #173f5f;

    color: #ffffff;

    font-size: 28px;

}


.academy-name h4 {

    margin: 0;

    font-weight: 700;

    color: #173f5f;

}


.academy-name p {

    margin: 3px 0 0;

    font-size: 14px;

    color: #6b7280;

}


/* =====================================================
   Certificate Body
===================================================== */

.certificate-body {

    text-align: center;

    padding: 35px 60px 50px;

}


.certificate-icon {

    font-size: 45px;

    color: #d4a017;

}


.certificate-title {

    font-family: Georgia, serif;

    font-size: 46px;

    font-weight: 700;

    color: #173f5f;

    margin: 15px 0 20px;

}


.certificate-subtitle {

    font-size: 12px;

    font-weight: 700;

    letter-spacing: 3px;

    color: #9ca3af;

}


/* =====================================================
   Student Name
===================================================== */

.student-name {

    font-family: Georgia, serif;

    font-size: 42px;

    font-weight: 700;

    color: #1f2937;

    margin: 25px 0;

    padding-bottom: 12px;

    border-bottom: 2px solid #d4a017;

    display: inline-block;

    min-width: 350px;

}


/* =====================================================
   Course Details
===================================================== */

.certificate-text {

    font-size: 17px;

    color: #6b7280;

}


.course-name {

    font-size: 28px;

    font-weight: 700;

    color: #173f5f;

    margin: 15px 0;

}


.certificate-description {

    max-width: 650px;

    margin: auto;

    color: #6b7280;

    line-height: 1.7;

}


/* =====================================================
   Certificate Information
===================================================== */

.certificate-details {

    display: flex;

    justify-content: center;

    align-items: center;

    margin: 35px auto;

    max-width: 600px;

}


.detail-item {

    flex: 1;

}


.detail-label {

    display: block;

    font-size: 12px;

    text-transform: uppercase;

    letter-spacing: 1px;

    color: #9ca3af;

    margin-bottom: 6px;

}


.detail-divider {

    height: 45px;

    width: 1px;

    background: #d1d5db;

}


/* =====================================================
   Certificate Footer
===================================================== */

.certificate-footer {

    display: flex;

    justify-content: space-between;

    align-items: end;

    margin-top: 45px;

}


.signature {

    width: 220px;

    text-align: center;

}


.signature-line {

    border-top: 1px solid #374151;

    margin-bottom: 10px;

}


.signature strong {

    display: block;

    font-size: 14px;

    color: #374151;

}


.signature span {

    font-size: 12px;

    color: #9ca3af;

}


/* =====================================================
   Official Seal
===================================================== */

.certificate-seal {

    width: 100px;

    height: 100px;

    border-radius: 50%;

    border: 4px double #d4a017;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #d4a017;

}


.seal-inner {

    display: flex;

    flex-direction: column;

    align-items: center;

    gap: 4px;

    font-size: 12px;

    font-weight: 700;

}


.seal-inner i {

    font-size: 30px;

}


/* =====================================================
   Verification Box
===================================================== */

.verification-box {

    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 10px;

    padding: 20px;

    display: flex;

    align-items: center;

    justify-content: space-between;

}


.verification-box > div {

    display: flex;

    align-items: center;

    gap: 15px;

}


.verification-box i {

    font-size: 30px;

    color: #198754;

}


/* =====================================================
   Mobile Responsive
===================================================== */

@media (max-width: 768px) {

    .certificate-wrapper {

        padding: 15px;

    }


    .certificate {

        min-width: 800px;

    }


    .verification-box {

        flex-direction: column;

        gap: 15px;

        text-align: center;

    }


    .verification-box > div {

        flex-direction: column;

    }

}


/* =====================================================
   Print
===================================================== */

@media print {

    body {

        background: white !important;

    }


    body * {

        visibility: hidden;

    }


    .certificate-wrapper,
    .certificate-wrapper * {

        visibility: visible;

    }


    .certificate-wrapper {

        position: absolute;

        left: 0;

        top: 0;

        width: 100%;

        padding: 0;

        background: white;

    }


    .certificate {

        border-width: 10px;

        box-shadow: none;

        max-width: 100%;

    }

}

</style>

@endsection
```
