<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You! - M&M's Festive Sure-Win</title>
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
        .thanks-container {
            max-width: 768px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
        }
        .got-it-btn {
            background: #D70100;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            width: 200px;
        }
        .got-it-btn:hover {
            background: #b30000;
        }
        .thanks-card {
            background: #fff;
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
            text-align: center;
        }
        .thanks-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .thanks-heading {
            font-family: var(--font-sans-bold);
            font-size: 36px;
            font-weight: 700;
            color: #D70100;
            text-align: center;
            margin-bottom: 15px;
        }
        .thanks-message {
            font-family: var(--font-sans-regular);
            font-size: 18px;
            color: #5A1F06;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .reference-code {
            background: #f9fafb;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }
        .reference-code-label {
            font-family: var(--font-sans-regular);
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .reference-code-value {
            font-family: var(--font-sans-bold);
            font-size: 18px;
            color: #D70100;
            letter-spacing: 2px;
        }
        .next-steps {
            font-family: var(--font-sans-regular);
            font-size: 16px;
            color: #5A1F06;
            text-align: left;
            margin-top: 25px;
            padding: 20px;
            background: #fef3c7;
            border-radius: 10px;
        }
        .next-steps h3 {
            font-family: var(--font-sans-bold);
            font-size: 18px;
            color: #D70100;
            margin-bottom: 10px;
        }
        .next-steps p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .menu-hero {
            margin: 8px 0 18px;
        }
        .menu-hero img {
            width: 100%;
            max-width: 360px;
            height: auto;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #5A1F06;
            font-size: 12px;
            font-family: var(--font-sans-regular);
        }
        @media (max-width: 600px) {
            .thanks-heading {
                font-size: 28px;
            }
            .thanks-message {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="thanks-container" style="padding-top: 0px;">
        <!-- Header with multiple hanging images and logos -->
        <div class="header" style="z-index: 1000;">
            <img src="{{url('qr_portal')}}/5947.png" alt="5947" class="image1">
            <img src="{{url('qr_portal')}}/5946.png" alt="5946" class="image2">
             <a href="https://mmsfestivesurewin.com/"><img src="{{url('qr_portal')}}/Elements/Logo.png" alt="Logo" class="center-logo"></a>

            <img src="{{url('qr_portal')}}/5948.png" alt="5948" class="image3">
            <img src="{{url('qr_portal')}}/5949.png" alt="5949" class="image4">
        </div>

        <!-- Menu Section -->
        <div class="menu-hero" style="margin-top: 100px; text-align: center;">
            <img src="{{url('qr_portal')}}/Elements/Crew.png" alt="M&amp;M Characters">
        </div>

        <div class="menu-buttons" style="text-align: center; margin: 20px;">
            <a href="{{ route('qr.scan', ['code' => $qrCode->code]) }}" class="menu-btn claim-btn">Claim your Prize</a>
            <a href="{{ route('qr.how-to-join', ['code' => $qrCode->code]) }}" class="menu-btn">Campaign Details</a>
            <a href="{{ url('/winners-gallery') }}" class="menu-btn">Winners Gallery</a>
        </div>

        <!-- Thanks Card -->
        <div class="thanks-card">

            <div class="prize-card" style="border-style: unset;max-width:fit-content;margin-top: 100px;padding-bottom: 30px;">
                <img src="{{url('qr_portal')}}/Elements/Hang tight.jpeg" alt="Gift Voucher" class="voucher-image" style="border-style: unset;width: 100%;">
                <button onclick="window.location.href='{{ url('qr', ['code' => $qrCode->code]) }}'" class="got-it-btn">Got it</button>

            </div>
        </div>

        <div class="footer">
            ©2025 Mars or Affiliates
        </div>
    </div>
</body>
</html>

