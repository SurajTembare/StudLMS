
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Certificate of Completion
    </title>

    <style>

        @page {
            margin: 0;
            size: A4 landscape;
        }


        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;
            padding: 0;

            font-family: DejaVu Sans, sans-serif;

            background: #ffffff;

        }


        /* ==========================================
           Main Certificate
        ========================================== */

        .certificate {

            width: 100%;

            height: 100vh;

            padding: 25px;

            background: #ffffff;

        }


        .outer-border {

            width: 100%;

            height: 100%;

            border: 12px solid #173f5f;

            padding: 12px;

        }


        .inner-border {

            width: 100%;

            height: 100%;

            border: 2px solid #d4a017;

            padding: 35px;

            text-align: center;

            position: relative;

        }


        /* ==========================================
           Header
        ========================================== */

        .header-table {

            width: 100%;

            border-collapse: collapse;

            margin-bottom: 15px;

        }


        .logo-box {

            width: 70px;

            height: 70px;

            text-align: center;

            vertical-align: middle;

            font-size: 40px;

        }


        .academy-name {

            text-align: center;

        }


        .academy-title {

            font-size: 24px;

            font-weight: bold;

            color: #173f5f;

            margin: 0;

        }


        .academy-subtitle {

            font-size: 11px;

            color: #777777;

            margin-top: 5px;

        }


        /* ==========================================
           Certificate Title
        ========================================== */

        .certificate-title {

            font-family: DejaVu Serif, serif;

            font-size: 38px;

            font-weight: bold;

            color: #173f5f;

            margin-top: 20px;

            margin-bottom: 20px;

        }


        .award-text {

            font-size: 12px;

            letter-spacing: 3px;

            color: #888888;

            margin-bottom: 20px;

        }


        /* ==========================================
           Student Name
        ========================================== */

        .student-name {

            display: inline-block;

            font-family: DejaVu Serif, serif;

            font-size: 34px;

            font-weight: bold;

            color: #222222;

            padding: 8px 50px;

            border-bottom: 2px solid #d4a017;

            margin-bottom: 20px;

        }


        /* ==========================================
           Course Details
        ========================================== */

        .completion-text {

            font-size: 16px;

            color: #666666;

            margin-bottom: 10px;

        }


        .course-name {

            font-size: 25px;

            font-weight: bold;

            color: #173f5f;

            margin: 10px 0;

        }


        .description {

            max-width: 650px;

            margin: 15px auto;

            font-size: 12px;

            color: #777777;

            line-height: 1.6;

        }


        /* ==========================================
           Certificate Details
        ========================================== */

        .details-table {

            width: 70%;

            margin: 25px auto;

            border-collapse: collapse;

        }


        .details-table td {

            width: 50%;

            text-align: center;

            vertical-align: top;

            padding: 5px 20px;

        }


        .detail-divider {

            border-right: 1px solid #cccccc;

        }


        .detail-label {

            display: block;

            font-size: 10px;

            color: #888888;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 5px;

        }


        .detail-value {

            font-size: 13px;

            font-weight: bold;

            color: #333333;

        }


        /* ==========================================
           Footer / Signatures
        ========================================== */

        .footer-table {

            width: 100%;

            margin-top: 35px;

            border-collapse: collapse;

        }


        .footer-table td {

            width: 33%;

            text-align: center;

            vertical-align: bottom;

        }


        .signature-line {

            width: 160px;

            border-top: 1px solid #333333;

            margin: 0 auto 8px;

        }


        .signature-title {

            font-size: 11px;

            font-weight: bold;

            color: #333333;

        }


        .signature-subtitle {

            font-size: 9px;

            color: #888888;

            margin-top: 4px;

        }


        /* ==========================================
           Official Seal
        ========================================== */

        .seal {

            width: 80px;

            height: 80px;

            border: 4px double #d4a017;

            border-radius: 50%;

            margin: auto;

            text-align: center;

            padding-top: 17px;

            color: #d4a017;

        }


        .seal-title {

            font-size: 10px;

            font-weight: bold;

        }


        .seal-subtitle {

            font-size: 8px;

            margin-top: 6px;

        }


        /* ==========================================
           Decorative Corners
        ========================================== */

        .corner {

            position: absolute;

            width: 50px;

            height: 50px;

            border-color: #d4a017;

        }


        .top-left {

            top: 12px;

            left: 12px;

            border-top: 4px solid;

            border-left: 4px solid;

        }


        .top-right {

            top: 12px;

            right: 12px;

            border-top: 4px solid;

            border-right: 4px solid;

        }


        .bottom-left {

            bottom: 12px;

            left: 12px;

            border-bottom: 4px solid;

            border-left: 4px solid;

        }


        .bottom-right {

            bottom: 12px;

            right: 12px;

            border-bottom: 4px solid;

            border-right: 4px solid;

        }

    </style>

