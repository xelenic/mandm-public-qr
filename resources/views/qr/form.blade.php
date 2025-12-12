<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>M&M Gift Campaign</title>
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
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 48px;
            color: #667eea;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .logo p {
            color: #6b7280;
            font-size: 16px;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .info-box {
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .info-box p {
            color: #065f46;
            font-size: 14px;
            font-weight: 500;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            .logo h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>M&M</h1>
            <p>Win Exciting Prizes!</p>
        </div>

        <div class="info-box">
            <p>🎁 You've scanned a valid QR code! Enter your details to reveal your gift.</p>
        </div>

        <form action="{{ route('qr.submit', ['code' => $qrCode->code]) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter your full name">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Enter your phone number">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Reveal My Gift 🎉
            </button>
        </form>
    </div>
</body>
</html>



