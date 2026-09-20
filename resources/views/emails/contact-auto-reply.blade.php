<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for reaching out</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f6f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0f172a; padding: 26px 30px; text-align: left;">
                            <h1 style="margin: 0; font-size: 19px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px;">
                                {{ $siteName }}
                            </h1>
                            <p style="margin: 6px 0 0 0; font-size: 13px; color: #94a3b8;">
                                Message Confirmation &amp; Acknowledgment
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #0f172a;">
                                Hi {{ $contactMessage->name }},
                            </p>
                            <p style="margin: 0 0 16px 0; font-size: 15px; color: #334155; line-height: 1.6;">
                                Thank you for getting in touch! We have successfully received your inquiry and will review your message carefully. You can expect a response as soon as possible.
                            </p>

                            <div style="background-color: #f8fafc; border-left: 4px solid #0ea5e9; border-radius: 4px; padding: 18px; margin: 24px 0;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700; margin-bottom: 12px;">
                                    Summary of your inquiry
                                </div>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; width: 80px; font-weight: 600;">Subject:</td>
                                        <td style="padding: 4px 0; color: #0f172a; font-weight: 500;">{{ $contactMessage->subject ?: 'Portfolio Inquiry' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; color: #64748b; font-weight: 600;">Sent on:</td>
                                        <td style="padding: 4px 0; color: #64748b;">
                                            {{ $contactMessage->created_at ? $contactMessage->created_at->format('M d, Y — h:i A') : now()->format('M d, Y — h:i A') }}
                                        </td>
                                    </tr>
                                </table>
                                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed #cbd5e1; font-size: 14px; color: #334155; line-height: 1.6;">
                                    {!! nl2br(e($contactMessage->message)) !!}
                                </div>
                            </div>

                            <p style="margin: 0 0 12px 0; font-size: 14px; color: #64748b; line-height: 1.6;">
                                If you have any additional information or urgent details to share, feel free to reply directly to this email.
                            </p>

                            <div style="margin-top: 28px; padding-top: 18px; border-top: 1px solid #e2e8f0; font-size: 14px; color: #334155;">
                                Warm regards,<br>
                                <strong>{{ $siteName }}</strong>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 18px 30px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                            &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
