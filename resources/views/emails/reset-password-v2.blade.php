<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #f0f0f0;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .logo-text {
            color: #007bff;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
            border-top: 1px solid #e9ecef;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            {{-- Try multiple approaches for the logo --}}
            @php
                $logoPath = public_path('src/assets/img/prometeon.jpg');
                $logoUrl = asset('src/assets/img/prometeon.jpg');
                $logoExists = file_exists($logoPath);
                
                // Try to create a full URL
                $fullLogoUrl = config('app.url') . '/src/assets/img/prometeon.jpg';
            @endphp
            
            {{-- First try: Direct URL (most compatible with email clients) --}}
            <img src="{{ $fullLogoUrl }}" alt="Prometeon Logo" class="logo" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            
            {{-- Fallback: Text logo --}}
            <h1 class="logo-text" style="display: none;">PROMETEON</h1>
        </div>
        
        <div class="content">
            <h2>Password Reset Request</h2>
            
            <p>Hello {{ $notifiable->name ?? 'User' }},</p>
            
            <p>You are receiving this email because we received a password reset request for your account.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button" style="color: white;">Reset Password</a>
            </div>
            
            <div class="warning">
                <strong>Important:</strong> This password reset link will expire in {{ $expireTime }} minutes.
            </div>
            
            <p>If you did not request a password reset, no further action is required. Your password will remain unchanged.</p>
            
            <p>For security reasons, please do not share this email with anyone.</p>
            
            <p>Best regards,<br>The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
            <p style="word-break: break-all; color: #007bff;">{{ $url }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
