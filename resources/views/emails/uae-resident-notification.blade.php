<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Diaspora Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 650px; margin: 0 auto; background-color: #ffffff; }
        .header { background-color: #059669; color: white; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px; }
        .intro { background-color: #e0f2f1; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .intro p { margin: 0; font-size: 15px; color: #00695c; font-weight: 500; }
        .section { margin-bottom: 25px; }
        .section-title { background-color: #059669; color: white; padding: 10px 15px; font-weight: bold; font-size: 16px; margin: 0 0 15px 0; border-radius: 5px; }
        .field { background-color: #f9f9f9; padding: 12px 15px; margin-bottom: 10px; border-left: 4px solid #059669; border-radius: 4px; }
        .field-label { font-weight: bold; color: #059669; display: block; font-size: 13px; margin-bottom: 4px; }
        .field-value { color: #333; font-size: 14px; word-wrap: break-word; }
        .days-list { list-style: none; padding: 0; margin: 5px 0 0 0; }
        .days-list li { padding: 5px 0; padding-left: 20px; position: relative; }
        .days-list li:before { content: "✓"; position: absolute; left: 0; color: #059669; font-weight: bold; }
        .status-badge { display: inline-block; padding: 6px 15px; background-color: #fbbf24; color: #92400e; border-radius: 20px; font-weight: bold; font-size: 12px; }
        .footer { background-color: #f9f9f9; text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 3px solid #059669; }
        .footer-link { color: #059669; text-decoration: none; font-weight: bold; }
        
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .content { padding: 15px !important; }
            .section-title { font-size: 14px !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 New Diaspora Registration</h1>
        </div>
        <div class="content">
            <div class="intro">
                <p>You have a new diaspora registration form submission:</p>
            </div>

            <!-- Personal Information -->
            <div class="section">
                <h2 class="section-title">Personal Information</h2>
                
                @if($resident->attendee_type)
                <div class="field">
                    <span class="field-label">Attendee Type</span>
                    <span class="field-value">{{ $resident->attendee_type }}</span>
                </div>
                @endif

                <div class="field">
                    <span class="field-label">Name</span>
                    <span class="field-value">{{ $resident->name }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Email Address</span>
                    <span class="field-value">{{ $resident->email }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Phone</span>
                    <span class="field-value">{{ $resident->phone }}</span>
                </div>

                <div class="field">
                    <span class="field-label">City</span>
                    <span class="field-value">{{ $resident->city }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Country of Residence</span>
                    <span class="field-value">{{ $resident->country }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Nationality</span>
                    <span class="field-value">{{ $resident->nationality }}</span>
                </div>

                @if($resident->passport_number)
                <div class="field">
                    <span class="field-label">Passport Number</span>
                    <span class="field-value">{{ $resident->passport_number }}</span>
                </div>
                @endif

                @if($resident->emirates_id)
                <div class="field">
                    <span class="field-label">Emirates ID</span>
                    <span class="field-value">{{ $resident->emirates_id }}</span>
                </div>
                @endif
            </div>

            <!-- Professional Information -->
            <div class="section">
                <h2 class="section-title">Professional Information</h2>
                
                @if($resident->job_title)
                <div class="field">
                    <span class="field-label">Job Title</span>
                    <span class="field-value">{{ $resident->job_title }}</span>
                </div>
                @endif

                @if($resident->organization)
                <div class="field">
                    <span class="field-label">Organization/Company</span>
                    <span class="field-value">{{ $resident->organization }}</span>
                </div>
                @endif

                @if($resident->website)
                <div class="field">
                    <span class="field-label">Professional Website</span>
                    <span class="field-value"><a href="{{ $resident->website }}" style="color: #059669;">{{ $resident->website }}</a></span>
                </div>
                @endif

                @if($resident->attendance_days && count($resident->attendance_days) > 0)
                <div class="field">
                    <span class="field-label">Attendance Days</span>
                    <ul class="days-list">
                        @foreach($resident->attendance_days as $day)
                            <li class="field-value">{{ $day }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($resident->package)
                <div class="field">
                    <span class="field-label">Package Selected</span>
                    <span class="field-value">{{ $resident->package }}</span>
                </div>
                @endif
            </div>

            <!-- Declaration -->
            <div class="section">
                <h2 class="section-title">Declaration</h2>
                <div class="field">
                    <span class="field-value">{{ $resident->agree_terms ? '✓ Checked' : '✗ Not Checked' }}</span>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="field" style="background-color: #fff3cd; border-left-color: #fbbf24;">
                <span class="field-label">Status</span>
                <span class="status-badge">{{ strtoupper($resident->status) }}</span>
            </div>

            <div class="field">
                <span class="field-label">Submitted</span>
                <span class="field-value">{{ $resident->created_at->format('d M Y, H:i') }}</span>
            </div>

            <p style="text-align: center; margin-top: 25px; font-size: 13px; color: #666;">
                This message was sent from a WNCDi registration system.
            </p>
        </div>
        <div class="footer">
            <p style="margin: 5px 0;"><strong>&copy; {{ date('Y') }} WNCDi. All rights reserved.</strong></p>
            <p style="margin: 5px 0;">Please review and approve/reject this registration in the admin panel.</p>
        </div>
    </div>
</body>
</html>
