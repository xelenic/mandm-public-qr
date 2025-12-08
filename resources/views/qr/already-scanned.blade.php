<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Claimed - M&M Gift Campaign</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

        h1 {
            font-size: 32px;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 700;
        }

        p {
            color: #6b7280;
            font-size: 16px;
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

        .info-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }

        .info-box strong {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 40px 25px;
            }

            h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="warning-icon">
            ⚠️
        </div>

        <h1>Already Claimed</h1>
        
        <p>
            This QR code has already been scanned and the gift has been claimed
            on <strong>{{ $qrCode->scanned_at->format('M d, Y') }}</strong>.
        </p>

        <p>
            Each QR code can only be used once. If you believe this is an error,
            please contact our support team.
        </p>

        <div class="info-box">
            <strong>QR Code Reference:</strong>
            <p>{{ $qrCode->code }}</p>
        </div>
    </div>
</body>
</html>


