<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Details - M&M's Festive Sure-Win</title>
    <link rel="stylesheet" href="{{url('qr_portal')}}/font-awesome.min.css">
    <link rel="stylesheet" id="bootstrap-css-css" href="{{url('qr_portal')}}/bootstrap.min.css" media="all">
    <link rel="stylesheet" id="mytheme-custom-style-css" href="{{url('qr_portal')}}/style(2).css" media="all">
    <style>
        body {
            margin: 0;
            font-family: var(--font-sans-var);
            background: #FFD210;
            min-height: 100vh;
        }
        .verify-container {
            max-width: 768px;
            margin: 0 auto;
            min-height: 100vh;
            background: #FFD210;
            padding: 20px;
            position: relative;
            margin-top: 80px;
        }
        .verify-form-box {
            background: #00A832;
            border-radius: 20px;
            padding: 30px 25px;
            margin: 20px 0;
            color: #fff;
        }
        .verify-heading {
            font-family: var(--font-sans-bold);
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            text-align: center;
        }
        .verify-instructions {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #fff;
            text-align: center;
        }
        .verify-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
        .verify-field:last-child {
            border-bottom: none;
        }
        .verify-label {
            font-family: var(--font-sans-bold);
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }
        .verify-value {
            font-family: var(--font-sans-regular);
            font-size: 16px;
            color: #fff;
            text-align: right;
        }
        .verify-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn-back {
            flex: 1;
            background: #fff;
            color: #D70100;
            border: none;
            border-radius: 50px;
            padding: 15px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-back:hover {
            background: #f0f0f0;
        }
        .btn-verify {
            flex: 1;
            background: #D70100;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-verify:hover {
            background: #b30000;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #5A1F06;
            font-size: 12px;
            font-family: var(--font-sans-regular);
        }
        .help-text {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #5A1F06;
        }
        .menu-hero {
            margin: 8px 0 18px;
        }
        .menu-hero img {
            width: 100%;
            max-width: 360px;
            height: auto;
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
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-spinner"></div>
    </div>
    <div class="header" style="z-index: 1000;">
        <img src="{{url('qr_portal')}}/5947.png" alt="5947" class="image1">
        <img src="{{url('qr_portal')}}/5946.png" alt="5946" class="image2">
         <a href="https://mmsfestivesurewin.com/"><img src="{{url('qr_portal')}}/Elements/Logo.png" alt="Logo" class="center-logo"></a>

        <img src="{{url('qr_portal')}}/5948.png" alt="5948" class="image3">
        <img src="{{url('qr_portal')}}/5949.png" alt="5949" class="image4">
    </div>
    <div class="verify-container">

        <div class="menu-hero">
            <img src="{{url('qr_portal')}}/Elements/Crew.png" alt="M&amp;M Characters">
        </div>
        <div class="verify-form-box">
            <h2 class="verify-heading">Almost there!</h2>
            <p class="verify-instructions">
                Double-check your holiday details.<br>
                Make sure your info is correct so we can contact you and send your gift to the right place!
            </p>

            <div class="verify-field">
                <span class="verify-label">*First Name :</span>
                <span class="verify-value">{{ $first_name }}</span>
            </div>
            <div class="verify-field">
                <span class="verify-label">*Last Name :</span>
                <span class="verify-value">{{ $last_name }}</span>
            </div>
            <div class="verify-field">
                <span class="verify-label">*Mobile Number :</span>
                <span class="verify-value">{{ $phone }}</span>
            </div>

            <form method="POST" action="{{ route('qr.submit', ['code' => $qrCode->code]) }}" id="verifyForm">
                @csrf
                <input type="hidden" name="first_name" value="{{ $first_name }}">
                <input type="hidden" name="last_name" value="{{ $last_name }}">
                <input type="hidden" name="phone" value="{{ $phone }}">
                <input type="hidden" name="accept_terms" value="1">

                <div class="verify-buttons">
                    <a href="{{ route('qr.scan', ['code' => $qrCode->code]) }}?edit=1&first_name={{ urlencode($first_name) }}&last_name={{ urlencode($last_name) }}&phone={{ urlencode($phone) }}" class="btn-back">Back</a>
                    <button type="submit" class="btn-verify">Verify</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <div class="help-text">Need help? Just call 077 255 3436.</div>
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

