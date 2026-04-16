<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to WNCDi</title>
</head>
<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f3f4f6; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; background: #ffffff; border-radius: 16px; padding: 24px; border: 1px solid #e5e7eb;">
                    <tr>
                        <td style="text-align: center; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                            <h1 style="font-size: 20px; font-weight: 700; color: #065f46; margin: 0;">WNCDi Registration</h1>
                            <p style="font-size: 12px; color: #6b7280; margin: 4px 0 0;">Tanzania Freight Forwarders Association - Dubai &amp; Tanzania</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 16px; font-size: 14px; color: #111827;">
                            <p>Dear {{ $member->full_name }},</p>

                            <p>
                                Thank you for submitting your WNCDi registration.
                                Your details have been received and are currently under review.
                            </p>

                            <p>
                                Once your membership is approved, our team will contact you with the next steps
                                We are excited about your interest and look forward to your participation in WNCDi programs and initiatives.
                            </p>

                            <p style="margin-top: 16px; font-weight: 600;">Membership Summary</p>
                            <ul style="padding-left: 20px; font-size: 13px; color: #374151;">
                                <li><strong>Full Name:</strong> {{ $member->full_name }}</li>
                                @if ($member->company_name)
                                    <li><strong>Company:</strong> {{ $member->company_name }}</li>
                                @endif
                                @if ($member->country_of_registration)
                                    <li><strong>Country of Registration:</strong> {{ $member->country_of_registration }}</li>
                                @endif
                                @if ($member->whatsapp)
                                    <li><strong>WhatsApp:</strong> {{ $member->whatsapp }}</li>
                                @endif
                            </ul>

                            <p style="margin-top: 16px;">
                                Thank you for joining us in our mission to improve health and community wellness.
                            </p>

                            <p style="margin-top: 24px; font-size: 12px; color: #6b7280;">
                                With regards,<br>
                                <strong>WNCDi Team</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
