<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Winners Gallery</title>

    <link rel="stylesheet" href="{{ url('qr_portal') }}/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="{{ url('qr_portal') }}/style(2).css" media="all">

    <style>
        .page-card{
            width: 84%;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .page-back{
            display: inline-block;
            margin-top: 14px;
            color: #5A1F06;
            text-decoration: underline;
            text-underline-offset: 3px;
            font-size: 12px;
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
    <div class="main">
        <div class="header">
            <img src="{{url('qr_portal')}}/5947.png" alt="5947" class="image1">
            <img src="{{url('qr_portal')}}/5946.png" alt="5946" class="image2">
            <a href="https://mmsfestivesurewin.com/">
                <img src="{{url('qr_portal')}}/OL_SG-Xmas-Promo-Masthead-1.png" alt="Logo" class="center-logo">
            </a>
            <img src="{{url('qr_portal')}}/5948.png" alt="5948" class="image3">
            <img src="{{url('qr_portal')}}/5949.png" alt="5949" class="image4">
        </div>

        <div class="container mt-7">
            <h1 class="main-heading">WINNERS <br>GALLERY</h1>

            <div class="page-card">
                <p class="term_text" style="text-align:left; margin-top:0; margin-bottom:0;">
                    Coming Soon Please Check Back Later.
                </p>
                <a href="#" class="page-back" onclick="history.back(); return false;">Back</a>
            </div>

            <div class="footer">
                © 2025 Mars or Affiliates
            </div>
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



