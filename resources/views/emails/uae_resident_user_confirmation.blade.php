<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UAE resident registration confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 24px; border: 1px solid #e5e7eb;">
        <tr>
            <td>
                <h1 style="font-size: 20px; margin-bottom: 12px; color: #111827;">Thank you for registering as a UAE resident attendee</h1>
                <p style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                    Dear {{ $resident->name }},
                </p>
                <p style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                    We have received your registration for the Tanzania Trade &amp; Logistics Forum as a UAE resident attendee. Our team will review your details and contact you with next steps.
                </p>

                <h2 style="font-size: 14px; margin-top: 20px; margin-bottom: 8px; color: #111827;">Summary of your registration</h2>
                <ul style="font-size: 13px; color: #4b5563; line-height: 1.5; padding-left: 18px;">
                    <li><strong>Attendee type:</strong> {{ $resident->attendee_type }}</li>
                    <li><strong>Name:</strong> {{ $resident->name }}</li>
                    <li><strong>Job title:</strong> {{ $resident->job_title }}</li>
                    <li><strong>City:</strong> {{ $resident->city }}</li>
                    <li><strong>Country of residence:</strong> {{ $resident->country }}</li>
                    <li><strong>Nationality:</strong> {{ $resident->nationality }}</li>
                    <li><strong>Number of attendees with you:</strong> {{ $resident->attendee_count }}</li>
                    <li><strong>Package:</strong> {{ $resident->package }}</li>
                </ul>

                <p style="font-size: 14px; color: #4b5563; line-height: 1.5; margin-top: 16px;">
                    You can view a read-only preview of your registration at any time using the link below:
                </p>

                <p style="margin: 16px 0;">
                    <a href="{{ route('uaeresidents.preview', $resident) }}" style="display: inline-block; padding: 10px 18px; background-color: #059669; color: #ffffff; text-decoration: none; border-radius: 9999px; font-size: 13px;">
                        View your registration
                    </a>
                </p>

                <p style="font-size: 12px; color: #9ca3af; margin-top: 24px;">
                    Status: <strong>{{ ucfirst($resident->status) }}</strong>. You will receive another email once your registration has been approved.
                </p>

                <p style="font-size: 12px; color: #9ca3af; margin-top: 12px;">
                    WNCDi
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
