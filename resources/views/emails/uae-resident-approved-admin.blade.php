<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diaspora Registration Approved</title>
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
            <h1>Diaspora Registration Approved</h1>
        </div>
        <div class="content">
            <p><span class="status-badge">✓ APPROVED</span></p>
            
            <p>A diaspora registration has been approved:</p>
            
            <div class="details">
                <p><span class="label">Name:</span> {{ $resident->name }}</p>
                <p><span class="label">Email:</span> {{ $resident->email }}</p>
                <p><span class="label">Phone:</span> {{ $resident->phone }}</p>
                <p><span class="label">City:</span> {{ $resident->city }}</p>
                <p><span class="label">Country:</span> {{ $resident->country }}</p>
                <p><span class="label">Nationality:</span> {{ $resident->nationality }}</p>
                @if($resident->package)
                    <p><span class="label">Package:</span> {{ $resident->package }}</p>
                @endif
                <p><span class="label">Status:</span> <strong style="color: #10b981;">Approved</strong></p>
                <p><span class="label">Approved at:</span> {{ date('d M Y, H:i') }}</p>
            </div>
            
            <p>The applicant has been notified via email at <strong>{{ $resident->email }}</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} WNCDi. All rights reserved.</p>
            <p>This is an automated notification from the admin panel.</p>
        </div>
    </div>
</body>
</html>
