<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forum Registration Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #059669; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .button { background-color: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 20px 0; }
        .details { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #059669; }
        .details p { margin: 8px 0; }
        .label { font-weight: bold; color: #059669; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registration Approved!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $registration->name }},</p>
            
            <p>Congratulations! Your registration for <strong>{{ $registration->forum_name }}</strong> has been approved.</p>
            
            <div class="details">
                <p><span class="label">Name:</span> {{ $registration->name }}</p>
                <p><span class="label">Email:</span> {{ $registration->email }}</p>
                <p><span class="label">Phone:</span> {{ $registration->phone }}</p>
                <p><span class="label">Organization:</span> {{ $registration->organization }}</p>
                <p><span class="label">Attendee Type:</span> {{ $registration->attendee_type }}</p>
                @if($registration->booth)
                    <p><span class="label">Booth:</span> {{ $registration->booth }}</p>
                @endif
                @if($registration->sponsorship_package)
                    <p><span class="label">Sponsorship Package:</span> {{ $registration->sponsorship_package }}</p>
                @endif
            </div>
            
            <p>We look forward to seeing you at the forum. Further details will be sent to you closer to the event date.</p>
            
            <p>If you have any questions, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>
            <strong>WNCDi Team</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} WNCDi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
