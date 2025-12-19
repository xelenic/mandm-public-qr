<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Already Claimed - M&M's Festive Sure-Win</title>
    <link rel="stylesheet" href="{{url('qr_portal')}}/font-awesome.min.css">
    <link rel="stylesheet" id="bootstrap-css-css" href="{{url('qr_portal')}}/bootstrap.min.css" media="all">
    <link rel="stylesheet" id="mytheme-custom-style-css" href="{{url('qr_portal')}}/style(2).css" media="all">
    <style>
        body {
            margin: 0;
            font-family: var(--font-sans-var);
            background: #FFD210;
            min-height: 100vh;
            position: relative;
        }
        .already-scanned-container {
            max-width: 768px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
        }
        .warning-card {
            background: #fff;
            border-radius: 20px;
            margin: 20px;
            padding: 40px 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
            text-align: center;
        }
        .warning-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        .warning-heading {
            font-family: var(--font-sans-bold);
            font-size: 36px;
            font-weight: 700;
            color: #D70100;
            text-align: center;
            margin-bottom: 15px;
        }
        .warning-message {
            font-size: 18px;
            color: #5A1F06;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .info-box {
            background: #fef3c7;
            border: 2px solid #fbbf24;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }
        .info-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #92400e;
        }
        .info-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
            font-family: var(--font-sans-regular);
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #5A1F06;
            font-size: 12px;
            font-family: var(--font-sans-regular);
        }
        @media (max-width: 600px) {
            .warning-heading {
                font-size: 28px;
            }
            .warning-message {
                font-size: 16px;
            }
            .warning-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="already-scanned-container" style="padding-top: 0px;">
        <!-- Header with multiple hanging images and logos -->
        <div class="header" style="z-index: 1000;">
            <img src="{{url('qr_portal')}}/5947.png" alt="5947" class="image1">
            <img src="{{url('qr_portal')}}/5946.png" alt="5946" class="image2">
             <a href="https://mmsfestivesurewin.com/"><img src="{{url('qr_portal')}}/Elements/Logo.png" alt="Logo" class="center-logo"></a>

            <img src="{{url('qr_portal')}}/5948.png" alt="5948" class="image3">
            <img src="{{url('qr_portal')}}/5949.png" alt="5949" class="image4">
        </div>

        <!-- Warning Card -->
        <div class="warning-card" style="margin-top: 100px;">
            <div class="warning-icon">
                ⚠️
            </div>

            <h1 class="warning-heading">Already Claimed</h1>

            <p class="warning-message">
                This QR code has already been scanned and the gift has been claimed
                on <strong>{{ $qrCode->scanned_at->format('M d, Y') }}</strong>.
            </p>

            <p class="warning-message">
                Each QR code can only be used once. If you believe this is an error,
                please contact our support team.
            </p>

            <div class="info-box">
                <strong>QR Code Reference:</strong>
                <p>{{ $qrCode->code }}</p>
            </div>
        </div>

        <div class="footer">
            ©2025 Mars or Affiliates
        </div>
    </div>
</body>
</html>







