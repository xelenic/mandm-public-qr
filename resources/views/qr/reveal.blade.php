<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations! - M&M Gift Campaign</title>
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
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confetti {
            font-size: 60px;
            margin-bottom: 20px;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        h1 {
            font-size: 42px;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .subtitle {
            color: #6b7280;
            font-size: 18px;
            margin-bottom: 40px;
        }

        .gift-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 3px solid #fbbf24;
            border-radius: 15px;
            padding: 40px 30px;
            margin-bottom: 30px;
        }

        .gift-title {
            font-size: 32px;
            color: #92400e;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .gift-type {
            display: inline-block;
            padding: 8px 20px;
            background: white;
            color: #92400e;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }

        .gift-description {
            color: #78350f;
            font-size: 16px;
            margin-top: 15px;
            line-height: 1.6;
        }

        .info-section {
            background: #f9fafb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
        }

        .info-section h3 {
            color: #374151;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-section p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .code-reference {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .code-reference strong {
            color: #374151;
            font-size: 14px;
        }

        .code-reference code {
            display: inline-block;
            margin-top: 5px;
            padding: 8px 12px;
            background: white;
            color: #667eea;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 40px 25px;
            }

            h1 {
                font-size: 32px;
            }

            .gift-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            ✓
        </div>

        <h1>Congratulations! 🎉</h1>
        <p class="subtitle">You've won an amazing gift!</p>

        <div class="gift-card">
            <div class="gift-title">{{ $qrCode->gift->name }}</div>
            <span class="gift-type">{{ ucfirst($qrCode->gift->type) }}</span>
            
            @if($qrCode->gift->description)
                <p class="gift-description">{{ $qrCode->gift->description }}</p>
            @endif
        </div>

        <div class="info-section">
            <h3>📋 What's Next?</h3>
            <p>
                Our team will contact you within 2-3 business days to arrange the delivery of your gift.
                Please keep your reference code handy for verification.
            </p>

            <div class="code-reference">
                <strong>Your Reference Code:</strong><br>
                <code>{{ $qrCode->code }}</code>
            </div>
        </div>

        <div class="info-section">
            <h3>📞 Need Help?</h3>
            <p>
                If you have any questions or don't receive a call within 3 business days,
                please contact our support team with your reference code.
            </p>
        </div>
    </div>
</body>
</html>








