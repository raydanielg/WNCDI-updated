<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #059669; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background-color: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .success-icon { font-size: 48px; text-align: center; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .info-box { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #059669; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✓ Test Email Successful</h1>
        </div>
        <div class="content">
            <div class="success-icon">✉️</div>
            
            <h2 style="color: #059669; text-align: center;">SMTP Configuration Working!</h2>
            
            <p style="text-align: center; font-size: 16px;">
                Congratulations! Your email configuration is working correctly.
            </p>
            
            <div class="info-box">
                <p><strong>What this means:</strong></p>
                <ul>
                    <li>Your SMTP server settings are correct</li>
                    <li>The application can successfully send emails</li>
                    <li>Email notifications will work properly</li>
                </ul>
            </div>
            
            <p style="text-align: center; color: #666; margin-top: 30px;">
                <strong>Test sent at:</strong> {{ date('d M Y, H:i:s') }}<br>
                <strong>From:</strong> {{ config('mail.from.address') }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} WNCDi. All rights reserved.</p>
            <p>This is an automated test email from your mail configuration.</p>
        </div>
    </div>
</body>
</html>
