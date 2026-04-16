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
        .details { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #059669; }
        .details p { margin: 8px 0; }
        .label { font-weight: bold; color: #059669; }
        .status-badge { display: inline-block; padding: 5px 15px; background-color: #10b981; color: white; border-radius: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Forum Registration Approved</h1>
        </div>
        <div class="content">
            <p><span class="status-badge">✓ APPROVED</span></p>
            
            <p>A forum registration has been approved:</p>
            
            <div class="details">
                <p><span class="label">Forum:</span> {{ $registration->forum_name }}</p>
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
                <p><span class="label">Status:</span> <strong style="color: #10b981;">Approved</strong></p>
                <p><span class="label">Approved at:</span> {{ date('d M Y, H:i') }}</p>
            </div>
            
            <p>The applicant has been notified via email at <strong>{{ $registration->email }}</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} WNCDi. All rights reserved.</p>
            <p>This is an automated notification from the admin panel.</p>
        </div>
    </div>
</body>
</html>
