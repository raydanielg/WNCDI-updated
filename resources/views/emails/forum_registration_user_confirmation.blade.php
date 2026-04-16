<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forum registration confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 24px; border: 1px solid #e5e7eb;">
        <tr>
            <td>
                <h1 style="font-size: 20px; margin-bottom: 12px; color: #111827;">Thank you for registering for the Tanzania Global Logistics Forum 2025</h1>
                <p style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                    Dear {{ $registration->name }},
                </p>
                <p style="font-size: 14px; color: #4b5563; line-height: 1.5;">
                    We have received your registration for the forum. Our team will review your details and contact you with next steps.
                </p>

                <h2 style="font-size: 14px; margin-top: 20px; margin-bottom: 8px; color: #111827;">Summary of your registration</h2>
                <ul style="font-size: 13px; color: #4b5563; line-height: 1.5; padding-left: 18px;">
                    <li><strong>Forum:</strong> {{ $registration->forum_name }}</li>
                    <li><strong>Attendee type:</strong> {{ $registration->attendee_type }}</li>
                    <li><strong>Name:</strong> {{ $registration->name }}</li>
                    <li><strong>Organization:</strong> {{ $registration->organization }}</li>
                    <li><strong>Job title:</strong> {{ $registration->job_title }}</li>
                    <li><strong>Country of residence:</strong> {{ $registration->country }}</li>
                    <li><strong>Nationality:</strong> {{ $registration->nationality }}</li>
                    <li><strong>Number of attendees from your company:</strong> {{ $registration->attendee_count }}</li>
                </ul>

                <p style="font-size: 14px; color: #4b5563; line-height: 1.5; margin-top: 16px;">
                    You can view a read-only preview of your registration at any time using the link below:
                </p>

                <p style="margin: 16px 0;">
                    <a href="{{ route('forum.register.preview', $registration) }}" style="display: inline-block; padding: 10px 18px; background-color: #059669; color: #ffffff; text-decoration: none; border-radius: 9999px; font-size: 13px;">
                        View your registration
                    </a>
                </p>

                <p style="font-size: 12px; color: #9ca3af; margin-top: 24px;">
                    Status: <strong>{{ ucfirst($registration->status) }}</strong>. You will receive another email once your registration has been approved.
                </p>

                <p style="font-size: 12px; color: #9ca3af; margin-top: 12px;">
                    WNCDi
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
