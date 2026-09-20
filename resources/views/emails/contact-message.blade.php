<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Portfolio Inquiry</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f6f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0f172a; padding: 24px 30px; text-align: left;">
                            <h1 style="margin: 0; font-size: 18px; font-weight: 700; color: #ffffff; letter-spacing: 0.5px;">
                                Portfolio Notification
                            </h1>
                            <p style="margin: 4px 0 0 0; font-size: 13px; color: #94a3b8;">
                                New message from your website contact form
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <div style="margin-bottom: 24px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; width: 100px; font-weight: 600;">From:</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 600;">{{ $contactMessage->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Email:</td>
                                        <td style="padding: 6px 0;">
                                            <a href="mailto:{{ $contactMessage->email }}" style="color: #2563eb; text-decoration: none;">
                                                {{ $contactMessage->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Subject:</td>
                                        <td style="padding: 6px 0; color: #0f172a;">{{ $contactMessage->subject ?: 'Portfolio Inquiry' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Received:</td>
                                        <td style="padding: 6px 0; color: #64748b;">
                                            {{ $contactMessage->created_at ? $contactMessage->created_at->format('M d, Y — h:i A') : now()->format('M d, Y — h:i A') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div style="border-top: 1px solid #e2e8f0; padding-top: 20px; margin-bottom: 28px;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700; margin-bottom: 10px;">
                                    Message Body
                                </div>
                                <div style="background-color: #f8fafc; border-left: 4px solid #2563eb; border-radius: 4px; padding: 16px 18px; font-size: 15px; line-height: 1.6; color: #334155;">
                                    {!! nl2br(e($contactMessage->message)) !!}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="text-align: center; margin: 30px 0 10px 0;">
                                <a href="{{ $adminUrl }}" target="_blank" style="display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 26px; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);">
                                    View in Admin Panel &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 18px 30px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                            Hit <strong>Reply</strong> in your email client to respond directly to {{ $contactMessage->name }} (<a href="mailto:{{ $contactMessage->email }}" style="color: #64748b; text-decoration: underline;">{{ $contactMessage->email }}</a>).
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
