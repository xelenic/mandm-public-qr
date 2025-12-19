<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Congratulations! - M&M's Festive Sure-Win</title>
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
        .reveal-container {
            max-width: 768px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
        }
        .prize-card {
            background: #fff;
            border-radius: 20px;
            margin: 30px;
            padding: 30px 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }
        .voucher-image {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
            border-radius: 10px;
            border: 2px solid #f0f0f0;
        }
        .congrats-text {
            font-family: var(--font-sans-bold);
            font-size: 36px;
            font-weight: 700;
            color: #D70100;
            text-align: center;
            margin-bottom: 10px;
        }
        .you-won-text {
            font-family: var(--font-sans-regular);
            font-size: 20px;
            color: #D70100;
            text-align: center;
            margin-bottom: 15px;
        }
        .prize-amount {
            font-family: var(--font-sans-bold);
            font-size: 48px;
            font-weight: 700;
            color: #D70100;
            text-align: center;
            margin-bottom: 10px;
        }
        .prize-type {
            font-family: var(--font-sans-regular);
            font-size: 18px;
            color: #D70100;
            text-align: center;
            margin-bottom: 30px;
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
        .footer {
            text-align: center;
            padding: 20px;
            color: #5A1F06;
            font-size: 12px;
            font-family: var(--font-sans-regular);
        }
        /* Preloader Styles */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #FFD210;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        .preloader-spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #D70100;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (max-width: 600px) {
            .congrats-text {
                font-size: 28px;
            }
            .prize-amount {
                font-size: 36px;
            }
            .you-won-text {
                font-size: 16px;
            }
            .prize-type {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-spinner"></div>
    </div>

    <div class="reveal-container">
        <!-- Header with multiple hanging images and logos -->
        <div class="header" style="z-index: 1000;">
            <img src="{{url('qr_portal')}}/5947.png" alt="5947" class="image1">
            <img src="{{url('qr_portal')}}/5946.png" alt="5946" class="image2">
             <a href="https://mmsfestivesurewin.com/"><img src="{{url('qr_portal')}}/Elements/Logo.png" alt="Logo" class="center-logo"></a>

            <img src="{{url('qr_portal')}}/5948.png" alt="5948" class="image3">
            <img src="{{url('qr_portal')}}/5949.png" alt="5949" class="image4">
        </div>

        <!-- Prize Card -->
        <div class="prize-card" style="border-style: unset;max-width:fit-content;margin-top: 100px;">
            @if($qrCode->gift->name == "Spa Ceylon Gift Voucher")
                <img src="{{url('qr_portal')}}/Elements/5000.jpeg" alt="Gift Voucher" class="voucher-image" style="border-style: unset;width: 100%;">
            @elseif($qrCode->gift->name == "Shagila Dinner Voucher")
                <img src="{{url('qr_portal')}}/Elements/10000.jpeg" alt="Gift Voucher" class="voucher-image" style="border-style: unset;width: 100%;">
            @endif

            <button onclick="window.location.href='{{ route('qr.thanks', ['code' => $qrCode->code]) }}'" class="got-it-btn">Got it</button>
        </div>

        <div class="footer">
            ©2025 Mars or Affiliates
        </div>
    </div>

    <script>
        // Hide preloader when page is loaded
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('hidden');
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 500);
            }
        });
    </script>
</body>
</html>
