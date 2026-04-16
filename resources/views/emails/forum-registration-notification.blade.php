<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Forum Registration</title>
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
        .services-list, .days-list { list-style: none; padding: 0; margin: 5px 0 0 0; }
        .services-list li, .days-list li { padding: 5px 0; padding-left: 20px; position: relative; }
        .services-list li:before, .days-list li:before { content: "✓"; position: absolute; left: 0; color: #059669; font-weight: bold; }
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
            <h1>📋 New Website Form Submission</h1>
        </div>
        <div class="content">
            <div class="intro">
                <p>You have a new website form submission:</p>
            </div>

            <!-- Attendant Information -->
            <div class="section">
                <h2 class="section-title">Attendant Information</h2>
                
                <div class="field">
                    <span class="field-label">Attendee Type</span>
                    <span class="field-value">{{ $registration->attendee_type ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Name</span>
                    <span class="field-value">{{ $registration->name }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Email Address</span>
                    <span class="field-value">{{ $registration->email }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Phone</span>
                    <span class="field-value">{{ $registration->phone ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">City</span>
                    <span class="field-value">{{ $registration->city ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Country of Residence</span>
                    <span class="field-value">{{ $registration->country ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Nationality</span>
                    <span class="field-value">{{ $registration->nationality ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="section">
                <h2 class="section-title">Professional Information</h2>
                
                <div class="field">
                    <span class="field-label">Organization/Company</span>
                    <span class="field-value">{{ $registration->organization ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Name of the Contact person/company representative for this event</span>
                    <span class="field-value">{{ $registration->contact_person ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">Job Title</span>
                    <span class="field-value">{{ $registration->job_title ?? 'N/A' }}</span>
                </div>

                @if($registration->website)
                <div class="field">
                    <span class="field-label">Professional Website</span>
                    <span class="field-value"><a href="{{ $registration->website }}" style="color: #059669;">{{ $registration->website }}</a></span>
                </div>
                @endif

                <div class="field">
                    <span class="field-label">Mobile number for the Contact person/representative for this event</span>
                    <span class="field-value">{{ $registration->contact_phone ?? 'N/A' }}</span>
                </div>

                <div class="field">
                    <span class="field-label">How many people from your company will be coming to the forum?</span>
                    <span class="field-value">{{ $registration->attendee_count ?? 'N/A' }}</span>
                </div>

                @if($registration->services && count($registration->services) > 0)
                <div class="field">
                    <span class="field-label">Services Rendered</span>
                    <ul class="services-list">
                        @foreach($registration->services as $service)
                            <li class="field-value">{{ $service }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($registration->other_services)
                <div class="field">
                    <span class="field-label">If you checked 'Other' above, specify the services</span>
                    <span class="field-value">{{ $registration->other_services }}</span>
                </div>
                @endif

                @if($registration->attendance_days && count($registration->attendance_days) > 0)
                <div class="field">
                    <span class="field-label">Are you intending to attend for both days or one of the two days?</span>
                    <ul class="days-list">
                        @foreach($registration->attendance_days as $day)
                            <li class="field-value">{{ $day === 'day1' ? 'Day 1 (13th February 2026)' : 'Day 2 (14th February 2026)' }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="field">
                    <span class="field-label">Would you prefer to have a booth to showcase your products/services?</span>
                    <span class="field-value">{{ ucfirst($registration->booth ?? 'N/A') }}</span>
                </div>

                @if($registration->sponsorship_package)
                <div class="field">
                    <span class="field-label">If your choice is 'Yes,' Choose a package for sponsorship</span>
                    <span class="field-value">{{ $registration->sponsorship_package }}</span>
                </div>
                @endif
            </div>

            <!-- Declaration -->
            <div class="section">
                <h2 class="section-title">Declaration</h2>
                <div class="field">
                    <span class="field-value">{{ $registration->agree_terms ? '✓ Checked' : '✗ Not Checked' }}</span>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="field" style="background-color: #fff3cd; border-left-color: #fbbf24;">
                <span class="field-label">Status</span>
                <span class="status-badge">{{ strtoupper($registration->status) }}</span>
            </div>

            <div class="field">
                <span class="field-label">Submitted</span>
                <span class="field-value">{{ $registration->created_at->format('d M Y, H:i') }}</span>
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