</head>


<body>

    <div class="certificate">

        <div class="outer-border">

            <div class="inner-border">


                {{-- Decorative Corners --}}

                <div class="corner top-left"></div>

                <div class="corner top-right"></div>

                <div class="corner bottom-left"></div>

                <div class="corner bottom-right"></div>


                {{-- =====================================
                    Academy Header
                ====================================== --}}

                <table class="header-table">

                    <tr>

                        <td class="logo-box">

                            &#127891;

                        </td>


                        <td class="academy-name">

                            <div class="academy-title">

                               StudentLMS

                            </div>


                            <div class="academy-subtitle">

                                Professional Learning & Development

                            </div>

                        </td>


                        <td style="width:70px;">

                        </td>

                    </tr>

                </table>


                {{-- =====================================
                    Certificate Title
                ====================================== --}}

                <div class="certificate-title">

                    Certificate of Completion

                </div>


                <div class="award-text">

                    THIS CERTIFICATE IS PROUDLY PRESENTED TO

                </div>


                {{-- Student Name --}}

                <div class="student-name">

                    {{ $certificate->user->name }}

                </div>


                {{-- =====================================
                    Course Information
                ====================================== --}}

                <div class="completion-text">

                    For successfully completing the course

                </div>


                <div class="course-name">

                    {{ $certificate->course->title }}

                </div>


                <div class="description">

                    This certificate recognizes the successful completion
                    of all required lectures and assessments associated
                    with this course.

                </div>


                {{-- =====================================
                    Certificate Information
                ====================================== --}}

                <table class="details-table">

                    <tr>

                        <td class="detail-divider">

                            <span class="detail-label">

                                Certificate Number

                            </span>


                            <span class="detail-value">

                                {{ $certificate->certificate_number }}

                            </span>

                        </td>


                        <td>

                            <span class="detail-label">

                                Date Issued

                            </span>


                            <span class="detail-value">

                                {{ $certificate->issued_at->format('d F Y') }}

                            </span>

                        </td>

                    </tr>

                </table>


                {{-- =====================================
                    Signatures & Seal
                ====================================== --}}

                <table class="footer-table">

                    <tr>


                        {{-- Instructor --}}

                        <td>

                            <div class="signature-line"></div>


                            <div class="signature-title">

                                Course Instructor

                            </div>


                            <div class="signature-subtitle">

                                Authorized Instructor

                            </div>

                        </td>


                        {{-- Official Seal --}}

                        <td>

                            <div class="seal">

                                <div class="seal-title">

                                    VERIFIED

                                </div>


                                <div class="seal-subtitle">

                                    CERTIFICATE

                                </div>

                            </div>

                        </td>


                        {{-- Authorized Signature --}}

                        <td>

                            <div class="signature-line"></div>


                            <div class="signature-title">

                                Authorized Signature

                            </div>


                            <div class="signature-subtitle">

                                Learning Academy

                            </div>

                        </td>


                    </tr>

                </table>


            </div>

        </div>

    </div>

</body>

</html>

